<?php
// Simple route test without full Laravel bootstrap
echo "<h2>🧪 Direct Route Test</h2>";

$laravelPath = __DIR__;
if (file_exists('nephroapp')) {
    $laravelPath = __DIR__ . '/nephroapp';
}

chdir($laravelPath);

echo "<h3>Test 1: Auth Routes Content</h3>";
$authContent = file_get_contents('routes/auth.php');
echo "<pre style='background: #f9f9f9; padding: 10px; max-height: 400px; overflow-y: auto;'>";
echo htmlspecialchars($authContent);
echo "</pre>";

echo "<h3>Test 2: Web Routes Content</h3>";
$webContent = file_get_contents('routes/web.php');
echo "<pre style='background: #f9f9f9; padding: 10px; max-height: 400px; overflow-y: auto;'>";
echo htmlspecialchars(substr($webContent, -1000)); // Last 1000 chars to see the require statement
echo "</pre>";

echo "<h3>Test 3: Environment Variables</h3>";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    echo "<div style='background: #f9f9f9; padding: 10px;'>";
    echo "<strong>Database Configuration:</strong><br>";
    $lines = explode("\n", $envContent);
    foreach ($lines as $line) {
        if (strpos($line, 'DB_') === 0) {
            echo htmlspecialchars($line) . "<br>";
        }
    }
    echo "</div>";
} else {
    echo "❌ .env file not found<br>";
}

echo "<h3>Test 4: Cache Files</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";
$cacheFiles = ['bootstrap/cache/routes.php', 'bootstrap/cache/config.php', 'bootstrap/cache/services.php'];
foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        echo "⚠️ Cache file exists: $file<br>";
    } else {
        echo "✅ No cache file: $file<br>";
    }
}
echo "</div>";

echo "<h3>🎯 Recommendations</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";
echo "<strong>Issues Found:</strong><br>";
echo "1. Routes from auth.php are not being loaded properly<br>";
echo "2. Database connection configuration may be wrong<br>";
echo "3. Cache files may be interfering<br>";
echo "<br>";
echo "<strong>Next Steps:</strong><br>";
echo "1. Clear all cache files manually<br>";
echo "2. Fix database configuration in .env<br>";
echo "3. Test if routes work after cache clearing<br>";
echo "</div>";
?>
