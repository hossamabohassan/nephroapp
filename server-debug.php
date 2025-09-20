<?php
echo "<h1>🚨 Laravel Server Debug Tool</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.success { color: green; }
.error { color: red; }
.warning { color: orange; }
.section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
pre { background: #f5f5f5; padding: 10px; overflow-x: auto; }
</style>";

echo "<div class='section'>";
echo "<h2>📋 System Information</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "<br>";
echo "</div>";

echo "<div class='section'>";
echo "<h2>📁 File Structure Check</h2>";
$files_to_check = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    'public/index.php',
    'public/.htaccess',
    '.env',
    'routes/web.php',
    'app/Http/Kernel.php',
    'resources/views/landing.blade.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "<span class='success'>✅ $file exists</span><br>";
    } else {
        echo "<span class='error'>❌ $file missing</span><br>";
    }
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>🔧 Laravel Bootstrap Test</h2>";
try {
    require_once 'vendor/autoload.php';
    echo "<span class='success'>✅ Autoloader loaded</span><br>";
    
    $app = require_once 'bootstrap/app.php';
    echo "<span class='success'>✅ Bootstrap loaded</span><br>";
    
    echo "App Name: " . config('app.name', 'Not Set') . "<br>";
    echo "App Environment: " . app()->environment() . "<br>";
    echo "App Debug: " . (config('app.debug') ? 'Enabled' : 'Disabled') . "<br>";
    
} catch (Exception $e) {
    echo "<span class='error'>❌ Bootstrap Error: " . $e->getMessage() . "</span><br>";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "<br>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>🗄️ Database Connection Test</h2>";
try {
    $config = [
        'host' => env('DB_HOST'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'port' => env('DB_PORT', 3306)
    ];
    
    echo "Host: " . $config['host'] . "<br>";
    echo "Database: " . $config['database'] . "<br>";
    echo "Username: " . $config['username'] . "<br>";
    echo "Port: " . $config['port'] . "<br>";
    
    $pdo = new PDO(
        "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
        $config['username'],
        $config['password']
    );
    echo "<span class='success'>✅ Database connection successful</span><br>";
    
} catch (Exception $e) {
    echo "<span class='error'>❌ Database Error: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>🛣️ Route Testing</h2>";
try {
    $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
    echo "<span class='success'>✅ HTTP Kernel loaded</span><br>";
    
    // Test basic route resolution
    $routes = app('router')->getRoutes();
    echo "Total routes registered: " . count($routes) . "<br>";
    
    // Try to get route list
    foreach ($routes as $route) {
        $methods = implode('|', $route->methods());
        $uri = $route->uri();
        echo "<span class='success'>Route: $methods $uri</span><br>";
        if (count($routes) > 10) break; // Limit output
    }
    
} catch (Exception $e) {
    echo "<span class='error'>❌ Route Error: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>📄 .htaccess Check</h2>";
if (file_exists('public/.htaccess')) {
    echo "<span class='success'>✅ public/.htaccess exists</span><br>";
    echo "<pre>" . htmlspecialchars(file_get_contents('public/.htaccess')) . "</pre>";
} else {
    echo "<span class='error'>❌ public/.htaccess missing</span><br>";
}

if (file_exists('.htaccess')) {
    echo "<span class='warning'>⚠️ Root .htaccess exists (might conflict)</span><br>";
    echo "<pre>" . htmlspecialchars(file_get_contents('.htaccess')) . "</pre>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>🔍 Error Logs</h2>";
if (file_exists('storage/logs/laravel.log')) {
    echo "<span class='success'>✅ Laravel log exists</span><br>";
    $logContent = file_get_contents('storage/logs/laravel.log');
    $lastLines = array_slice(explode("\n", $logContent), -20);
    echo "<pre>" . htmlspecialchars(implode("\n", $lastLines)) . "</pre>";
} else {
    echo "<span class='error'>❌ Laravel log missing</span><br>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>🔗 Quick Tests</h2>";
echo "<a href='/' target='_blank'>Test Home Page</a><br>";
echo "<a href='/topics' target='_blank'>Test Topics Page</a><br>";
echo "<a href='/login' target='_blank'>Test Login Page</a><br>";
echo "<a href='/admin' target='_blank'>Test Admin Page</a><br>";
echo "</div>";

echo "<h3>🎯 Next Steps</h3>";
echo "<ol>";
echo "<li>Check if all files exist ✅</li>";
echo "<li>Verify Laravel bootstrap works ✅</li>";
echo "<li>Test database connection ✅</li>";
echo "<li>Check route registration ✅</li>";
echo "<li>Verify .htaccess configuration ✅</li>";
echo "<li>Check error logs for clues ✅</li>";
echo "</ol>";
?>

