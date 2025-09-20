<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's favorite topics.
     */
    public function favorites(Request $request): View
    {
        $user = $request->user();
        
        $favorites = $user->favoriteTopics()
            ->published()
            ->with(['category'])
            ->paginate(12);

        $stats = [
            'favorites_count' => $user->favorites()->count(),
            'completed_count' => $user->completed()->count(),
        ];

        return view('profile.favorites', [
            'user' => $user,
            'favorites' => $favorites,
            'stats' => $stats,
        ]);
    }

    /**
     * Display the user's completed topics.
     */
    public function completed(Request $request): View
    {
        $user = $request->user();
        
        $completed = $user->completedTopics()
            ->published()
            ->with(['category'])
            ->paginate(12);

        $stats = [
            'favorites_count' => $user->favorites()->count(),
            'completed_count' => $user->completed()->count(),
        ];

        return view('profile.completed', [
            'user' => $user,
            'completed' => $completed,
            'stats' => $stats,
        ]);
    }
}
