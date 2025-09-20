<?php
// Test database connection with different configurations
echo "<h2>Database Connection Test</h2>";

// Test 1: Basic PDO connection
echo "<h3>Test 1: Basic PDO Connection</h3>";
$host = 'localhost';
$dbname = 'your_database_name';  // Replace with your actual database name
$username = 'your_username';     // Replace with your actual username
$password = 'your_password';     // Replace with your actual password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "✅ Database connection successful!<br>";
    echo "Database: $dbname<br>";
    echo "Host: $host<br>";
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Test 2: Try different hosts
echo "<h3>Test 2: Different Host Options</h3>";
$hosts = ['localhost', '127.0.0.1', 'mysql.ionos.com'];
foreach ($hosts as $test_host) {
    try {
        $pdo = new PDO("mysql:host=$test_host", $username, $password);
        echo "✅ Connection to $test_host successful<br>";
    } catch (PDOException $e) {
        echo "❌ Connection to $test_host failed: " . $e->getMessage() . "<br>";
    }
}

// Test 3: Check if MySQL extension is loaded
echo "<h3>Test 3: PHP Extensions</h3>";
if (extension_loaded('pdo')) {
    echo "✅ PDO extension loaded<br>";
} else {
    echo "❌ PDO extension NOT loaded<br>";
}

if (extension_loaded('pdo_mysql')) {
    echo "✅ PDO MySQL extension loaded<br>";
} else {
    echo "❌ PDO MySQL extension NOT loaded<br>";
}

// Test 4: Show current .env database settings
echo "<h3>Test 4: Current .env Database Settings</h3>";
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    $lines = explode("\n", $env_content);
    foreach ($lines as $line) {
        if (strpos($line, 'DB_') === 0) {
            echo htmlspecialchars($line) . "<br>";
        }
    }
} else {
    echo "❌ .env file not found<br>";
}

// Test 5: Try to connect without database name first
echo "<h3>Test 5: Connection without database name</h3>";
try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
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
?>
