<?php
// Check what's actually in the vendor directory
echo "<h2>🔍 Checking Vendor Directory Contents</h2>";

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🚨 Laravel Classes Still Missing</strong><br>";
echo "Even after re-uploading vendor, Illuminate\\Foundation\\Application is not found<br>";
echo "Let's check what's actually in the vendor directory<br>";
echo "</div>";

// Check vendor directory structure
echo "<h3>🔍 Vendor Directory Structure</h3>";

if (is_dir('vendor')) {
    echo "✅ Vendor directory exists<br>";
    
    // List top-level vendor contents
    $vendor_contents = scandir('vendor');
    echo "<strong>Top-level vendor contents:</strong><br>";
    echo "<ul>";
    foreach ($vendor_contents as $item) {
        if ($item != '.' && $item != '..') {
            if (is_dir("vendor/$item")) {
                echo "<li>📁 $item/</li>";
            } else {
                echo "<li>📄 $item</li>";
            }
        }
    }
    echo "</ul>";
    
    // Check Laravel framework specifically
    echo "<h3>🔍 Laravel Framework Check</h3>";
    if (is_dir('vendor/laravel')) {
        echo "✅ vendor/laravel directory exists<br>";
        
        $laravel_contents = scandir('vendor/laravel');
        echo "<strong>Laravel directory contents:</strong><br>";
        echo "<ul>";
        foreach ($laravel_contents as $item) {
            if ($item != '.' && $item != '..') {
                if (is_dir("vendor/laravel/$item")) {
                    echo "<li>📁 $item/</li>";
                } else {
                    echo "<li>📄 $item</li>";
                }
            }
        }
        echo "</ul>";
        
        // Check framework directory
        if (is_dir('vendor/laravel/framework')) {
            echo "✅ vendor/laravel/framework directory exists<br>";
            
            // Check for the specific Application.php file
            $app_file = 'vendor/laravel/framework/src/Illuminate/Foundation/Application.php';
            if (file_exists($app_file)) {
                echo "✅ Application.php file exists<br>";
                echo "File size: " . filesize($app_file) . " bytes<br>";
                echo "File modified: " . date('Y-m-d H:i:s', filemtime($app_file)) . "<br>";
            } else {
                echo "❌ Application.php file NOT found<br>";
                echo "Expected path: $app_file<br>";
            }
        } else {
            echo "❌ vendor/laravel/framework directory NOT found<br>";
        }
    } else {
        echo "❌ vendor/laravel directory NOT found<br>";
    }
    
    // Check autoloader
    echo "<h3>🔍 Autoloader Check</h3>";
    if (file_exists('vendor/autoload.php')) {
        echo "✅ vendor/autoload.php exists<br>";
        echo "File size: " . filesize('vendor/autoload.php') . " bytes<br>";
        
        // Try to load it
        try {
            require_once 'vendor/autoload.php';
            echo "✅ Autoloader loaded successfully<br>";
            
            // Check if we can find the class
            if (class_exists('Illuminate\Foundation\Application')) {
                echo "✅ Illuminate\\Foundation\\Application class found<br>";
            } else {
                echo "❌ Illuminate\\Foundation\\Application class NOT found<br>";
            }
        } catch (Exception $e) {
            echo "❌ Autoloader failed: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ vendor/autoload.php NOT found<br>";
    }
    
} else {
    echo "❌ Vendor directory does not exist<br>";
}

echo "<hr>";
echo "<h3>🎯 Solutions</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>If Laravel classes are missing:</strong><br>";
echo "<ol>";
echo "<li><strong>Check your local vendor directory:</strong> Make sure it has all Laravel files</li>";
echo "<li><strong>Re-upload vendor directory:</strong> Delete server vendor and upload fresh copy</li>";
echo "<li><strong>Run composer install locally:</strong> <code>composer install</code> in your local project</li>";
echo "<li><strong>Check file permissions:</strong> Make sure vendor files are readable</li>";
echo "</ol>";
echo "</div>";

echo "<ul>";
echo "<li><a href='create-minimal-laravel.php'>Create Minimal Laravel Setup</a></li>";
echo "<li><a href='fix-vendor-directory.php'>Fix Vendor Directory</a></li>";
echo "<li><a href='debug-current-500.php'>Debug Again</a></li>";
echo "</ul>";
?>
