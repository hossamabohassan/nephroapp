<?php
    $pageTitle = 'Page Content';
    $pageDescription = 'Manage dynamic text content across your website';
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
    
    <form method="POST" action="<?php echo e(route('admin.content.update')); ?>" class="space-y-8">
        <?php echo csrf_field(); ?>

        <?php $__currentLoopData = $groupedSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName => $sections): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="border-b border-slate-200 pb-4 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 capitalize">
                        <?php echo e(str_replace('_', ' ', $groupName)); ?> Content
                    </h3>
                    <p class="text-sm text-slate-600 mt-1">
                        <?php switch($groupName):
                            case ('general'): ?>
                                Site-wide content that appears across multiple pages
                                <?php break; ?>
                            <?php case ('homepage'): ?>
                                Content specific to the homepage hero section
                                <?php break; ?>
                            <?php case ('contact'): ?>
                                Contact information and communication details
                                <?php break; ?>
                            <?php default: ?>
                                Content for the <?php echo e($groupName); ?> section
                        <?php endswitch; ?>
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="space-y-2">
                            <label for="content_<?php echo e($section['key']); ?>" class="block text-sm font-medium text-slate-700">
                                <?php echo e($section['title']); ?>

                                <?php if(isset($section['updated_at'])): ?>
                                    <span class="text-xs text-slate-500 font-normal ml-2">
                                        Updated <?php echo e($section['updated_at']->diffForHumans()); ?>

                                    </span>
                                <?php endif; ?>
                            </label>
                            
                            <?php if($section['description']): ?>
                                <p class="text-xs text-slate-500"><?php echo e($section['description']); ?></p>
                            <?php endif; ?>

                            <?php switch($section['type']):
                                case ('textarea'): ?>
                                    <textarea 
                                        id="content_<?php echo e($section['key']); ?>" 
                                        name="content[<?php echo e($section['key']); ?>]" 
                                        rows="3"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['content.'.$section['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="<?php echo e($section['value']); ?>"><?php echo e(old('content.'.$section['key'], $section['value'])); ?></textarea>
                                    <?php break; ?>
                                
                                <?php case ('email'): ?>
                                    <input 
                                        type="email" 
                                        id="content_<?php echo e($section['key']); ?>" 
                                        name="content[<?php echo e($section['key']); ?>]" 
                                        value="<?php echo e(old('content.'.$section['key'], $section['value'])); ?>"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['content.'.$section['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="<?php echo e($section['value']); ?>">
                                    <?php break; ?>
                                
                                <?php default: ?>
                                    <input 
                                        type="text" 
                                        id="content_<?php echo e($section['key']); ?>" 
                                        name="content[<?php echo e($section['key']); ?>]" 
                                        value="<?php echo e(old('content.'.$section['key'], $section['value'])); ?>"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['content.'.$section['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="<?php echo e($section['value']); ?>">
                            <?php endswitch; ?>

                            <?php $__errorArgs = ['content.'.$section['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-slate-600">Changes are applied immediately across your website</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="<?php echo e(route('topics.index')); ?>" target="_blank" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Preview Site
                    </a>
                    
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save All Changes
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Content Usage Examples -->
    <div class="bg-blue-50 rounded-xl border border-blue-200 p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-900 mb-2">How to Use Dynamic Content</h4>
                <div class="text-sm text-blue-800 space-y-2">
                    <p>• <strong>Site Name</strong> appears in the header and browser title</p>
                    <p>• <strong>Hero Content</strong> is displayed on the homepage banner</p>
                    <p>• <strong>Contact Email</strong> is used in footers and contact forms</p>
                    <p>• Content is cached for performance - changes may take a few minutes to appear</p>
                </div>
            </div>
        </div>
    </div>

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
<?php /**PATH /homepages/38/d4299336130/htdocs/resources/views/admin/content/index.blade.php ENDPATH**/ ?>