<?php
// Quick database test with timeout protection
echo "<h2>🚀 Quick Database Test</h2>";

// Set a short timeout to prevent hanging
set_time_limit(10);

// Your IONOS database credentials
$host = 'db5018653044.hosting-data.io';
$dbname = 'consultant2';
$username = 'dbu1219527';
$password = '0100421606@Nephroapp';
$port = 3306;

echo "<p><strong>Testing connection to:</strong> $host:$port</p>";

// Test 1: Basic connection with timeout
echo "<h3>Test 1: Basic Connection</h3>";
try {
    // Set connection timeout
    $options = [
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, $options);
    echo "✅ <strong>SUCCESS!</strong> Connected to database!<br>";
    
    // Quick test query
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "✅ Database query works!<br>";
    
} catch (PDOException $e) {
    echo "❌ <strong>FAILED!</strong> " . $e->getMessage() . "<br>";
    echo "Error Code: " . $e->getCode() . "<br>";
}

// Test 2: Try without database name
echo "<h3>Test 2: Server Connection (no database)</h3>";
try {
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password, $options);
    echo "✅ <strong>SUCCESS!</strong> Connected to MySQL server!<br>";
} catch (PDOException $e) {
    echo "❌ <strong>FAILED!</strong> " . $e->getMessage() . "<br>";
}

// Test 3: Check if it's a network issue
echo "<h3>Test 3: Network Test</h3>";
$start_time = microtime(true);
$connection = @fsockopen($host, $port, $errno, $errstr, 5);
$end_time = microtime(true);

if ($connection) {
    echo "✅ <strong>SUCCESS!</strong> Can reach $host:$port<br>";
    echo "Response time: " . round(($end_time - $start_time) * 1000, 2) . "ms<br>";
    fclose($connection);
} else {
    echo "❌ <strong>FAILED!</strong> Cannot reach $host:$port<br>";
    echo "Error: $errstr ($errno)<br>";
}

echo "<hr>";
echo "<h3>🎯 Quick Actions</h3>";
echo "<ul>";
echo "<li><a href='fix-env-final.php'>Fix .env file</a></li>";
echo "<li><a href='index.php'>Try main site</a></li>";
echo "<li><a href='temp-disable-db.php'>Disable database temporarily</a></li>";
echo "</ul>";
?>
