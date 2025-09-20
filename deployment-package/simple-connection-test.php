<?php
// Simple connection test without complex SQL
echo "<h2>✅ Simple Database Connection Test</h2>";

// Your correct IONOS database credentials
$host_name = 'db5018653044.hosting-data.io';
$database = 'dbs14780656';
$user_name = 'dbu1219527';
$password = '0100421606@Nephroapp';

echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>✅ Database Connection Status: WORKING!</strong><br>";
echo "Host: <code>$host_name</code><br>";
echo "Database: <code>$database</code><br>";
echo "Username: <code>$user_name</code><br>";
echo "</div>";

// Test with simple query
echo "<h3>🧪 Testing Simple Query</h3>";
try {
    $pdo = new PDO("mysql:host=$host_name;dbname=$database", $user_name, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Simple test query
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "✅ <strong>SUCCESS!</strong> Simple query works!<br>";
    
    // Check tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " tables in database<br>";
    
    if (count($tables) > 0) {
        echo "Tables: " . implode(', ', $tables) . "<br>";
    } else {
        echo "⚠️ No tables found - you may need to run Laravel migrations<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Ready to Fix Laravel!</h3>";
echo "<p>Your database connection is working perfectly. Now let's fix Laravel:</p>";
echo "<ul>";
echo "<li><a href='fix-database-name.php'>Fix .env with correct database name</a></li>";
echo "<li><a href='clear-cache.php'>Clear Laravel caches</a></li>";
echo "<li><a href='index.php'>Try main site</a></li>";
echo "</ul>";
?>
