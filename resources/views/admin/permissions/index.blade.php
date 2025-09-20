@php
    $pageTitle = 'Permissions & Roles';
    $pageDescription = 'Manage user permissions and role-based access control';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">
    
    <!-- Role Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Admin Users</p>
                    <p class="text-3xl font-bold text-slate-900">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Full system access</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Editors</p>
                    <p class="text-3xl font-bold text-slate-900">{{ \App\Models\User::where('role', 'editor')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Content management</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Members</p>
                    <p class="text-3xl font-bold text-slate-900">{{ \App\Models\User::where('role', 'member')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Basic access</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Descriptions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Admin Role -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Administrator</h3>
                    <p class="text-sm text-slate-500">Full system access</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">Manage all users and permissions</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">Full content management</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">System settings access</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">View activity logs</span>
                </div>
            </div>
        </div>

        <!-- Editor Role -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Editor</h3>
                    <p class="text-sm text-slate-500">Content management</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">Create and edit topics</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">Manage categories</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">Edit page content</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="text-slate-500">No user management</span>
                </div>
            </div>
        </div>

        <!-- Member Role -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Member</h3>
                    <p class="text-sm text-slate-500">Basic access</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">View published topics</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">Access learning materials</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-slate-700">Update own profile</span>
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="text-slate-500">No admin access</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Matrix -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
        <div class="border-b border-slate-200 pb-4 mb-6">
            <h3 class="text-lg font-semibold text-slate-900">Permission Matrix</h3>
            <p class="text-sm text-slate-600 mt-1">Overview of what each role can do in the system</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-3 px-4 font-medium text-slate-900">Permission</th>
                        <th class="text-center py-3 px-4 font-medium text-slate-900">Admin</th>
                        <th class="text-center py-3 px-4 font-medium text-slate-900">Editor</th>
                        <th class="text-center py-3 px-4 font-medium text-slate-900">Member</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-3 px-4 text-sm text-slate-700">Access Admin Panel</td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr class="bg-slate-50">
                        <td class="py-3 px-4 text-sm text-slate-700">Manage Users</td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 text-sm text-slate-700">Create/Edit Topics</td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr class="bg-slate-50">
                        <td class="py-3 px-4 text-sm text-slate-700">Manage Categories</td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 text-sm text-slate-700">Edit Page Content</td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr class="bg-slate-50">
                        <td class="py-3 px-4 text-sm text-slate-700">System Settings</td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 text-sm text-slate-700">View Activity Logs</td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </td>
                    </tr>
                    <tr class="bg-slate-50">
                        <td class="py-3 px-4 text-sm text-slate-700">View Published Content</td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="border-b border-slate-200 pb-4 mb-6">
            <h3 class="text-lg font-semibold text-slate-900">Quick Actions</h3>
            <p class="text-sm text-slate-600 mt-1">Common permission management tasks</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 border border-slate-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-slate-900 group-hover:text-blue-900">Manage Users</h4>
                    <p class="text-sm text-slate-500">View and edit user roles</p>
                </div>
            </a>

            <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 border border-slate-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-colors group">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-slate-900 group-hover:text-green-900">Create User</h4>
                    <p class="text-sm text-slate-500">Add new system user</p>
                </div>
            </a>

            <a href="{{ route('admin.activity.index') }}" class="flex items-center p-4 border border-slate-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-colors group">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-200 transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-slate-900 group-hover:text-purple-900">Activity Logs</h4>
                    <p class="text-sm text-slate-500">Monitor user actions</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Security Notice -->
    <div class="mt-8 bg-amber-50 rounded-xl border border-amber-200 p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-amber-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-amber-900 mb-2">Security Best Practices</h4>
                <div class="text-sm text-amber-800 space-y-1">
                    <p>• Grant users the minimum permissions needed for their role</p>
                    <p>• Regularly review user access and remove unused accounts</p>
                    <p>• Monitor activity logs for unusual behavior</p>
                    <p>• Only assign admin roles to trusted users</p>
                    <p>• Consider using two-factor authentication for admin accounts</p>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
