<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Preview - <?php echo e($template->name); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        <?php echo $rendered['css']; ?>

    </style>
</head>
<body>
    <!-- Preview Header -->
    <div class="bg-gray-800 text-white p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold">Template Preview</h1>
                <p class="text-gray-300"><?php echo e($template->name); ?> - <?php echo e($template->description); ?></p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="px-3 py-1 bg-blue-600 rounded-full text-sm">
                    <?php echo e(ucfirst($template->category)); ?>

                </span>
                <a href="<?php echo e(route('admin.templates.index')); ?>" 
                   class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded text-sm">
                    Back to Templates
                </a>
            </div>
        </div>
    </div>

    <!-- Template Preview Content -->
    <div class="min-h-screen">
        <?php echo $rendered['html']; ?>

    </div>

    <!-- Preview Footer -->
    <div class="bg-gray-100 border-t p-4">
        <div class="max-w-7xl mx-auto text-center text-gray-600">
            <p class="text-sm">
                This is a preview of the "<?php echo e($template->name); ?>" template. 
                Variables are shown with their default values.
            </p>
            <?php if($template->variables): ?>
                <div class="mt-2">
                    <p class="text-xs text-gray-500">Template Variables:</p>
                    <div class="flex flex-wrap justify-center gap-2 mt-1">
                        <?php $__currentLoopData = $template->variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="px-2 py-1 bg-white rounded text-xs border">
                                <?php echo e($key); ?>: <?php echo e($value); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($rendered['js']): ?>
        <script>
            <?php echo $rendered['js']; ?>

        </script>
    <?php endif; ?>
</body>
</html>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/admin/templates/preview.blade.php ENDPATH**/ ?>