<?php
// Clear all Laravel caches to force reload of .env file
echo "<h2>🧹 Clearing Laravel Caches</h2>";

// Check if Laravel bootstrap exists
if (!file_exists('bootstrap/app.php')) {
    echo "❌ Laravel bootstrap not found. Make sure you're in the Laravel root directory.<br>";
    exit;
}

echo "<p>Clearing all Laravel caches to force reload of .env file...</p>";

try {
    // Load Laravel app
    $app = require_once 'bootstrap/app.php';
    
    echo "<h3>🧪 Cache Clearing Results:</h3>";
    
    // Clear config cache
    try {
        $app['Illuminate\Contracts\Console\Kernel']->call('config:clear');
        echo "✅ Config cache cleared<br>";
    } catch (Exception $e) {
        echo "❌ Config cache clear failed: " . $e->getMessage() . "<br>";
    }
    
    // Clear application cache
    try {
        $app['Illuminate\Contracts\Console\Kernel']->call('cache:clear');
        echo "✅ Application cache cleared<br>";
    } catch (Exception $e) {
        echo "❌ Application cache clear failed: " . $e->getMessage() . "<br>";
    }
    
    // Clear route cache
    try {
        $app['Illuminate\Contracts\Console\Kernel']->call('route:clear');
        echo "✅ Route cache cleared<br>";
    } catch (Exception $e) {
        echo "❌ Route cache clear failed: " . $e->getMessage() . "<br>";
    }
    
    // Clear view cache
    try {
        $app['Illuminate\Contracts\Console\Kernel']->call('view:clear');
        echo "✅ View cache cleared<br>";
    } catch (Exception $e) {
        echo "❌ View cache clear failed: " . $e->getMessage() . "<br>";
    }
    
    // Clear compiled services
    try {
        $app['Illuminate\Contracts\Console\Kernel']->call('clear-compiled');
        echo "✅ Compiled services cleared<br>";
    } catch (Exception $e) {
        echo "❌ Compiled services clear failed: " . $e->getMessage() . "<br>";
    }
    
    echo "<br>";
    echo "<h3>🔍 Testing Database Connection After Cache Clear</h3>";
    
    // Test database connection with fresh config
    try {
        $config = $app['config']['database.connections.mysql'];
        echo "Current database config:<br>";
        echo "Host: " . $config['host'] . "<br>";
        echo "Database: " . $config['database'] . "<br>";
        echo "Username: " . $config['username'] . "<br>";
        echo "Port: " . $config['port'] . "<br>";
        
        // Test connection
        $pdo = new PDO(
            "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}", 
            $config['username'], 
            $config['password']
        );
        echo "✅ <strong>SUCCESS!</strong> Database connection works!<br>";
        
    } catch (Exception $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Laravel app loading failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Next Steps</h3>";
echo "<ul>";
echo "<li><a href='index.php'>Try Main Site</a></li>";
echo "<li><a href='quick-db-test.php'>Test Database Again</a></li>";
echo "<li><a href='fix-username.php'>Re-fix Username</a></li>";
echo "</ul>";
?>

