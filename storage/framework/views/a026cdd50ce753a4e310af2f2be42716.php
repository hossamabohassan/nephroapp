<?php
    // Check if the content contains Blade syntax
    if (strpos($customHtml, '{{') !== false || strpos($customHtml, '@') !== false) {
        // Evaluate the custom HTML content as Blade template
        try {
            $renderedContent = \Illuminate\Support\Facades\Blade::render($customHtml);
        } catch (\Exception $e) {
            // If rendering fails, show error and fall back to raw content
            $renderedContent = '<div style="background: #fee; border: 1px solid #fcc; padding: 10px; margin: 10px; border-radius: 4px;"><strong>Blade Rendering Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>' . $customHtml;
        }
    } else {
        // Pure HTML content
        $renderedContent = $customHtml;
    }
?>

<?php echo $renderedContent; ?>

<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/landing-custom.blade.php ENDPATH**/ ?>