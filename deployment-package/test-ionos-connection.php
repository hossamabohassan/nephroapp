<?php
// Test connection using the exact IONOS connection code
echo "<h2>🧪 Testing IONOS Connection (Exact Code)</h2>";

// Your exact IONOS connection details
$host_name = 'db5018653044.hosting-data.io';
$database = 'dbs14780656';
$user_name = 'dbu1219527';
$password = '0100421606@Nephroapp';

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>Testing with exact IONOS connection details:</strong><br>";
echo "Host: <code>$host_name</code><br>";
echo "Database: <code>$database</code><br>";
echo "Username: <code>$user_name</code><br>";
echo "Password: <code>[HIDDEN]</code><br>";
echo "</div>";

// Test using mysqli (like IONOS example)
echo "<h3>Test 1: MySQLi Connection (IONOS Style)</h3>";
try {
    $link = new mysqli($host_name, $user_name, $password, $database);
    
    if ($link->connect_error) {
        echo "❌ <strong>FAILED!</strong> MySQLi connection error: " . $link->connect_error . "<br>";
    } else {
        echo "✅ <strong>SUCCESS!</strong> MySQLi connection established!<br>";
        
        // Test query
        $result = $link->query("SELECT 1 as test, NOW() as current_time");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "✅ Query successful! Current time: " . $row['current_time'] . "<br>";
        }
        
        // Check tables
        $result = $link->query("SHOW TABLES");
        if ($result) {
            $tables = [];
            while ($row = $result->fetch_array()) {
                $tables[] = $row[0];
            }
            echo "✅ Found " . count($tables) . " tables in database<br>";
            if (count($tables) > 0) {
                echo "Tables: " . implode(', ', $tables) . "<br>";
            }
        }
        
        $link->close();
    }
} catch (Exception $e) {
    echo "❌ MySQLi exception: " . $e->getMessage() . "<br>";
}

// Test using PDO (Laravel style)
echo "<h3>Test 2: PDO Connection (Laravel Style)</h3>";
try {
    $pdo = new PDO("mysql:host=$host_name;dbname=$database", $user_name, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ <strong>SUCCESS!</strong> PDO connection established!<br>";
    
    // Test query
    $stmt = $pdo->query("SELECT 1 as test, NOW() as current_time");
    $result = $stmt->fetch();
    echo "✅ Query successful! Current time: " . $result['current_time'] . "<br>";
    
    // Check tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " tables in database<br>";
    if (count($tables) > 0) {
        echo "Tables: " . implode(', ', $tables) . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ <strong>FAILED!</strong> PDO connection error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Next Steps</h3>";
echo "<ul>";
echo "<li><a href='fix-database-name.php'>Fix .env with correct database name</a></li>";
echo "<li><a href='clear-cache.php'>Clear Laravel caches</a></li>";
echo "<li><a href='index.php'>Try main site</a></li>";
echo "</ul>";
?>

