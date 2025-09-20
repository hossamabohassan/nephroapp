<?php
// Verify Bootstrap Fix - Check if auth routes are now loading
echo "<h2>🔧 Bootstrap Fix Verification</h2>";

$laravelPath = __DIR__;
if (file_exists('nephroapp')) {
    $laravelPath = __DIR__ . '/nephroapp';
}
chdir($laravelPath);

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📁 Working in:</strong> " . getcwd() . "<br>";
echo "</div>";

// Test 1: Check if bootstrap/app.php has our changes
echo "<h3>Test 1: Bootstrap File Content</h3>";
if (file_exists('bootstrap/app.php')) {
    $bootstrapContent = file_get_contents('bootstrap/app.php');
    
    echo "<div style='background: #f9f9f9; padding: 10px;'>";
    
    if (strpos($bootstrapContent, 'Route::middleware') !== false) {
        echo "✅ Route middleware found in bootstrap<br>";
    } else {
        echo "❌ Route middleware NOT found in bootstrap<br>";
    }
    
    if (strpos($bootstrapContent, 'auth.php') !== false) {
        echo "✅ auth.php reference found in bootstrap<br>";
    } else {
        echo "❌ auth.php reference NOT found in bootstrap<br>";
    }
    
    if (strpos($bootstrapContent, 'use Illuminate\\Support\\Facades\\Route;') !== false) {
        echo "✅ Route facade import found<br>";
    } else {
        echo "❌ Route facade import NOT found<br>";
    }
    
    echo "<h4>Bootstrap Content Preview:</h4>";
    echo "<pre style='background: white; padding: 10px; max-height: 400px; overflow-y: auto; font-size: 12px;'>";
    echo htmlspecialchars($bootstrapContent);
    echo "</pre>";
    echo "</div>";
} else {
    echo "❌ bootstrap/app.php not found<br>";
}

// Test 2: Try to load Laravel with the new bootstrap
echo "<h3>Test 2: Laravel Loading with New Bootstrap</h3>";
try {
    require_once 'vendor/autoload.php';
    
    echo "<div style='background: #f9f9f9; padding: 10px;'>";
    echo "🔄 Loading Laravel application...<br>";
    
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel app loaded<br>";
    
    // Boot the application
    $app->boot();
    echo "✅ Laravel app booted<br>";
    
    // Get router and count routes
    $router = $app['router'];
    $allRoutes = $router->getRoutes();
    $routeCount = count($allRoutes);
    
    echo "📊 Total routes registered: $routeCount<br>";
    
    // Look specifically for auth routes
    $authRoutes = [];
    foreach ($allRoutes as $route) {
        $uri = $route->uri();
        if (in_array($uri, ['login', 'register', 'logout', 'forgot-password'])) {
            $methods = implode('|', $route->methods());
            $authRoutes[] = "$methods /$uri";
        }
    }
    
    if (!empty($authRoutes)) {
        echo "✅ Auth routes found:<br>";
        foreach ($authRoutes as $authRoute) {
            echo "&nbsp;&nbsp;• $authRoute<br>";
        }
    } else {
        echo "❌ No auth routes found in registered routes<br>";
        
        // Let's see what routes we DO have
        echo "<h4>All registered routes:</h4>";
        echo "<div style='max-height: 200px; overflow-y: auto; background: white; padding: 5px;'>";
        foreach ($allRoutes as $route) {
            $methods = implode('|', $route->methods());
            $uri = $route->uri();
            if (in_array('GET', $route->methods()) || in_array('POST', $route->methods())) {
                echo "<small>$methods /$uri</small><br>";
            }
        }
        echo "</div>";
    }
    
    echo "</div>";
    
} catch (Exception $e) {
    echo "❌ Error loading Laravel: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}

// Test 3: Direct file check
echo "<h3>Test 3: Direct File Verification</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

echo "<strong>Current server time:</strong> " . date('Y-m-d H:i:s') . "<br>";
echo "<strong>Bootstrap file modified:</strong> " . date('Y-m-d H:i:s', filemtime('bootstrap/app.php')) . "<br>";

if (file_exists('routes/auth.php')) {
    echo "<strong>Auth routes file size:</strong> " . filesize('routes/auth.php') . " bytes<br>";
} else {
    echo "❌ Auth routes file not found<br>";
}

echo "</div>";

echo "<hr>";
echo "<h3>🎯 Action Required</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px;'>";
echo "<strong>If the bootstrap changes are not found:</strong><br>";
echo "1. The file needs to be uploaded to the server<br>";
echo "2. File permissions might be preventing changes<br>";
echo "3. There might be a cached version<br>";
echo "<br>";
echo "<strong>If the bootstrap changes are found but routes still don't work:</strong><br>";
echo "1. There might be a syntax error in the bootstrap file<br>";
echo "2. Laravel might need additional configuration<br>";
echo "3. Auth middleware dependencies might be missing<br>";
echo "</div>";
?>
