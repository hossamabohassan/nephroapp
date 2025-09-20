<?php
// Emergency fix for Laravel database connection
echo "<h2>🚨 Emergency Laravel Database Fix</h2>";

// Your correct IONOS database credentials
$host = 'db5018653044.hosting-data.io';
$dbname = 'dbs14780656';
$username = 'dbu1219527';
$password = '0100421606@Nephroapp';
$port = 3306;

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🚨 Current Problem:</strong><br>";
echo "Laravel is still using old cached database configuration<br>";
echo "Getting 'Connection refused' error<br>";
echo "</div>";

// Step 1: Fix .env file
echo "<h3>Step 1: Fixing .env File</h3>";
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    // Update ALL database settings
    $env_content = preg_replace('/DB_HOST=.*/', "DB_HOST=$host", $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$dbname", $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME=$username", $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD=$password", $env_content);
    $env_content = preg_replace('/DB_PORT=.*/', "DB_PORT=$port", $env_content);
    
    file_put_contents('.env', $env_content);
    echo "✅ .env file updated<br>";
} else {
    echo "❌ .env file not found<br>";
}

// Step 2: Delete cached config files
echo "<h3>Step 2: Deleting Cached Config Files</h3>";
$cache_files = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/routes.php'
];

foreach ($cache_files as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "✅ Deleted: $file<br>";
        } else {
            echo "❌ Could not delete: $file<br>";
        }
    } else {
        echo "✅ No cached file: $file<br>";
    }
}

// Step 3: Test database connection
echo "<h3>Step 3: Testing Database Connection</h3>";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    echo "✅ Database connection successful!<br>";
    
    // Check tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " tables<br>";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Step 4: Try to clear Laravel caches
echo "<h3>Step 4: Clearing Laravel Caches</h3>";
try {
    if (file_exists('bootstrap/app.php')) {
        $app = require_once 'bootstrap/app.php';
        
        // Clear config cache
        try {
            $app['Illuminate\Contracts\Console\Kernel']->call('config:clear');
            echo "✅ Config cache cleared<br>";
        } catch (Exception $e) {
            echo "❌ Config cache clear failed: " . $e->getMessage() . "<br>";
        }
        
        // Clear application cache
        try {
            $app['Illuminate\Contracts\Console\Kernel']->call('cache:clear');
            echo "✅ Application cache cleared<br>";
        } catch (Exception $e) {
            echo "❌ Application cache clear failed: " . $e->getMessage() . "<br>";
        }
        
    } else {
        echo "❌ Laravel bootstrap not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Laravel cache clear failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Test Your Site Now</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>All caches cleared and .env file fixed!</strong></p>";
echo "<p>Try visiting your main site now:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='simple-connection-test.php'>Test Database Again</a></li>";
echo "</ul>";
echo "</div>";
?>

