<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AuthSetting;
use App\Models\User;
use App\Support\AuthSettings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active']);
        $this->middleware('can:manage-users');
    }

    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->filled('role'), fn ($query) => $query->where('role', $request->query('role')))
            ->when($search = $request->string('q')->toString(), function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'filters' => [
                'role' => $request->query('role'),
                'q' => $request->query('q'),
            ],
            'authSettings' => AuthSettings::get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_EDITOR, User::ROLE_MEMBER])],
            'is_active' => ['required', 'boolean'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => (bool) $validated['is_active'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'user.created',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => [
                'role' => $user->role,
                'is_active' => $user->is_active,
            ],
        ]);

        return redirect()->route('admin.users.edit', $user)->with('status', 'User created');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_EDITOR, User::ROLE_MEMBER])],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($user->isAdmin() && $validated['role'] !== User::ROLE_ADMIN) {
            $otherAdmins = User::query()->where('role', User::ROLE_ADMIN)->where('id', '!=', $user->id)->count();
            if ($otherAdmins === 0) {
                return back()->withErrors(['role' => 'At least one administrator must remain.']);
            }
        }

        $user->fill($validated)->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'user.updated',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => [
                'role' => $user->role,
                'is_active' => $user->is_active,
            ],
        ]);

        return redirect()->route('admin.users.edit', $user)->with('status', 'User updated');
    }

    public function updateAuthSettings(Request $request): RedirectResponse
    {
        $settings = AuthSetting::current();

        $settings->fill([
            'allow_email_registration' => $request->boolean('allow_email_registration'),
            'allow_google_auth' => $request->boolean('allow_google_auth'),
        ])->save();

        AuthSettings::refresh();

        return redirect()->back()->with('status', 'Authentication settings updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['user' => 'You cannot remove your own account.']);
        }

        if ($user->isAdmin()) {
            $otherAdmins = User::query()->where('role', User::ROLE_ADMIN)->where('id', '!=', $user->id)->count();
            if ($otherAdmins === 0) {
                return back()->withErrors(['user' => 'At least one administrator must remain.']);
            }
        }

        $user->is_active = false;
        $user->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'user.deactivated',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => [
                'role' => $user->role,
            ],
        ]);

        return redirect()->route('admin.users.index')->with('status', 'User deactivated');
    }
}
