<?php
// Debug current 500 error
echo "<h2>🔍 Debugging Current 500 Error</h2>";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🚨 500 Internal Server Error</strong><br>";
echo "Let's find out what's causing this error now<br>";
echo "</div>";

// Test 1: Check .env file
echo "<h3>Test 1: Environment File</h3>";
if (file_exists('.env')) {
    echo "✅ .env file exists<br>";
    
    $env_content = file_get_contents('.env');
    if (strpos($env_content, 'DB_HOST=db5018653044.hosting-data.io') !== false) {
        echo "✅ Database host is correct<br>";
    } else {
        echo "❌ Database host is incorrect<br>";
    }
    
    if (strpos($env_content, 'DB_DATABASE=dbs14780656') !== false) {
        echo "✅ Database name is correct<br>";
    } else {
        echo "❌ Database name is incorrect<br>";
    }
    
    if (strpos($env_content, 'SESSION_DRIVER=file') !== false) {
        echo "✅ Session driver is set to file<br>";
    } else {
        echo "❌ Session driver not set to file<br>";
    }
    
} else {
    echo "❌ .env file not found<br>";
}

// Test 2: Check database connection
echo "<h3>Test 2: Database Connection</h3>";
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

// Test 3: Check Laravel bootstrap
echo "<h3>Test 3: Laravel Bootstrap</h3>";
if (file_exists('bootstrap/app.php')) {
    echo "✅ Laravel bootstrap exists<br>";
} else {
    echo "❌ Laravel bootstrap not found<br>";
}

// Test 4: Check vendor directory
echo "<h3>Test 4: Vendor Directory</h3>";
if (is_dir('vendor')) {
    echo "✅ Vendor directory exists<br>";
    
    if (file_exists('vendor/autoload.php')) {
        echo "✅ Composer autoloader exists<br>";
    } else {
        echo "❌ Composer autoloader not found<br>";
    }
    
    if (file_exists('vendor/laravel/framework')) {
        echo "✅ Laravel framework exists<br>";
    } else {
        echo "❌ Laravel framework not found<br>";
    }
} else {
    echo "❌ Vendor directory not found<br>";
}

// Test 5: Try to load Laravel app
echo "<h3>Test 5: Laravel App Loading</h3>";
try {
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel app loaded successfully<br>";
    
    // Test config
    $config = $app['config']['database.connections.mysql'];
    echo "✅ Database config loaded<br>";
    echo "Host: " . $config['host'] . "<br>";
    echo "Database: " . $config['database'] . "<br>";
    echo "Username: " . $config['username'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Laravel app loading failed: " . $e->getMessage() . "<br>";
    echo "Error details: " . $e->getTraceAsString() . "<br>";
}

// Test 6: Check file permissions
echo "<h3>Test 6: File Permissions</h3>";
$important_dirs = [
    'storage',
    'storage/logs',
    'bootstrap/cache'
];

foreach ($important_dirs as $dir) {
    if (file_exists($dir)) {
        if (is_writable($dir)) {
            echo "✅ $dir is writable<br>";
        } else {
            echo "❌ $dir is not writable<br>";
        }
    } else {
        echo "⚠️ $dir does not exist<br>";
    }
}

echo "<hr>";
echo "<h3>🎯 Quick Fixes</h3>";
echo "<ul>";
echo "<li><a href='fix-full-project-env.php'>Fix .env File</a></li>";
echo "<li><a href='run-migrations-full.php'>Run Migrations</a></li>";
echo "<li><a href='fix-permissions.php'>Fix File Permissions</a></li>";
echo "<li><a href='regenerate-app-key.php'>Regenerate APP_KEY</a></li>";
echo "</ul>";
?>
