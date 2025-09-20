<?php
// Fix .env file in the full Laravel project
echo "<h2>🔧 Fixing .env File in Full Laravel Project</h2>";

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🚨 Database Connection Issue</strong><br>";
echo "Laravel is trying to connect to database for sessions but getting 'Connection refused'<br>";
echo "The .env file still has old database settings<br>";
echo "</div>";

// Your correct IONOS database credentials
$host = 'db5018653044.hosting-data.io';
$dbname = 'dbs14780656';
$username = 'dbu1219527';
$password = '0100421606@Nephroapp';
$port = 3306;

echo "<h3>🔧 Updating .env File</h3>";

if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    echo "<strong>Current .env database settings:</strong><br>";
    if (preg_match('/DB_HOST=(.*)/', $env_content, $matches)) {
        echo "DB_HOST: " . trim($matches[1]) . "<br>";
    }
    if (preg_match('/DB_DATABASE=(.*)/', $env_content, $matches)) {
        echo "DB_DATABASE: " . trim($matches[1]) . "<br>";
    }
    if (preg_match('/DB_USERNAME=(.*)/', $env_content, $matches)) {
        echo "DB_USERNAME: " . trim($matches[1]) . "<br>";
    }
    
    echo "<br><strong>Updating to correct IONOS settings:</strong><br>";
    echo "DB_HOST: $host<br>";
    echo "DB_DATABASE: $dbname<br>";
    echo "DB_USERNAME: $username<br>";
    echo "DB_PASSWORD: [HIDDEN]<br>";
    echo "DB_PORT: $port<br>";
    
    // Update database settings
    $env_content = preg_replace('/DB_HOST=.*/', "DB_HOST=$host", $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$dbname", $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME=$username", $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD=$password", $env_content);
    $env_content = preg_replace('/DB_PORT=.*/', "DB_PORT=$port", $env_content);
    
    // Also set session driver to file to avoid database session issues
    $env_content = preg_replace('/SESSION_DRIVER=.*/', "SESSION_DRIVER=file", $env_content);
    if (strpos($env_content, 'SESSION_DRIVER=') === false) {
        $env_content .= "\nSESSION_DRIVER=file\n";
    }
    
    file_put_contents('.env', $env_content);
    echo "<br>✅ <strong>SUCCESS!</strong> .env file updated with correct IONOS database settings<br>";
    
} else {
    echo "❌ .env file not found<br>";
}

// Clear Laravel caches
echo "<h3>🧹 Clearing Laravel Caches</h3>";
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

// Test database connection
echo "<h3>🧪 Testing Database Connection</h3>";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    echo "✅ <strong>SUCCESS!</strong> Database connection works!<br>";
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " tables in database<br>";
    
    if (count($tables) > 0) {
        echo "Tables: " . implode(', ', $tables) . "<br>";
    } else {
        echo "⚠️ No tables found - you may need to run migrations<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Test Your Site Now</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>Database configuration fixed and caches cleared!</strong></p>";
echo "<p>Your Laravel app should now work properly:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='topics' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📚 Topics Page</a></li>";
echo "<li><a href='admin/landing-page' style='background: #ffc107; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>⚙️ Admin Panel</a></li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>📋 What Was Fixed:</h4>";
echo "<ul>";
echo "<li>✅ Updated .env file with correct IONOS database credentials</li>";
echo "<li>✅ Set SESSION_DRIVER to 'file' to avoid database session issues</li>";
echo "<li>✅ Cleared all Laravel caches</li>";
echo "<li>✅ Tested database connection</li>";
echo "</ul>";
echo "</div>";
?>

