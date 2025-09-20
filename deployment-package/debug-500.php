<?php
// Debug 500 error
echo "<h2>🔍 Debugging 500 Error</h2>";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🚨 500 Internal Server Error</strong><br>";
echo "Let's find out what's causing this error<br>";
echo "</div>";

// Test 1: Check if Laravel bootstrap exists
echo "<h3>Test 1: Laravel Bootstrap</h3>";
if (file_exists('bootstrap/app.php')) {
    echo "✅ Laravel bootstrap file exists<br>";
} else {
    echo "❌ Laravel bootstrap file not found<br>";
    exit;
}

// Test 2: Check .env file
echo "<h3>Test 2: Environment File</h3>";
if (file_exists('.env')) {
    echo "✅ .env file exists<br>";
    
    $env_content = file_get_contents('.env');
    if (strpos($env_content, 'APP_KEY=') !== false) {
        echo "✅ APP_KEY is set<br>";
    } else {
        echo "❌ APP_KEY is missing<br>";
    }
    
    if (strpos($env_content, 'DB_HOST=db5018653044.hosting-data.io') !== false) {
        echo "✅ Database host is correct<br>";
    } else {
        echo "❌ Database host is incorrect<br>";
    }
    
} else {
    echo "❌ .env file not found<br>";
}

// Test 3: Check database connection
echo "<h3>Test 3: Database Connection</h3>";
try {
    $pdo = new PDO(
        "mysql:host=db5018653044.hosting-data.io;port=3306;dbname=dbs14780656", 
        'dbu1219527', 
        '0100421606@Nephroapp'
    );
    echo "✅ Database connection works<br>";
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " tables<br>";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Test 4: Try to load Laravel app
echo "<h3>Test 4: Laravel App Loading</h3>";
try {
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel app loaded successfully<br>";
    
    // Test config
    $config = $app['config']['database.connections.mysql'];
    echo "✅ Database config loaded<br>";
    
} catch (Exception $e) {
    echo "❌ Laravel app loading failed: " . $e->getMessage() . "<br>";
    echo "Error details: " . $e->getTraceAsString() . "<br>";
}

// Test 5: Check file permissions
echo "<h3>Test 5: File Permissions</h3>";
$important_files = [
    '.env',
    'bootstrap/app.php',
    'bootstrap/cache',
    'storage',
    'storage/logs'
];

foreach ($important_files as $file) {
    if (file_exists($file)) {
        if (is_writable($file)) {
            echo "✅ $file is writable<br>";
        } else {
            echo "❌ $file is not writable<br>";
        }
    } else {
        echo "⚠️ $file does not exist<br>";
    }
}

echo "<hr>";
echo "<h3>🎯 Quick Fixes</h3>";
echo "<ul>";
echo "<li><a href='fix-permissions.php'>Fix File Permissions</a></li>";
echo "<li><a href='regenerate-app-key.php'>Regenerate APP_KEY</a></li>";
echo "<li><a href='clear-all-caches.php'>Clear All Caches</a></li>";
echo "<li><a href='create-tables-manually.php'>Create Database Tables</a></li>";
echo "</ul>";
?>
