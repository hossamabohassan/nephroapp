<?php
// Final database connection test with your exact IONOS credentials
echo "<h2>🔍 Final Database Connection Test</h2>";
echo "<p><strong>Testing with your exact IONOS database credentials:</strong></p>";

// Your exact IONOS database credentials
$host = 'db5018653044.hosting-data.io';
$dbname = 'consultant2';
$username = 'dbu1219527';
$password = '0100421606@Nephroapp';
$port = 3306;

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>Database Configuration:</strong><br>";
echo "Host: <code>$host</code><br>";
echo "Database: <code>$dbname</code><br>";
echo "Username: <code>$username</code><br>";
echo "Port: <code>$port</code><br>";
echo "Password: <code>[HIDDEN]</code><br>";
echo "</div>";

// Test 1: Basic PDO connection
echo "<h3>🧪 Test 1: Basic PDO Connection</h3>";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ <strong>SUCCESS!</strong> Database connection established!<br>";
    echo "✅ Connected to database: <code>$dbname</code><br>";
    
    // Test if we can query the database
    $stmt = $pdo->query("SELECT 1 as test, NOW() as current_time");
    $result = $stmt->fetch();
    echo "✅ Database query test successful!<br>";
    echo "✅ Current database time: " . $result['current_time'] . "<br>";
    
} catch (PDOException $e) {
    echo "❌ <strong>FAILED!</strong> Database connection error: " . $e->getMessage() . "<br>";
    echo "<div style='background: #ffe6e6; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
    echo "<strong>Error Details:</strong><br>";
    echo "Error Code: " . $e->getCode() . "<br>";
    echo "Error Message: " . $e->getMessage() . "<br>";
    echo "</div>";
}

// Test 2: Try different connection options
echo "<h3>🧪 Test 2: Alternative Connection Methods</h3>";

// Test with different ports
$ports = [3306, 3307, 3308, 3309];
foreach ($ports as $test_port) {
    try {
        $pdo = new PDO("mysql:host=$host;port=$test_port;dbname=$dbname", $username, $password);
        echo "✅ Connection to <code>$host:$test_port</code> successful!<br>";
        break;
    } catch (PDOException $e) {
        echo "❌ Connection to <code>$host:$test_port</code> failed: " . $e->getMessage() . "<br>";
    }
}

// Test 3: Connection with SSL options
echo "<h3>🧪 Test 3: SSL Connection Test</h3>";
try {
    $options = [
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        PDO::MYSQL_ATTR_SSL_CA => false,
    ];
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, $options);
    echo "✅ SSL connection successful!<br>";
} catch (PDOException $e) {
    echo "❌ SSL connection failed: " . $e->getMessage() . "<br>";
}

// Test 4: Check available databases
echo "<h3>🧪 Test 4: Database List</h3>";
try {
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $stmt = $pdo->query("SHOW DATABASES");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Available databases:<br>";
    echo "<ul>";
    foreach ($databases as $db) {
        $highlight = ($db === $dbname) ? " style='background: #90EE90; padding: 2px;'" : "";
        echo "<li$highlight><code>$db</code></li>";
    }
    echo "</ul>";
} catch (PDOException $e) {
    echo "❌ Could not list databases: " . $e->getMessage() . "<br>";
}

// Test 5: Check if Laravel tables exist
echo "<h3>🧪 Test 5: Laravel Tables Check</h3>";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "⚠️ No tables found in database. You need to run migrations.<br>";
    } else {
        echo "✅ Found " . count($tables) . " tables in database:<br>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li><code>$table</code></li>";
        }
        echo "</ul>";
    }
} catch (PDOException $e) {
    echo "❌ Could not check tables: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Next Steps</h3>";
echo "<p>If the connection is successful, you can:</p>";
echo "<ul>";
echo "<li><a href='fix-env.php'>Fix .env file with correct credentials</a></li>";
echo "<li><a href='index.php'>Visit your main Laravel site</a></li>";
echo "<li><a href='temp-disable-db.php'>Temporarily disable database (if connection fails)</a></li>";
echo "</ul>";
?>
