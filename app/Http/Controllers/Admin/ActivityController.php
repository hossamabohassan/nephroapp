<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Contracts\View\View;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active']);
        $this->middleware('can:view-activity');
    }

    public function index(): View
    {
        $activities = ActivityLog::query()
            ->with('user')
            ->latest()
            ->paginate(50);

        return view('admin.activity.index', [
            'activities' => $activities,
        ]);
    }
}
