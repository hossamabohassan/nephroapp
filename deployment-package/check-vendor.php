<?php
// Check if vendor directory exists and has Laravel dependencies
echo "<h2>🔍 Checking Laravel Dependencies</h2>";

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🚨 Found the Problem!</strong><br>";
echo "Laravel core classes are missing - the vendor directory wasn't uploaded<br>";
echo "</div>";

// Check if vendor directory exists
echo "<h3>Test 1: Vendor Directory</h3>";
if (is_dir('vendor')) {
    echo "✅ Vendor directory exists<br>";
    
    // Check if it has content
    $files = scandir('vendor');
    if (count($files) > 2) {
        echo "✅ Vendor directory has content (" . (count($files) - 2) . " items)<br>";
    } else {
        echo "❌ Vendor directory is empty<br>";
    }
} else {
    echo "❌ Vendor directory does not exist<br>";
}

// Check for Laravel framework
echo "<h3>Test 2: Laravel Framework</h3>";
if (file_exists('vendor/laravel/framework')) {
    echo "✅ Laravel framework found<br>";
} else {
    echo "❌ Laravel framework not found<br>";
}

// Check for autoloader
echo "<h3>Test 3: Composer Autoloader</h3>";
if (file_exists('vendor/autoload.php')) {
    echo "✅ Composer autoloader found<br>";
} else {
    echo "❌ Composer autoloader not found<br>";
}

// Check composer.json
echo "<h3>Test 4: Composer Configuration</h3>";
if (file_exists('composer.json')) {
    echo "✅ composer.json exists<br>";
    
    $composer = json_decode(file_get_contents('composer.json'), true);
    if (isset($composer['require']['laravel/framework'])) {
        echo "✅ Laravel framework in composer.json<br>";
    } else {
        echo "❌ Laravel framework not in composer.json<br>";
    }
} else {
    echo "❌ composer.json not found<br>";
}

echo "<hr>";
echo "<h3>🎯 Solution: Upload Vendor Directory</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ The Problem:</strong><br>";
echo "The vendor directory (Laravel dependencies) wasn't uploaded to your server<br>";
echo "<br>";
echo "<strong>✅ The Solution:</strong><br>";
echo "You need to upload the vendor directory from your local project<br>";
echo "</div>";

echo "<h4>📋 Steps to Fix:</h4>";
echo "<ol>";
echo "<li><strong>On your local computer:</strong> Go to <code>C:\\xampp\\htdocs\\nephroapp</code></li>";
echo "<li><strong>Find the vendor folder:</strong> It should be in the same directory as your Laravel project</li>";
echo "<li><strong>Upload vendor folder:</strong> Upload the entire vendor folder to your IONOS server</li>";
echo "<li><strong>Upload composer.json:</strong> Also upload the composer.json file</li>";
echo "<li><strong>Test your site:</strong> Visit your main site again</li>";
echo "</ol>";

echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>🚀 Alternative: Run Composer on Server</h4>";
echo "<p>If you have SSH access to your IONOS server, you can run:</p>";
echo "<code>composer install</code>";
echo "<p>This will download all Laravel dependencies directly on the server.</p>";
echo "</div>";

echo "<hr>";
echo "<h3>🔧 Quick Test</h3>";
echo "<p>After uploading the vendor directory, test your site:</p>";
echo "<ul>";
echo "<li><a href='index.php'>🚀 Visit Main Site</a></li>";
echo "<li><a href='debug-500.php'>🔍 Debug Again</a></li>";
echo "</ul>";
?>

