<?php
// Force reload .env file by manually reading and testing
echo "<h2>🔄 Force Reload .env File</h2>";

// Read .env file directly
if (!file_exists('.env')) {
    echo "❌ .env file not found!<br>";
    exit;
}

$env_content = file_get_contents('.env');
echo "<h3>📄 Current .env File Contents:</h3>";
echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
echo htmlspecialchars($env_content);
echo "</pre>";

// Parse .env file manually
$env_vars = [];
$lines = explode("\n", $env_content);
foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line) || strpos($line, '#') === 0) continue;
    
    if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $env_vars[trim($key)] = trim($value);
    }
}

echo "<h3>🔍 Parsed Environment Variables:</h3>";
echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px;'>";
echo "DB_HOST: <code>" . ($env_vars['DB_HOST'] ?? 'NOT SET') . "</code><br>";
echo "DB_DATABASE: <code>" . ($env_vars['DB_DATABASE'] ?? 'NOT SET') . "</code><br>";
echo "DB_USERNAME: <code>" . ($env_vars['DB_USERNAME'] ?? 'NOT SET') . "</code><br>";
echo "DB_PASSWORD: <code>" . (isset($env_vars['DB_PASSWORD']) ? '[HIDDEN]' : 'NOT SET') . "</code><br>";
echo "DB_PORT: <code>" . ($env_vars['DB_PORT'] ?? 'NOT SET') . "</code><br>";
echo "</div>";

// Test connection with parsed values
echo "<h3>🧪 Testing Connection with Parsed Values</h3>";
try {
    $host = $env_vars['DB_HOST'] ?? 'localhost';
    $dbname = $env_vars['DB_DATABASE'] ?? 'test';
    $username = $env_vars['DB_USERNAME'] ?? 'root';
    $password = $env_vars['DB_PASSWORD'] ?? '';
    $port = $env_vars['DB_PORT'] ?? '3306';
    
    echo "Testing connection to: <code>$host:$port</code><br>";
    echo "Database: <code>$dbname</code><br>";
    echo "Username: <code>$username</code><br>";
    
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    echo "✅ <strong>SUCCESS!</strong> Database connection works!<br>";
    
    // Test query
    $stmt = $pdo->query("SELECT 1 as test, NOW() as current_time");
    $result = $stmt->fetch();
    echo "✅ Database query successful! Time: " . $result['current_time'] . "<br>";
    
} catch (PDOException $e) {
    echo "❌ <strong>FAILED!</strong> " . $e->getMessage() . "<br>";
    echo "Error Code: " . $e->getCode() . "<br>";
}

// Check if there are any cached config files
echo "<h3>🗂️ Checking for Cached Config Files</h3>";
$cache_files = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/routes.php'
];

foreach ($cache_files as $file) {
    if (file_exists($file)) {
        echo "⚠️ Found cached file: <code>$file</code><br>";
        echo "   Size: " . filesize($file) . " bytes<br>";
        echo "   Modified: " . date('Y-m-d H:i:s', filemtime($file)) . "<br>";
    } else {
        echo "✅ No cached file: <code>$file</code><br>";
    }
}

echo "<hr>";
echo "<h3>🎯 Actions</h3>";
echo "<ul>";
echo "<li><a href='clear-cache.php'>Clear All Laravel Caches</a></li>";
echo "<li><a href='index.php'>Try Main Site</a></li>";
echo "<li><a href='quick-db-test.php'>Test Database</a></li>";
echo "</ul>";
?>

