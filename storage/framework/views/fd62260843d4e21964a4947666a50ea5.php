<?php
    $pageTitle = 'Manage Topics';
    $pageDescription = 'Organize and manage all your medical topics';
?>

<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve(['pageTitle' => $pageTitle,'pageDescription' => $pageDescription] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900"><?php echo e($pageTitle); ?></h1>
            <p class="text-sm text-slate-600"><?php echo e($pageDescription); ?></p>
        </div>
        <a href="<?php echo e(route('admin.topics.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
            <?php echo e(__('New Topic')); ?>

        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Topics</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo e($stats['total']); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Published</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo e($stats['published']); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">In Review</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo e($stats['in_review']); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center">
                <div class="p-2 bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Drafts</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo e($stats['drafts']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <form method="GET" action="<?php echo e(route('admin.topics.index')); ?>" class="grid gap-4 md:grid-cols-4">
                    <div class="md:col-span-2">
                        <label for="q" class="block text-sm font-medium text-gray-700"><?php echo e(__('Search')); ?></label>
                        <input id="q" name="q" type="text" value="<?php echo e($filters['q']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="<?php echo e(__('Search by title or slug')); ?>">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700"><?php echo e(__('Status')); ?></label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value=""><?php echo e(__('All statuses')); ?></option>
                            <option value="draft" <?php if($filters['status'] === 'draft'): echo 'selected'; endif; ?>><?php echo e(__('Draft')); ?></option>
                            <option value="review" <?php if($filters['status'] === 'review'): echo 'selected'; endif; ?>><?php echo e(__('Review')); ?></option>
                            <option value="published" <?php if($filters['status'] === 'published'): echo 'selected'; endif; ?>><?php echo e(__('Published')); ?></option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <?php echo e(__('Apply')); ?>

                        </button>
                    </div>
                </form>
            </div>

        <!-- Bulk Actions Form -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-4" id="bulk-actions-form" style="display: none;">
            <form action="<?php echo e(route('admin.topics.bulk-action')); ?>" method="POST" id="bulk-form">
                <?php echo csrf_field(); ?>
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700"><?php echo e(__('With selected:')); ?></span>
                        <span id="selected-count" class="text-sm text-blue-600 font-medium">0 selected</span>
                    </div>
                    
                    <select name="action" id="bulk-action" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value=""><?php echo e(__('Choose action')); ?></option>
                        <option value="publish"><?php echo e(__('Publish')); ?></option>
                        <option value="unpublish"><?php echo e(__('Unpublish')); ?></option>
                        <option value="draft"><?php echo e(__('Move to Draft')); ?></option>
                        <option value="review"><?php echo e(__('Move to Review')); ?></option>
                        <option value="change_category"><?php echo e(__('Change Category')); ?></option>
                        <option value="delete"><?php echo e(__('Delete')); ?></option>
                    </select>
                    
                    <select name="category_id" id="bulk-category" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" style="display: none;">
                        <option value=""><?php echo e(__('Select Category')); ?></option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                        <?php echo e(__('Apply')); ?>

                    </button>
                    
                    <button type="button" id="cancel-bulk" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none transition">
                        <?php echo e(__('Cancel')); ?>

                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Title')); ?></th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Slug')); ?></th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Category')); ?></th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Status')); ?></th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Updated')); ?></th>
                                <th class="px-3 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            <?php $__empty_1 = true; $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $statusClasses = match ($topic->status) {
                                        'published' => 'bg-green-100 text-green-800',
                                        'review' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                ?>
                                <tr>
                                    <td class="px-3 py-3">
                                        <input type="checkbox" name="topics[]" value="<?php echo e($topic->id); ?>" class="topic-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="font-medium text-gray-900"><?php echo e($topic->title); ?></div>
                                        <div class="text-gray-500 text-xs"><?php echo e($topic->template?->name ?? __('Default template')); ?></div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-500"><?php echo e($topic->slug); ?></td>
                                    <td class="px-3 py-3 text-gray-500"><?php echo e($topic->category?->name ?? __('Uncategorized')); ?></td>
                                    <td class="px-3 py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusClasses); ?>">
                                            <?php echo e(ucfirst($topic->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-gray-500"><?php echo e($topic->updated_at->diffForHumans()); ?></td>
                                    <td class="px-3 py-3 text-right space-x-2">
                                        <a href="<?php echo e(route('topics.show', $topic)); ?>" class="text-green-600 hover:text-green-800"><?php echo e(__('Preview')); ?></a>
                                        <a href="<?php echo e(route('admin.topics.wysiwyg', $topic)); ?>" class="text-purple-600 hover:text-purple-800"><?php echo e(__('WYSIWYG')); ?></a>
                                        <a href="<?php echo e(route('admin.topics.edit', $topic)); ?>" class="text-indigo-600 hover:text-indigo-800"><?php echo e(__('Edit')); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-3 py-6 text-center text-gray-500"><?php echo e(__('No topics found.')); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($topics->links()); ?>

            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const topicCheckboxes = document.querySelectorAll('.topic-checkbox');
            const bulkActionsForm = document.getElementById('bulk-actions-form');
            const selectedCountSpan = document.getElementById('selected-count');
            const bulkActionSelect = document.getElementById('bulk-action');
            const bulkCategorySelect = document.getElementById('bulk-category');
            const cancelBulkBtn = document.getElementById('cancel-bulk');
            const bulkForm = document.getElementById('bulk-form');

            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.topic-checkbox:checked');
                const count = checkedBoxes.length;
                
                selectedCountSpan.textContent = count === 1 ? '1 selected' : `${count} selected`;
                
                if (count > 0) {
                    bulkActionsForm.style.display = 'block';
                } else {
                    bulkActionsForm.style.display = 'none';
                    bulkActionSelect.value = '';
                    bulkCategorySelect.style.display = 'none';
                }
            }

            // Select all functionality
            selectAllCheckbox.addEventListener('change', function() {
                topicCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });

            // Individual checkbox functionality
            topicCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedBoxes = document.querySelectorAll('.topic-checkbox:checked');
                    selectAllCheckbox.checked = checkedBoxes.length === topicCheckboxes.length;
                    selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < topicCheckboxes.length;
                    updateSelectedCount();
                });
            });

            // Show/hide category selector based on action
            bulkActionSelect.addEventListener('change', function() {
                if (this.value === 'change_category') {
                    bulkCategorySelect.style.display = 'block';
                    bulkCategorySelect.required = true;
                } else {
                    bulkCategorySelect.style.display = 'none';
                    bulkCategorySelect.required = false;
                }
            });

            // Cancel bulk actions
            cancelBulkBtn.addEventListener('click', function() {
                selectAllCheckbox.checked = false;
                topicCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateSelectedCount();
            });

            // Form submission with confirmation
            bulkForm.addEventListener('submit', function(e) {
                const action = bulkActionSelect.value;
                const checkedBoxes = document.querySelectorAll('.topic-checkbox:checked');
                
                if (!action) {
                    e.preventDefault();
                    alert('Please select an action to perform.');
                    return;
                }

                if (checkedBoxes.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one topic.');
                    return;
                }

                // Add confirmation for destructive actions
                if (action === 'delete') {
                    if (!confirm(`Are you sure you want to delete ${checkedBoxes.length} topic(s)? This action cannot be undone.`)) {
                        e.preventDefault();
                        return;
                    }
                }

                // Add selected topics to form
                checkedBoxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'topics[]';
                    input.value = checkbox.value;
                    this.appendChild(input);
                });
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/admin/topics/index.blade.php ENDPATH**/ ?>