@php
    $pageTitle = 'Activity Logs';
    $pageDescription = 'Monitor system activity and user actions';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Activities</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $activities->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Today</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $activities->where('created_at', '>=', today())->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Activities today</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">This Week</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $activities->where('created_at', '>=', now()->startOfWeek())->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Last 7 days</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Active Users</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $activities->unique('user_id')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Unique users</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
        <form method="GET" action="{{ route('admin.activity.index') }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="search" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Search activities..." 
                           class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <select name="timeframe" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Time</option>
                    <option value="today" {{ request('timeframe') === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('timeframe') === 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ request('timeframe') === 'month' ? 'selected' : '' }}>This Month</option>
                </select>
                
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                    Filter
                </button>
                
                @if(request()->hasAny(['q', 'timeframe']))
                    <a href="{{ route('admin.activity.index') }}" class="inline-flex items-center px-3 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Activity Log Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            User & Action
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Details
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            IP Address
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Time
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($activities as $activity)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center mr-4">
                                        @if($activity->user)
                                            <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($activity->user->name) }}&background=6366f1&color=ffffff" alt="{{ $activity->user->name }}">
                                        @else
                                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $activity->user?->name ?? 'System' }}
                                        </div>
                                        <div class="text-sm text-slate-500">
                                            {{ $activity->action }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($activity->details)
                                    <div class="text-sm text-slate-900 max-w-xs">
                                        @if(is_array($activity->details))
                                            @foreach($activity->details as $key => $value)
                                                <div class="mb-1">
                                                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                    <span class="text-slate-600">{{ is_string($value) ? $value : json_encode($value) }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            {{ $activity->details }}
                                        @endif
                                    </div>
                                @else
                                    <span class="text-slate-400 text-sm">No additional details</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="text-sm text-slate-600 bg-slate-100 px-2 py-1 rounded">
                                    {{ $activity->ip_address ?? 'Unknown' }}
                                </code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900">
                                    {{ $activity->created_at->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-slate-500">
                                    {{ $activity->created_at->format('h:i A') }}
                                </div>
                                <div class="text-xs text-slate-400">
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <h3 class="text-lg font-medium text-slate-900 mb-2">No activity logs found</h3>
                                    <p class="text-slate-500">
                                        @if(request()->hasAny(['q', 'timeframe']))
                                            No activities match your search criteria.
                                        @else
                                            Activity logs will appear here as users interact with the system.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div class="bg-white px-6 py-3 border-t border-slate-200">
                {{ $activities->links() }}
            </div>
        @endif
    </div>

    <!-- Activity Summary -->
    <div class="mt-8 bg-blue-50 rounded-xl border border-blue-200 p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-900 mb-2">Activity Monitoring</h4>
                <div class="text-sm text-blue-800 space-y-1">
                    <p>• All user actions and system events are automatically logged</p>
                    <p>• Activity logs help track changes and monitor system usage</p>
                    <p>• Logs are retained for security and audit purposes</p>
                    <p>• Use filters to find specific activities or time periods</p>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
