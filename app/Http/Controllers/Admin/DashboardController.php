<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active']);
        $this->middleware('can:access-admin');
    }

    public function __invoke(): View
    {
        $topicCounts = [
            'total' => Topic::query()->count(),
            'published' => Topic::query()->where('status', Topic::STATUS_PUBLISHED)->count(),
            'drafts' => Topic::query()->where('status', Topic::STATUS_DRAFT)->count(),
            'review' => Topic::query()->where('status', Topic::STATUS_REVIEW)->count(),
        ];

        $userCounts = [
            'total' => User::query()->count(),
            'active' => User::query()->where('is_active', true)->count(),
            'admins' => User::query()->where('role', User::ROLE_ADMIN)->count(),
        ];

        return view('admin.dashboard', [
            'topicCounts' => $topicCounts,
            'userCounts' => $userCounts,
            'recentTopics' => Topic::query()->latest('updated_at')->limit(5)->get(),
            'recentActivity' => ActivityLog::query()->with('user')->latest()->limit(10)->get(),
        ]);
    }
}
