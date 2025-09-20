<?php
// Test database connection with your actual IONOS credentials
echo "<h2>Database Connection Test - IONOS Credentials</h2>";

// Your actual IONOS database credentials
$host = 'db5018653044.hosting-data.io';
$dbname = 'consultant2';
$username = 'dbu1219527';
$password = '0100421606@Nephroapp';
$port = 3306;

echo "<h3>Testing with your actual IONOS credentials:</h3>";
echo "Host: $host<br>";
echo "Database: $dbname<br>";
echo "Username: $username<br>";
echo "Port: $port<br><br>";

// Test 1: Basic PDO connection
echo "<h3>Test 1: Basic PDO Connection</h3>";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    echo "✅ Database connection successful!<br>";
    echo "Connected to database: $dbname<br>";
    
    // Test if we can query the database
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "✅ Database query test successful!<br>";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Test 2: Try different port options
echo "<h3>Test 2: Different Port Options</h3>";
$ports = [3306, 3307, 3308];
foreach ($ports as $test_port) {
    try {
        $pdo = new PDO("mysql:host=$host;port=$test_port;dbname=$dbname", $username, $password);
        echo "✅ Connection to $host:$test_port successful<br>";
        break;
    } catch (PDOException $e) {
        echo "❌ Connection to $host:$test_port failed: " . $e->getMessage() . "<br>";
    }
}

// Test 3: Check if we can connect without database name
echo "<h3>Test 3: Connection without database name</h3>";
try {
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    echo "✅ Connection to MySQL server successful (without database)<br>";
    
    // List available databases
    $stmt = $pdo->query("SHOW DATABASES");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Available databases:<br>";
    foreach ($databases as $db) {
        echo "- $db<br>";
    }
} catch (PDOException $e) {
    echo "❌ Connection to MySQL server failed: " . $e->getMessage() . "<br>";
}

// Test 4: Test with SSL (sometimes required by IONOS)
echo "<h3>Test 4: Connection with SSL options</h3>";
try {
    $options = [
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        PDO::MYSQL_ATTR_SSL_CA => false,
    ];
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, $options);
    echo "✅ Database connection with SSL options successful!<br>";
} catch (PDOException $e) {
    echo "❌ Database connection with SSL options failed: " . $e->getMessage() . "<br>";
}
?>

