<?php
// Fix file permissions for Laravel
echo "<h2>🔧 Fixing File Permissions</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ Fixing file permissions for Laravel</strong><br>";
echo "This will make sure Laravel can write to necessary directories<br>";
echo "</div>";

// Directories that need to be writable
$writable_dirs = [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs'
];

echo "<h3>🔧 Setting Directory Permissions</h3>";
foreach ($writable_dirs as $dir) {
    if (file_exists($dir)) {
        if (chmod($dir, 0755)) {
            echo "✅ Set permissions for: $dir<br>";
        } else {
            echo "❌ Could not set permissions for: $dir<br>";
        }
    } else {
        // Try to create the directory
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created directory: $dir<br>";
        } else {
            echo "❌ Could not create directory: $dir<br>";
        }
    }
}

// Files that need to be writable
$writable_files = [
    '.env',
    'bootstrap/cache/config.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/routes.php'
];

echo "<h3>🔧 Setting File Permissions</h3>";
foreach ($writable_files as $file) {
    if (file_exists($file)) {
        if (chmod($file, 0644)) {
            echo "✅ Set permissions for: $file<br>";
        } else {
            echo "❌ Could not set permissions for: $file<br>";
        }
    } else {
        echo "⚠️ File does not exist: $file<br>";
    }
}

echo "<hr>";
echo "<h3>🎯 Test Your Site Now</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>File permissions fixed!</strong></p>";
echo "<p>Try visiting your main site:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='debug-500.php'>Debug 500 Error Again</a></li>";
echo "</ul>";
echo "</div>";
?>

