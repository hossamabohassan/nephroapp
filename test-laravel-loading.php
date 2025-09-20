<?php
// Test Laravel loading without .htaccess
echo "<h2>🧪 Testing Laravel Loading</h2>";

echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>✅ .htaccess is disabled</strong><br>";
echo "Now let's test if Laravel can load properly<br>";
echo "</div>";

// Test 1: Check vendor directory
echo "<h3>Test 1: Vendor Directory</h3>";
if (is_dir('vendor')) {
    echo "✅ Vendor directory exists<br>";
} else {
    echo "❌ Vendor directory missing<br>";
}

// Test 2: Check autoloader
echo "<h3>Test 2: Autoloader</h3>";
if (file_exists('vendor/autoload.php')) {
    echo "✅ Autoloader exists<br>";
    
    try {
        require_once 'vendor/autoload.php';
        echo "✅ Autoloader loaded successfully<br>";
    } catch (Exception $e) {
        echo "❌ Autoloader failed: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Autoloader missing<br>";
}

// Test 3: Check Laravel classes
echo "<h3>Test 3: Laravel Classes</h3>";
if (class_exists('Illuminate\Foundation\Application')) {
    echo "✅ Application class found<br>";
} else {
    echo "❌ Application class missing<br>";
}

// Test 4: Try to load Laravel app
echo "<h3>Test 4: Laravel App Loading</h3>";
try {
    if (file_exists('bootstrap/app.php')) {
        echo "✅ Bootstrap file exists<br>";
        
        $app = require_once 'bootstrap/app.php';
        echo "✅ Laravel app loaded successfully<br>";
        
        // Test config
        $config = $app['config']['database.connections.mysql'];
        echo "✅ Database config loaded<br>";
        echo "Host: " . $config['host'] . "<br>";
        echo "Database: " . $config['database'] . "<br>";
        echo "Username: " . $config['username'] . "<br>";
        
    } else {
        echo "❌ Bootstrap file missing<br>";
    }
} catch (Exception $e) {
    echo "❌ Laravel app loading failed: " . $e->getMessage() . "<br>";
    echo "Error details: " . $e->getTraceAsString() . "<br>";
}

// Test 5: Database connection
echo "<h3>Test 5: Database Connection</h3>";
try {
    $pdo = new PDO(
        "mysql:host=db5018653044.hosting-data.io;port=3306;dbname=dbs14780656", 
        'dbu1219527', 
        '0100421606@Nephroapp'
    );
    echo "✅ Database connection works<br>";
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " tables<br>";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Next Steps</h3>";
echo "<ul>";
echo "<li><a href='fix-vendor-now.php'>Fix Vendor Directory</a></li>";
echo "<li><a href='index.php'>Test Main Site</a></li>";
echo "<li><a href='debug-current-500.php'>Debug 500 Error</a></li>";
echo "</ul>";
?>

