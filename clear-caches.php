<?php
/**
 * Clear All Laravel Caches for IONOS Deployment
 * Run this file in your browser after uploading to IONOS
 */

echo "<h1>🧹 Clearing Laravel Caches</h1>";

$basePath = __DIR__;

// Clear bootstrap cache files
$bootstrapCacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/events.php',
    'bootstrap/cache/packages.php'
];

echo "<h2>🗂️ Bootstrap Cache Files</h2>";
foreach ($bootstrapCacheFiles as $file) {
    $filePath = $basePath . '/' . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "✅ Deleted: $file<br>";
    } else {
        echo "ℹ️ Not found: $file<br>";
    }
}

// Clear storage cache
$storageCacheDir = $basePath . '/storage/framework/cache';
if (is_dir($storageCacheDir)) {
    $files = glob($storageCacheDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✅ Cleared storage/framework/cache<br>";
} else {
    echo "ℹ️ storage/framework/cache directory not found<br>";
}

// Clear compiled views
$viewsCacheDir = $basePath . '/storage/framework/views';
if (is_dir($viewsCacheDir)) {
    $files = glob($viewsCacheDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✅ Cleared storage/framework/views<br>";
} else {
    echo "ℹ️ storage/framework/views directory not found<br>";
}

// Clear sessions
$sessionsDir = $basePath . '/storage/framework/sessions';
if (is_dir($sessionsDir)) {
    $files = glob($sessionsDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✅ Cleared storage/framework/sessions<br>";
} else {
    echo "ℹ️ storage/framework/sessions directory not found<br>";
}

// Clear logs (optional - keep recent ones)
$logFile = $basePath . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    // Keep last 100 lines
    $lines = file($logFile);
    if (count($lines) > 100) {
        $recentLines = array_slice($lines, -100);
        file_put_contents($logFile, implode('', $recentLines));
        echo "✅ Trimmed storage/logs/laravel.log (kept last 100 lines)<br>";
    } else {
        echo "ℹ️ storage/logs/laravel.log is small, keeping as is<br>";
    }
} else {
    echo "ℹ️ storage/logs/laravel.log not found<br>";
}

// Ensure proper permissions
$directories = [
    'storage',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/views',
    'storage/framework/sessions',
    'storage/logs',
    'bootstrap/cache'
];

echo "<br><h2>🔐 Setting Permissions</h2>";
foreach ($directories as $dir) {
    $dirPath = $basePath . '/' . $dir;
    if (is_dir($dirPath)) {
        chmod($dirPath, 0755);
        echo "✅ Set permissions for: $dir<br>";
    }
}

echo "<br><h2>🎉 Cache Clearing Complete!</h2>";
echo "<p>All Laravel caches have been cleared. Your application should now use fresh configurations.</p>";

echo "<br><h3>📋 What was cleared:</h3>";
echo "<ul>";
echo "<li>Bootstrap cache files (config, routes, services, events)</li>";
echo "<li>Storage framework cache</li>";
echo "<li>Compiled views</li>";
echo "<li>Session files</li>";
echo "<li>Log files (trimmed)</li>";
echo "</ul>";

echo "<br><h3>🚀 Next Steps:</h3>";
echo "<ol>";
echo "<li>Test your <a href='/'>homepage</a></li>";
echo "<li>Test your <a href='/login'>login page</a></li>";
echo "<li>Test your <a href='/register'>register page</a></li>";
echo "<li>If you still have issues, run <a href='fix-csrf-sessions.php'>fix-csrf-sessions.php</a></li>";
echo "</ol>";

echo "<br><p><strong>Note:</strong> Laravel will automatically regenerate cache files as needed.</p>";
?>
