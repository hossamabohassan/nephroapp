<?php
// Fix vendor directory issues
echo "<h2>🔧 Fixing Vendor Directory Issues</h2>";

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🚨 Found the Problem!</strong><br>";
echo "Laravel classes are missing from vendor directory<br>";
echo "The vendor directory exists but is incomplete or corrupted<br>";
echo "</div>";

// Check vendor directory structure
echo "<h3>🔍 Checking Vendor Directory Structure</h3>";

$required_paths = [
    'vendor/autoload.php',
    'vendor/laravel/framework/src/Illuminate/Foundation/Application.php',
    'vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php',
    'vendor/laravel/framework/src/Illuminate/Support/ServiceProvider.php'
];

foreach ($required_paths as $path) {
    if (file_exists($path)) {
        echo "✅ Found: $path<br>";
    } else {
        echo "❌ Missing: $path<br>";
    }
}

// Check if we can load the autoloader
echo "<h3>🧪 Testing Autoloader</h3>";
if (file_exists('vendor/autoload.php')) {
    try {
        require_once 'vendor/autoload.php';
        echo "✅ Autoloader loaded successfully<br>";
        
        // Test if we can find Laravel classes
        if (class_exists('Illuminate\Foundation\Application')) {
            echo "✅ Illuminate\\Foundation\\Application class found<br>";
        } else {
            echo "❌ Illuminate\\Foundation\\Application class not found<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ Autoloader failed: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Autoloader not found<br>";
}

echo "<hr>";
echo "<h3>🎯 Solution: Re-upload Vendor Directory</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ The Problem:</strong><br>";
echo "The vendor directory is incomplete or corrupted<br>";
echo "<br>";
echo "<strong>✅ The Solution:</strong><br>";
echo "You need to re-upload the vendor directory from your local project<br>";
echo "</div>";

echo "<h4>📋 Steps to Fix:</h4>";
echo "<ol>";
echo "<li><strong>On your local computer:</strong> Go to <code>C:\\xampp\\htdocs\\nephroapp</code></li>";
echo "<li><strong>Delete the vendor folder on server:</strong> Remove the incomplete vendor folder from your IONOS server</li>";
echo "<li><strong>Upload fresh vendor folder:</strong> Upload the complete vendor folder from your local project</li>";
echo "<li><strong>Test your site:</strong> Visit your main site again</li>";
echo "</ol>";

echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>🚀 Alternative: Run Composer on Server</h4>";
echo "<p>If you have SSH access to your IONOS server, you can run:</p>";
echo "<code>composer install --no-dev --optimize-autoloader</code>";
echo "<p>This will download all Laravel dependencies directly on the server.</p>";
echo "</div>";

echo "<hr>";
echo "<h3>🔧 Quick Test</h3>";
echo "<p>After re-uploading the vendor directory, test your site:</p>";
echo "<ul>";
echo "<li><a href='index.php'>🚀 Visit Main Site</a></li>";
echo "<li><a href='debug-current-500.php'>🔍 Debug Again</a></li>";
echo "</ul>";
?>
