<?php
// Ultra-simple test to check if PHP is working
echo "<h1>✅ PHP is Working!</h1>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";

// Test if we can include Laravel
echo "<h2>Testing Laravel Bootstrap</h2>";
try {
    if (file_exists('bootstrap/app.php')) {
        echo "✅ Laravel bootstrap file exists<br>";
        
        // Try to load Laravel
        $app = require_once 'bootstrap/app.php';
        echo "✅ Laravel app loaded successfully<br>";
        
        // Test database config
        $config = $app['config']['database.connections.mysql'];
        echo "✅ Database config loaded<br>";
        echo "Host: " . $config['host'] . "<br>";
        echo "Database: " . $config['database'] . "<br>";
        echo "Username: " . $config['username'] . "<br>";
        
    } else {
        echo "❌ Laravel bootstrap file not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Laravel error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>Quick Links</h3>";
echo "<ul>";
echo "<li><a href='quick-db-test.php'>Quick Database Test</a></li>";
echo "<li><a href='index.php'>Main Site</a></li>";
echo "<li><a href='temp-disable-db.php'>Disable Database</a></li>";
echo "</ul>";
?>
