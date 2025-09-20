<?php
    $pageTitle = 'Create Topic';
    $pageDescription = 'Create a new medical topic from ChatGPT JSON payload';
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

    <div class="space-y-6" id="topicStudio" data-preview-url="<?php echo e(route('admin.topics.preview')); ?>">
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <p class="font-semibold"><?php echo e(__('Please fix the highlighted errors.')); ?></p>
                </div>
            <?php endif; ?>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,0.9fr)]">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-6">
                    <form method="POST" action="<?php echo e(route('admin.topics.store')); ?>" class="space-y-6" id="topicForm">
                        <?php echo csrf_field(); ?>

                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                            <div class="text-sm text-gray-500">
                                <?php echo e(__('Paste a JSON payload from ChatGPT, auto-fill the fields, preview, then save.')); ?>

                            </div>
                            <div class="flex gap-2">
                                <button type="button" id="autofillFromJson" class="inline-flex items-center px-3 py-2 border border-indigo-200 text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <?php echo e(__('Fill from JSON')); ?>

                                </button>
                                <button type="button" id="previewTopic" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <?php echo e(__('Preview')); ?>

                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="data" class="block text-sm font-medium text-gray-700"><?php echo e(__('Topic JSON Payload')); ?></label>
                            <textarea id="data" name="data" rows="16" class="mt-1 font-mono text-sm block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="<?php echo e(__('Paste the JSON payload here')); ?>" required><?php echo e(old('data')); ?></textarea>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('data'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('data')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700"><?php echo e(__('Title')); ?></label>
                                <input id="title" name="title" type="text" value="<?php echo e(old('title')); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="off" required>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('title'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('title')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700"><?php echo e(__('Slug')); ?></label>
                                <input id="slug" name="slug" type="text" value="<?php echo e(old('slug')); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="off" required>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('slug'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('slug')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div>
                                <label for="subtitle" class="block text-sm font-medium text-gray-700"><?php echo e(__('Subtitle')); ?></label>
                                <input id="subtitle" name="subtitle" type="text" value="<?php echo e(old('subtitle')); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('subtitle'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('subtitle')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700"><?php echo e(__('Status')); ?></label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="draft" <?php if(old('status', 'draft') === 'draft'): echo 'selected'; endif; ?>><?php echo e(__('Draft')); ?></option>
                                    <option value="review" <?php if(old('status') === 'review'): echo 'selected'; endif; ?>><?php echo e(__('Review')); ?></option>
                                    <option value="published" <?php if(old('status') === 'published'): echo 'selected'; endif; ?>><?php echo e(__('Published')); ?></option>
                                </select>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('status'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('status')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div>
                                <label for="template_id" class="block text-sm font-medium text-gray-700"><?php echo e(__('Template')); ?></label>
                                <select id="template_id" name="template_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value=""><?php echo e(__('Default template')); ?></option>
                                    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($template->id); ?>" <?php if(old('template_id') == $template->id): echo 'selected'; endif; ?>><?php echo e($template->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('template_id'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('template_id')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700"><?php echo e(__('Category')); ?></label>
                                <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value=""><?php echo e(__('Uncategorized')); ?></option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if(old('category_id') == $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('category_id'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('category_id')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div>
                                <label for="summary" class="block text-sm font-medium text-gray-700"><?php echo e(__('Summary (HTML)')); ?></label>
                                <textarea id="summary" name="summary" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><?php echo e(old('summary')); ?></textarea>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('summary'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('summary')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>
                        </div>

                        <div>
                            <label for="meta" class="block text-sm font-medium text-gray-700"><?php echo e(__('Meta (optional JSON)')); ?></label>
                            <textarea id="meta" name="meta" rows="6" class="mt-1 font-mono text-sm block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><?php echo e(old('meta')); ?></textarea>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('meta'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('meta')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="publish" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" <?php if(old('publish', false)): echo 'checked'; endif; ?>>
                                <span class="ms-2 text-sm text-gray-700"><?php echo e(__('Publish immediately')); ?></span>
                            </label>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                                <?php echo e(__('Save Topic')); ?>

                            </button>
                        </div>
                    </form>
                </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900"><?php echo e(__('Live Preview')); ?></h3>
                        <p class="text-sm text-gray-500"><?php echo e(__('Use “Preview” to render the current JSON with the selected template.')); ?></p>
                    </div>
                    <div id="previewStatus" class="hidden rounded-md border px-4 py-2 text-sm"></div>
                    <iframe id="previewFrame" title="Live preview" class="w-full bg-gray-50 border border-dashed border-gray-200 rounded-lg" style="min-height:65vh;"></iframe>
                </div>
        </div>
    </div>

    <script>
        (function () {
            const studio = document.getElementById('topicStudio');
            if (!studio) return;

            const previewUrl = studio.dataset.previewUrl;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const form = document.getElementById('topicForm');
            const jsonField = document.getElementById('data');
            const metaField = document.getElementById('meta');
            const titleField = document.getElementById('title');
            const slugField = document.getElementById('slug');
            const subtitleField = document.getElementById('subtitle');
            const summaryField = document.getElementById('summary');
            const templateField = document.getElementById('template_id');
            const autofillBtn = document.getElementById('autofillFromJson');
            const previewBtn = document.getElementById('previewTopic');
            const statusBox = document.getElementById('previewStatus');
            const frame = document.getElementById('previewFrame');

            const setFrameContent = (html) => {
                if (!frame) return;
                frame.srcdoc = `<!doctype html><html><head><base target="_blank"></head><body class="p-6 text-sm text-gray-700">${html}</body></html>`;
            };

            setFrameContent(`<p><?php echo e(__('Preview output will appear here.')); ?></p>`);

            const setStatus = (message, variant = 'info') => {
                if (!statusBox) return;
                const baseClasses = 'rounded-md border px-4 py-2 text-sm';
                const variants = {
                    info: 'border-blue-200 bg-blue-50 text-blue-700',
                    success: 'border-green-200 bg-green-50 text-green-700',
                    error: 'border-red-200 bg-red-50 text-red-700'
                };
                statusBox.className = `${baseClasses} ${variants[variant] ?? variants.info}`;
                statusBox.textContent = message;
                statusBox.classList.remove('hidden');
            };

            const clearStatus = () => {
                if (!statusBox) return;
                statusBox.classList.add('hidden');
                statusBox.textContent = '';
            };

            const parseJsonField = () => {
                const raw = jsonField.value.trim();
                if (!raw) {
                    setStatus('<?php echo e(__('Paste JSON into the payload field to continue.')); ?>', 'info');
                    return null;
                }
                try {
                    return JSON.parse(raw);
                } catch (error) {
                    setStatus('<?php echo e(__('The JSON payload could not be parsed. Check for syntax issues such as missing commas or quotes.')); ?>', 'error');
                    return null;
                }
            };

            const applyValuesFromJson = (payload) => {
                if (!payload || typeof payload !== 'object') return;

                if (!titleField.value && payload.TOPIC) {
                    titleField.value = payload.TOPIC;
                }
                if (!slugField.value) {
                    const jsonSlug = payload.slug || payload.SLUG;
                    if (jsonSlug) {
                        slugField.value = jsonSlug;
                    } else if (titleField.value) {
                        slugField.value = titleField.value.toLowerCase()
                            .trim()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                    }
                }
                if (!subtitleField.value && payload.SUBTITLE) {
                    subtitleField.value = payload.SUBTITLE;
                }
                if (!summaryField.value && payload.OPENING_PARAGRAPH_HTML_SAFE) {
                    summaryField.value = payload.OPENING_PARAGRAPH_HTML_SAFE;
                }
            };

            const preview = async () => {
                const payloadString = jsonField.value;
                if (!payloadString.trim()) {
                    setStatus('<?php echo e(__('Paste JSON into the payload field to continue.')); ?>', 'info');
                    return;
                }

                clearStatus();
                setStatus('<?php echo e(__('Rendering preview...')); ?>', 'info');

                try {
                    const response = await fetch(previewUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            data: payloadString,
                            meta: metaField.value || null,
                            title: titleField.value,
                            slug: slugField.value,
                            summary: summaryField.value,
                            template_id: templateField.value || null,
                        }),
                    });

                    const raw = await response.text();
                    const cleaned = raw.replace(/^\uFEFF/, '');
                    let result = {};

                    if (cleaned) {
                        try {
                            result = JSON.parse(cleaned);
                        } catch (jsonError) {
                            throw new Error('<?php echo e(__('Preview response was not valid JSON.')); ?>');
                        }
                    }

                    if (!response.ok) {
                        throw new Error(result.detail || result.message || response.statusText);
                    }

                    if (result.title && !titleField.value) {
                        titleField.value = result.title;
                    }
                    if (result.slug && !slugField.value) {
                        slugField.value = result.slug;
                    }
                    if (result.summary && !summaryField.value) {
                        summaryField.value = result.summary;
                    }

                    setFrameContent(result.rendered_html || '<p class="text-sm text-gray-400"><?php echo e(__('Preview succeeded but returned empty output.')); ?></p>');
                    setStatus('<?php echo e(__('Preview updated. Review the rendered output.')); ?>', 'success');
                } catch (error) {
                    setFrameContent('<p class="text-sm text-red-600">' + (error.message || '<?php echo e(__('Unable to render preview.')); ?>') + '</p>');
                    setStatus(error.message || '<?php echo e(__('Unable to render preview.')); ?>', 'error');
                }
            };

            autofillBtn?.addEventListener('click', () => {
                const payload = parseJsonField();
                if (!payload) return;
                applyValuesFromJson(payload);
                setStatus('<?php echo e(__('Key fields were filled from the JSON payload.')); ?>', 'success');
            });

            previewBtn?.addEventListener('click', preview);

            if (jsonField.value.trim()) {
                const payload = parseJsonField();
                if (payload) {
                    applyValuesFromJson(payload);
                    preview();
                }
            }
        })();
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


<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/admin/topics/create.blade.php ENDPATH**/ ?>