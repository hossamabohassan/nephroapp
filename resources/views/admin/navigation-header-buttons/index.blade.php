<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Manage Header Buttons') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">There were some problems with your input.</span>
                    <ul class="mt-3 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Navigation Header Buttons</h3>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.navigation-header-buttons.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Header Button
                    </a>
                    <form method="POST" action="{{ route('admin.navigation-header-buttons.reset') }}" onsubmit="return confirm('Are you sure you want to reset all header buttons to their default settings? This cannot be undone.');">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8 0 004 12.001V12m6.5-7.5v3.75m0 0h3.75M10.5 4.5L12 3m-1.5 1.5L9 3M12 21V12m0 0h3.75M12 21l-1.5-1.5m1.5 1.5l1.5-1.5"/>
                            </svg>
                            Reset to Defaults
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Icon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Link/Route</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Badge</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($headerButtons as $button)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        {{ $button->sort_order }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        <div class="flex items-center">
                                            {!! $button->icon_html !!}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                        {{ $button->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $button->type === 'button' ? 'bg-blue-100 text-blue-800' : 
                                               ($button->type === 'dropdown' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($button->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        @if($button->route_name)
                                            <code class="bg-slate-100 px-2 py-1 rounded text-xs">{{ $button->route_name }}</code>
                                        @elseif($button->url)
                                            <code class="bg-slate-100 px-2 py-1 rounded text-xs">{{ $button->url }}</code>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        @if($button->show_badge)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $button->badge_color_class }}">
                                                {{ $button->badge_text ?: '●' }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        <label style="position: relative; display: inline-flex; align-items: center; cursor: pointer;">
                                            <input type="hidden" name="is_active" value="0">
                                            <input type="checkbox" 
                                                   {{ $button->is_active ? 'checked' : '' }}
                                                   onchange="toggleStatus({{ $button->id }}, this.checked)"
                                                   style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;">
                                            <div style="width: 44px; height: 24px; background-color: {{ $button->is_active ? '#3b82f6' : '#cbd5e1' }}; border-radius: 12px; position: relative; transition: background-color 0.3s ease;">
                                                <span style="position: absolute; top: 2px; left: {{ $button->is_active ? '22px' : '2px' }}; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: left 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></span>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.navigation-header-buttons.edit', $button->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('admin.navigation-header-buttons.destroy', $button->id) }}" onsubmit="return confirm('Are you sure you want to delete this header button?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-slate-500">
                                        No header buttons found. <button onclick="openAddModal()" class="text-blue-600 hover:text-blue-800">Add your first header button</button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="buttonModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-4">Add Header Button</h3>
                <form id="buttonForm" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" id="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Icon (SVG or Emoji)</label>
                            <textarea name="icon" id="icon" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Paste SVG code or emoji"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" id="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="button">Button</option>
                                <option value="dropdown">Dropdown</option>
                                <option value="modal">Modal</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Route Name</label>
                            <input type="text" name="route_name" id="route_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., profile.edit">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL (if no route)</label>
                            <input type="text" name="url" id="url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., /about">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                            <select name="target" id="target" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="_self">Same Window</option>
                                <option value="_blank">New Window</option>
                                <option value="modal">Modal</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CSS Class</label>
                            <input type="text" name="css_class" id="css_class" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., custom-class">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Badge Text</label>
                                <input type="text" name="badge_text" id="badge_text" maxlength="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., 5">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Badge Color</label>
                                <select name="badge_color" id="badge_color" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="red">Red</option>
                                    <option value="blue">Blue</option>
                                    <option value="green">Green</option>
                                    <option value="yellow">Yellow</option>
                                    <option value="purple">Purple</option>
                                    <option value="pink">Pink</option>
                                    <option value="indigo">Indigo</option>
                                    <option value="gray">Gray</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="show_badge" id="show_badge" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="show_badge" class="ml-2 block text-sm text-gray-900">Show Badge</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Header Button';
            document.getElementById('buttonForm').action = '{{ route("admin.navigation-header-buttons.store") }}';
            document.getElementById('buttonForm').method = 'POST';
            document.getElementById('buttonForm').reset();
            document.getElementById('buttonModal').classList.remove('hidden');
        }

        function openEditModal(buttonId) {
            // This would need to be implemented with AJAX to fetch button data
            // For now, we'll just show the modal
            document.getElementById('modalTitle').textContent = 'Edit Header Button';
            document.getElementById('buttonForm').action = `/admin/navigation-header-buttons/${buttonId}`;
            document.getElementById('buttonForm').method = 'POST';
            document.getElementById('buttonModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('buttonModal').classList.add('hidden');
        }

        function toggleStatus(buttonId, isActive) {
            fetch(`/admin/navigation-header-buttons/${buttonId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    is_active: isActive
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the toggle visually
                    const toggle = event.target.nextElementSibling;
                    const slider = toggle.querySelector('span');
                    
                    if (isActive) {
                        toggle.style.backgroundColor = '#3b82f6';
                        slider.style.left = '22px';
                    } else {
                        toggle.style.backgroundColor = '#cbd5e1';
                        slider.style.left = '2px';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert the toggle
                event.target.checked = !isActive;
            });
        }

        // Close modal when clicking outside
        document.getElementById('buttonModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-admin-layout>
