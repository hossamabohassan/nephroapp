<?php if($template && $rendered): ?>
    <style>
        <?php echo $rendered['css']; ?>

    </style>
    
    <div class="dynamic-template">
        <?php echo $rendered['html']; ?>

    </div>
    
    <?php if($rendered['js']): ?>
        <script>
            <?php echo $rendered['js']; ?>

        </script>
    <?php endif; ?>
<?php else: ?>
    <div class="p-4 bg-red-100 text-red-700 rounded">
        Template not found or could not be rendered.
    </div>
<?php endif; ?><?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/components/dynamic-layout.blade.php ENDPATH**/ ?>