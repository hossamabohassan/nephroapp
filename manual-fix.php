<?php
// Manual Laravel Fix - Clean everything and test
echo "<h2>🔧 Manual Laravel Fix</h2>";

$laravelPath = __DIR__;
if (file_exists('nephroapp')) {
    $laravelPath = __DIR__ . '/nephroapp';
}
chdir($laravelPath);

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📁 Working in:</strong> " . getcwd() . "<br>";
echo "</div>";

// Step 1: Clear all cache files manually
echo "<h3>Step 1: Manual Cache Clearing</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

// Clear bootstrap cache
$bootstrapCacheFiles = glob('bootstrap/cache/*');
foreach ($bootstrapCacheFiles as $file) {
    if (is_file($file)) {
        unlink($file);
        echo "✅ Deleted: " . basename($file) . "<br>";
    }
}

// Clear framework cache
$frameworkDirs = [
    'storage/framework/cache/data',
    'storage/framework/views', 
    'storage/framework/sessions'
];

foreach ($frameworkDirs as $dir) {
    if (is_dir($dir)) {
        $files = glob("$dir/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "✅ Cleared: $dir<br>";
    } else {
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created: $dir<br>";
        }
    }
}

echo "</div>";

// Step 2: Check critical files
echo "<h3>Step 2: Critical File Check</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$criticalFiles = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    'routes/web.php',
    'routes/auth.php',
    '.env',
    'app/Http/Kernel.php'
];

foreach ($criticalFiles as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "✅ $file ($size bytes)<br>";
    } else {
        echo "❌ $file MISSING<br>";
    }
}

echo "</div>";

// Step 3: Try minimal Laravel bootstrap
echo "<h3>Step 3: Minimal Laravel Test</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

try {
    // Try to load just the autoloader
    require_once 'vendor/autoload.php';
    echo "✅ Autoloader works<br>";
    
    // Try to create a simple Laravel request handler
    $app = require_once 'bootstrap/app.php';
    echo "✅ Bootstrap works<br>";
    
    // Set up a fake web request
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/login';
    $_SERVER['HTTP_HOST'] = 'nephroapp.com';
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    
    $request = \Illuminate\Http\Request::capture();
    echo "✅ Request created<br>";
    
    // Try to handle the request (this will show if routes work)
    $response = $app->handleRequest($request);
    $statusCode = $response->getStatusCode();
    
    echo "<strong>🎯 Test Result:</strong><br>";
    echo "Status Code: $statusCode<br>";
    
    if ($statusCode == 200) {
        echo "✅ LOGIN ROUTE WORKS!<br>";
    } elseif ($statusCode == 404) {
        echo "❌ Login route returns 404 (route not found)<br>";
    } elseif ($statusCode == 500) {
        echo "❌ Login route returns 500 (server error)<br>";
    } else {
        echo "⚠️ Login route returns: $statusCode<br>";
    }
    
    // Get response content preview
    $content = $response->getContent();
    if (strlen($content) > 0) {
        echo "<strong>Response preview:</strong><br>";
        echo "<div style='background: white; padding: 5px; max-height: 200px; overflow-y: auto; font-size: 12px;'>";
        echo htmlspecialchars(substr($content, 0, 500));
        if (strlen($content) > 500) echo "...";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    
    // Try to identify the specific issue
    if (strpos($e->getMessage(), 'files') !== false) {
        echo "<br><strong>🔍 This looks like a filesystem driver issue</strong><br>";
        echo "Let's check config/filesystems.php...<br>";
        
        if (file_exists('config/filesystems.php')) {
            echo "✅ Filesystems config exists<br>";
        } else {
            echo "❌ Filesystems config MISSING<br>";
        }
    }
}

echo "</div>";

// Step 4: Alternative route test
echo "<h3>Step 4: Direct Route File Test</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

echo "<strong>Testing direct inclusion of auth routes:</strong><br>";
try {
    // Try to evaluate the auth routes file directly
    ob_start();
    $routeContent = file_get_contents('routes/auth.php');
    
    // Count route definitions
    $getRoutes = substr_count($routeContent, "Route::get(");
    $postRoutes = substr_count($routeContent, "Route::post(");
    
    echo "📊 Found in auth.php:<br>";
    echo "&nbsp;&nbsp;• GET routes: $getRoutes<br>";
    echo "&nbsp;&nbsp;• POST routes: $postRoutes<br>";
    
    if (strpos($routeContent, "'login'") !== false) {
        echo "✅ Login route definition found<br>";
    }
    if (strpos($routeContent, "'register'") !== false) {
        echo "✅ Register route definition found<br>";
    }
    
    ob_end_clean();
    
} catch (Exception $e) {
    echo "❌ Error reading auth routes: " . $e->getMessage() . "<br>";
}

echo "</div>";

echo "<hr>";
echo "<h3>🎯 Next Steps</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";
echo "<strong>Based on the test results:</strong><br><br>";

echo "1. If the minimal test shows 200: Routes work, problem is with URL rewriting<br>";
echo "2. If the minimal test shows 404: Routes aren't loading properly<br>";
echo "3. If the minimal test shows 500: There's a Laravel configuration issue<br>";
echo "4. If the minimal test fails: Core Laravel files are corrupted<br>";
echo "<br>";

echo "<strong>Manual test URLs to try:</strong><br>";
echo "• <a href='/nephroapp/public/login' target='_blank'>Direct login test</a><br>";
echo "• <a href='/nephroapp/public/register' target='_blank'>Direct register test</a><br>";
echo "</div>";
?>
