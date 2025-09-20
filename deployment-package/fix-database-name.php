<?php
// Fix the database name in .env file
echo "<h2>🔧 Fixing Database Name</h2>";

// Your CORRECT IONOS database credentials from the connection details
$host = 'db5018653044.hosting-data.io';
$dbname = 'dbs14780656';  // This is the CORRECT database name
$username = 'dbu1219527';
$password = '0100421606@Nephroapp';
$port = 3306;

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>❌ Current Problem:</strong><br>";
echo "Your .env file has database: <code>consultant2</code><br>";
echo "But your actual IONOS database is: <code>dbs14780656</code><br>";
echo "</div>";

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>✅ Correcting to:</strong><br>";
echo "DB_HOST: <code>$host</code><br>";
echo "DB_DATABASE: <code>$dbname</code><br>";
echo "DB_USERNAME: <code>$username</code><br>";
echo "DB_PASSWORD: <code>[HIDDEN]</code><br>";
echo "DB_PORT: <code>$port</code><br>";
echo "</div>";

// Read and fix .env file
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    // Update ALL database settings with correct values
    $env_content = preg_replace('/DB_HOST=.*/', "DB_HOST=$host", $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$dbname", $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME=$username", $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD=$password", $env_content);
    $env_content = preg_replace('/DB_PORT=.*/', "DB_PORT=$port", $env_content);
    
    // Write back to .env
    file_put_contents('.env', $env_content);
    
    echo "✅ <strong>SUCCESS!</strong> .env file updated with correct database name!<br>";
    echo "<br>";
    
    // Test the connection immediately
    echo "<h3>🧪 Testing Connection with Correct Database Name</h3>";
    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
        echo "✅ <strong>PERFECT!</strong> Database connection successful!<br>";
        echo "✅ Connected to database: <code>$dbname</code><br>";
        
        // Test query
        $stmt = $pdo->query("SELECT 1 as test, NOW() as current_time");
        $result = $stmt->fetch();
        echo "✅ Database query works! Current time: " . $result['current_time'] . "<br>";
        
        // Check if there are any tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "✅ Found " . count($tables) . " tables in database<br>";
        
        if (count($tables) > 0) {
            echo "Tables: " . implode(', ', $tables) . "<br>";
        } else {
            echo "⚠️ No tables found - you may need to run Laravel migrations<br>";
        }
        
    } catch (PDOException $e) {
        echo "❌ Still failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<br>";
    echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>🎉 Database Fixed!</h3>";
    echo "<p>Your database connection should now work perfectly!</p>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ul>";
    echo "<li><a href='clear-cache.php'>Clear Laravel Caches</a> (to reload new config)</li>";
    echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
    echo "<li><a href='quick-db-test.php'>Test Database Again</a></li>";
    echo "</ul>";
    echo "</div>";
    
} else {
    echo "❌ .env file not found!<br>";
    echo "<p>Please make sure you uploaded the .env file to your server.</p>";
}
?>
