<?php
    $pageTitle = 'Topic Details: ' . $topic->title;
    $pageDescription = 'Preview and review topic content';
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
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.topics.wysiwyg', $topic)); ?>" class="inline-flex items-center px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <?php echo e(__('WYSIWYG Editor')); ?>

            </a>
            <a href="<?php echo e(route('admin.topics.edit', $topic)); ?>" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <?php echo e(__('Edit Topic')); ?>

            </a>
            <a href="<?php echo e(route('topics.show', $topic)); ?>" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <?php echo e(__('Preview as Member')); ?>

            </a>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4 text-sm text-slate-600">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <p class="uppercase text-xs text-gray-400"><?php echo e(__('Slug')); ?></p>
                        <p class="text-gray-900 font-medium"><?php echo e($topic->slug); ?></p>
                    </div>
                    <div>
                        <p class="uppercase text-xs text-gray-400"><?php echo e(__('Status')); ?></p>
                        <p class="text-gray-900 font-medium"><?php echo e(ucfirst($topic->status)); ?></p>
                    </div>
                    <div>
                        <p class="uppercase text-xs text-gray-400"><?php echo e(__('Template')); ?></p>
                        <p class="text-gray-900 font-medium"><?php echo e($topic->template?->name ?? __('Default template')); ?></p>
                    </div>
                    <div>
                        <p class="uppercase text-xs text-gray-400"><?php echo e(__('Category')); ?></p>
                        <p class="text-gray-900 font-medium"><?php echo e($topic->category?->name ?? __('Uncategorized')); ?></p>
                    </div>
                    <div>
                        <p class="uppercase text-xs text-gray-400"><?php echo e(__('Published at')); ?></p>
                        <p class="text-gray-900 font-medium"><?php echo e(optional($topic->published_at)->format('M d, Y H:i') ?? __('Not published')); ?></p>
                    </div>
                    <div>
                        <p class="uppercase text-xs text-gray-400"><?php echo e(__('Created by')); ?></p>
                        <p class="text-gray-900 font-medium"><?php echo e($topic->creator?->name ?? __('Unknown')); ?></p>
                    </div>
                    <div>
                        <p class="uppercase text-xs text-gray-400"><?php echo e(__('Last updated by')); ?></p>
                        <p class="text-gray-900 font-medium"><?php echo e($topic->editor?->name ?? __('Unknown')); ?></p>
                    </div>
                </div>
            </div>

            <?php ($renderedSrcdoc = htmlspecialchars($rendered, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')); ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <iframe
                    title="<?php echo e(__('Topic preview')); ?>"
                    class="w-full border-0"
                    style="min-height:80vh;"
                    loading="lazy"
                    srcdoc="<?php echo e($renderedSrcdoc); ?>">
                </iframe>
            </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 text-sm text-slate-500 space-y-4">
                <details open>
                    <summary class="cursor-pointer font-semibold text-slate-700"><?php echo e(__('Raw JSON payload')); ?></summary>
                    <pre class="mt-3 overflow-auto text-xs bg-slate-100 p-4 rounded"><?php echo e(json_encode($topic->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); ?></pre>
                </details>

                <?php if($topic->meta): ?>
                    <details>
                        <summary class="cursor-pointer font-semibold text-slate-700"><?php echo e(__('Meta')); ?></summary>
                        <pre class="mt-3 overflow-auto text-xs bg-slate-100 p-4 rounded"><?php echo e(json_encode($topic->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); ?></pre>
                    </details>
                <?php endif; ?>
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
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/admin/topics/show.blade.php ENDPATH**/ ?>