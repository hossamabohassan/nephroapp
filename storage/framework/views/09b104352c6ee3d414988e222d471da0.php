<?php
    $pageTitle = 'Navigation Sections';
    $pageDescription = 'Control which navigation sections appear in the quick navigation overlay on topic pages';
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
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Navigation Sections</h1>
            <p class="text-slate-600 mt-1">Control which sections appear in the floating quick navigation on topic pages</p>
        </div>
        <form method="POST" action="<?php echo e(route('admin.navigation-sections.reset')); ?>" class="inline">
            <?php echo csrf_field(); ?>
            <button type="submit" 
                    onclick="return confirm('Are you sure you want to reset all navigation sections to defaults? This will clear your current settings.')"
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors duration-200">
                Reset to Defaults
            </button>
        </form>
    </div>

    <form method="POST" action="<?php echo e(route('admin.navigation-sections.update')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Quick Navigation Sections</h3>
                <p class="text-sm text-slate-600 mt-1">
                    Enable or disable navigation sections and customize their appearance. Only active sections will appear in the floating navigation overlay.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-slate-200 rounded-lg p-4 <?php echo e($section->is_active ? 'bg-green-50 border-green-200' : 'bg-slate-50'); ?>">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-lg">
                                    <?php echo e($section->icon); ?>

                                </div>
                                <div>
                                    <h4 class="font-medium text-slate-900"><?php echo e($section->title); ?></h4>
                                    <p class="text-xs text-slate-500"><?php echo e($section->id); ?></p>
                                </div>
                            </div>
                            <label style="position: relative; display: inline-flex; align-items: center; cursor: pointer;">
                                <input type="hidden" name="sections[<?php echo e($section->id); ?>][is_active]" value="0">
                                <input type="checkbox" 
                                       name="sections[<?php echo e($section->id); ?>][is_active]" 
                                       value="1" 
                                       <?php echo e($section->is_active ? 'checked' : ''); ?>

                                       style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;"
                                       onchange="toggleSwitch(this)">
                                <div style="width: 44px; height: 24px; background-color: <?php echo e($section->is_active ? '#3b82f6' : '#cbd5e1'); ?>; border-radius: 12px; position: relative; transition: background-color 0.3s ease;">
                                    <span style="position: absolute; top: 2px; left: <?php echo e($section->is_active ? '22px' : '2px'); ?>; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: left 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                                <input type="text" 
                                       name="sections[<?php echo e($section->id); ?>][title]" 
                                       value="<?php echo e($section->title); ?>"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Icon</label>
                                <input type="text" 
                                       name="sections[<?php echo e($section->id); ?>][icon]" 
                                       value="<?php echo e($section->icon); ?>"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Sort Order</label>
                                <input type="number" 
                                       name="sections[<?php echo e($section->id); ?>][sort_order]" 
                                       value="<?php echo e($section->sort_order); ?>"
                                       min="0"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                Save Changes
            </button>
        </div>
    </form>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h4 class="font-medium text-blue-900 mb-2">💡 Tips</h4>
        <ul class="text-sm text-blue-800 space-y-1">
            <li>• Only sections with the toggle enabled will appear in the floating navigation</li>
            <li>• Sort order determines the display order (lower numbers appear first)</li>
            <li>• You can customize the title and icon for each section</li>
            <li>• Changes take effect immediately on topic pages</li>
            <li>• Use the "Reset to Defaults" button to restore original settings</li>
        </ul>
    </div>

    <script>
        function toggleSwitch(checkbox) {
            const toggle = checkbox.nextElementSibling;
            const slider = toggle.querySelector('span');
            
            if (checkbox.checked) {
                toggle.style.backgroundColor = '#3b82f6';
                slider.style.left = '22px';
            } else {
                toggle.style.backgroundColor = '#cbd5e1';
                slider.style.left = '2px';
            }
        }
    </script>
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
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/admin/navigation-sections/index.blade.php ENDPATH**/ ?>