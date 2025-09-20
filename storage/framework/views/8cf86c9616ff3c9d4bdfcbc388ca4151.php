<?php
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;

    $data = $payload['sections'] ?? [];
    $ignored = [
        'TOPIC',
        'SUBTITLE',
        'CHIP_1',
        'CHIP_2',
        'CHIP_3',
        'OPENING_PARAGRAPH_HTML_SAFE',
    ];
?>

<section class="space-y-8">
    <header class="space-y-3">
        <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wide"><?php echo e($topic->slug); ?></p>
        <h1 class="text-3xl font-bold text-gray-900"><?php echo e($payload['title'] ?? $topic->title); ?></h1>
        <?php if(!empty($payload['subtitle'])): ?>
            <p class="text-lg text-gray-600"><?php echo e($payload['subtitle']); ?></p>
        <?php endif; ?>
        <div class="flex flex-wrap gap-2">
            <?php $__currentLoopData = $payload['chips'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-800">
                    <?php echo e($chip); ?>

                </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </header>

    <?php if(!empty($payload['summary'])): ?>
        <div class="prose max-w-none">
            <?php echo $payload['summary']; ?>

        </div>
    <?php endif; ?>

    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(in_array($key, $ignored, true)) continue; ?>
        <?php
            $title = Str::of($key)->replace('_', ' ')->lower()->ucfirst();
            $title = Str::of($title)->replace(' html safe', '')->replace(' html', '');
        ?>
        <section class="space-y-3">
            <h2 class="text-2xl font-semibold text-gray-800"><?php echo e($title); ?></h2>

            <?php if(is_array($value)): ?>
                <ul class="list-disc ms-5 space-y-2">
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_array($item) && (isset($item['q']) || isset($item['a']))): ?>
                            <li class="space-y-1">
                                <?php if(!empty($item['q'])): ?>
                                    <p class="font-medium text-gray-900"><?php echo e($item['q']); ?></p>
                                <?php endif; ?>
                                <?php if(!empty($item['a'])): ?>
                                    <p class="text-gray-600"><?php echo e($item['a']); ?></p>
                                <?php endif; ?>
                            </li>
                        <?php else: ?>
                            <li class="text-gray-700"><?php echo is_string($item) ? nl2br(e($item)) : json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php elseif(is_string($value) && Str::contains($key, ['HTML'])): ?>
                <div class="prose max-w-none">
                    <?php echo $value; ?>

                </div>
            <?php else: ?>
                <p class="text-gray-700"><?php echo nl2br(e($value)); ?></p>
            <?php endif; ?>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</section>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/topics/templates/viva.blade.php ENDPATH**/ ?>