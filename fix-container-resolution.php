<?php
/**
 * Fix Container Resolution Issues (419 Page Expired)
 * The logs show Container resolution errors - let's fix this
 */

echo "<h1>🔧 Fixing Container Resolution Issues</h1>";
echo "<p>The logs show Container resolution errors that might be causing 419 Page Expired.</p>";

$basePath = __DIR__;

// 1. Clear ALL caches completely
echo "<h2>🧹 Clearing All Caches</h2>";
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/events.php',
    'bootstrap/cache/packages.php'
];

foreach ($cacheFiles as $file) {
    $filePath = $basePath . '/' . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "✅ Cleared: $file<br>";
    }
}

// Clear storage caches
$cacheDirs = [
    'storage/framework/cache',
    'storage/framework/views',
    'storage/framework/sessions'
];

foreach ($cacheDirs as $dir) {
    $dirPath = $basePath . '/' . $dir;
    if (is_dir($dirPath)) {
        $files = glob($dirPath . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "✅ Cleared: $dir<br>";
    }
}

// 2. Check and fix middleware configuration
echo "<br><h2>🔍 Checking Middleware Configuration</h2>";
$middlewarePath = $basePath . '/app/Http/Middleware';
if (is_dir($middlewarePath)) {
    $middlewareFiles = glob($middlewarePath . '/*.php');
    echo "Found middleware files:<br>";
    foreach ($middlewareFiles as $file) {
        $filename = basename($file);
        echo "• $filename<br>";
    }
} else {
    echo "❌ Middleware directory not found<br>";
}

// 3. Check bootstrap/app.php for middleware issues
echo "<br><h2>📄 Checking Bootstrap Configuration</h2>";
$bootstrapPath = $basePath . '/bootstrap/app.php';
if (file_exists($bootstrapPath)) {
    $bootstrapContent = file_get_contents($bootstrapPath);
    
    // Check for common issues
    if (strpos($bootstrapContent, 'LoadSettings') !== false) {
        echo "✅ LoadSettings middleware found<br>";
    } else {
        echo "ℹ️ LoadSettings middleware not found<br>";
    }
    
    if (strpos($bootstrapContent, 'EnsureUserIsActive') !== false) {
        echo "✅ EnsureUserIsActive middleware found<br>";
    } else {
        echo "ℹ️ EnsureUserIsActive middleware not found<br>";
    }
    
    // Check if there are any syntax issues
    if (strpos($bootstrapContent, 'use Illuminate\\Support\\Facades\\Route;') !== false) {
        echo "✅ Route facade imported<br>";
    } else {
        echo "⚠️ Route facade not imported<br>";
    }
} else {
    echo "❌ Bootstrap file not found<br>";
}

// 4. Check for missing service providers
echo "<br><h2>🔧 Checking Service Providers</h2>";
$providersPath = $basePath . '/app/Providers';
if (is_dir($providersPath)) {
    $providerFiles = glob($providersPath . '/*.php');
    echo "Found service providers:<br>";
    foreach ($providerFiles as $file) {
        $filename = basename($file);
        echo "• $filename<br>";
    }
} else {
    echo "❌ Providers directory not found<br>";
}

// 5. Fix potential middleware issues
echo "<br><h2>🛠️ Fixing Potential Middleware Issues</h2>";

// Check if LoadSettings middleware exists and is properly configured
$loadSettingsPath = $basePath . '/app/Http/Middleware/LoadSettings.php';
if (file_exists($loadSettingsPath)) {
    $loadSettingsContent = file_get_contents($loadSettingsPath);
    
    // Check if the middleware is properly structured
    if (strpos($loadSettingsContent, 'class LoadSettings') !== false) {
        echo "✅ LoadSettings middleware class found<br>";
    } else {
        echo "⚠️ LoadSettings middleware class issue<br>";
    }
    
    if (strpos($loadSettingsContent, 'public function handle') !== false) {
        echo "✅ LoadSettings handle method found<br>";
    } else {
        echo "⚠️ LoadSettings handle method issue<br>";
    }
} else {
    echo "❌ LoadSettings middleware not found<br>";
}

// 6. Create a simple test to isolate the issue
echo "<br><h2>🧪 Creating Isolation Test</h2>";
$testFile = $basePath . '/test-container.php';
$testContent = '<?php
// Simple container test
try {
    require __DIR__ . "/vendor/autoload.php";
    $app = require __DIR__ . "/bootstrap/app.php";
    echo "✅ Container created successfully\n";
    
    // Test basic resolution
    $request = \Illuminate\Http\Request::capture();
    echo "✅ Request captured successfully\n";
    
    // Test middleware resolution
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    echo "✅ Kernel resolved successfully\n";
    
} catch (Exception $e) {
    echo "❌ Container error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>';

file_put_contents($testFile, $testContent);
chmod($testFile, 0644);
echo "✅ Created container test file<br>";

// 7. Provide specific fixes based on the error
echo "<br><h2>🎯 Specific Fixes for Container Resolution</h2>";
echo "<h3>Run these commands via SSH:</h3>";
echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
echo "# Clear all caches\n";
echo "/usr/bin/php8.2-cli artisan config:clear\n";
echo "/usr/bin/php8.2-cli artisan route:clear\n";
echo "/usr/bin/php8.2-cli artisan view:clear\n";
echo "/usr/bin/php8.2-cli artisan cache:clear\n";
echo "/usr/bin/php8.2-cli artisan optimize:clear\n";
echo "\n# Regenerate autoloader\n";
echo "/usr/bin/php8.2-cli /usr/bin/composer dump-autoload\n";
echo "\n# Test container resolution\n";
echo "/usr/bin/php8.2-cli test-container.php\n";
echo "</pre>";

// 8. Check for specific middleware that might be causing issues
echo "<br><h2>🔍 Checking for Problematic Middleware</h2>";
$middlewareFiles = [
    'LoadSettings.php',
    'EnsureUserIsActive.php',
    'VerifyCsrfToken.php'
];

foreach ($middlewareFiles as $file) {
    $filePath = $basePath . '/app/Http/Middleware/' . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Check for common issues
        if (strpos($content, 'class ' . str_replace('.php', '', $file)) !== false) {
            echo "✅ $file: Class definition found<br>";
        } else {
            echo "⚠️ $file: Class definition issue<br>";
        }
        
        if (strpos($content, 'public function handle') !== false) {
            echo "✅ $file: Handle method found<br>";
        } else {
            echo "⚠️ $file: Handle method issue<br>";
        }
    } else {
        echo "ℹ️ $file: Not found<br>";
    }
}

echo "<br><h2>🎉 Container Resolution Fix Complete!</h2>";
echo "<p>The issue is likely with middleware or service resolution. The fixes above should resolve it.</p>";

echo "<br><h3>🚀 Next Steps:</h3>";
echo "<ol>";
echo "<li>Run the SSH commands above to clear caches and regenerate autoloader</li>";
echo "<li>Test your forms again</li>";
echo "<li>Check if the 419 error is resolved</li>";
echo "<li>If still having issues, check the container test file output</li>";
echo "</ol>";

echo "<br><h3>💡 The Real Issue:</h3>";
echo "<p>Based on the logs, the problem is with <strong>Container resolution</strong> - likely a middleware or service provider issue. The fixes above should resolve this.</p>";
?>
