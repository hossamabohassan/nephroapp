<?php
// Deep Laravel Debug - Find out why routes aren't working
echo "<h2>🕵️ Deep Laravel Route Debug</h2>";

$laravelPath = __DIR__;
if (file_exists('nephroapp')) {
    $laravelPath = __DIR__ . '/nephroapp';
}
chdir($laravelPath);

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📁 Working in:</strong> " . getcwd() . "<br>";
echo "</div>";

// Test 1: Try to manually simulate what Laravel does
echo "<h3>Test 1: Manual Route Registration</h3>";
try {
    require_once 'vendor/autoload.php';
    
    // Create a minimal Laravel app
    $app = require_once 'bootstrap/app.php';
    
    // Try to manually register auth routes
    echo "<div style='background: #f9f9f9; padding: 10px;'>";
    echo "🔄 Attempting to manually load routes...<br>";
    
    // Get the router
    $router = $app['router'];
    
    // Before loading - check existing routes
    $routesBefore = count($router->getRoutes());
    echo "📊 Routes before loading auth.php: $routesBefore<br>";
    
    // Load auth routes manually
    $app['router']->group([], function() use ($app) {
        require base_path('routes/auth.php');
    });
    
    $routesAfter = count($router->getRoutes());
    echo "📊 Routes after loading auth.php: $routesAfter<br>";
    
    echo "📈 New routes added: " . ($routesAfter - $routesBefore) . "<br>";
    echo "</div>";
    
    // List all routes now
    echo "<h4>All Registered Routes:</h4>";
    echo "<div style='background: #f9f9f9; padding: 10px; max-height: 300px; overflow-y: auto;'>";
    
    foreach ($router->getRoutes() as $route) {
        $methods = implode('|', $route->methods());
        $uri = $route->uri();
        $name = $route->getName() ?: 'unnamed';
        
        // Skip OPTIONS/HEAD only routes
        if (in_array('GET', $route->methods()) || in_array('POST', $route->methods())) {
            echo "<div style='margin: 2px 0; padding: 3px; background: white; border-left: 2px solid #007cba;'>";
            echo "<strong>$methods</strong> /$uri";
            if ($name !== 'unnamed') {
                echo " <em>($name)</em>";
            }
            echo "</div>";
        }
    }
    echo "</div>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}

// Test 2: Check Laravel's actual bootstrap process
echo "<h3>Test 2: Laravel Bootstrap Process</h3>";
try {
    echo "<div style='background: #f9f9f9; padding: 10px;'>";
    
    // Check bootstrap/app.php
    if (file_exists('bootstrap/app.php')) {
        echo "✅ bootstrap/app.php exists<br>";
        $bootstrapContent = file_get_contents('bootstrap/app.php');
        echo "📄 Bootstrap file size: " . strlen($bootstrapContent) . " bytes<br>";
        
        // Look for route service provider
        if (strpos($bootstrapContent, 'Route') !== false) {
            echo "✅ Route-related content found in bootstrap<br>";
        } else {
            echo "⚠️ No Route-related content in bootstrap<br>";
        }
    }
    
    // Check if RouteServiceProvider exists
    if (file_exists('app/Providers/RouteServiceProvider.php')) {
        echo "✅ RouteServiceProvider exists<br>";
    } else {
        echo "❌ RouteServiceProvider missing (Laravel 11 doesn't use it)<br>";
    }
    
    // Check routes directory
    echo "<strong>📁 Routes directory:</strong><br>";
    $routeFiles = scandir('routes');
    foreach ($routeFiles as $file) {
        if (str_ends_with($file, '.php')) {
            $size = filesize("routes/$file");
            echo "&nbsp;&nbsp;• $file ($size bytes)<br>";
        }
    }
    echo "</div>";
    
} catch (Exception $e) {
    echo "❌ Error in bootstrap check: " . $e->getMessage() . "<br>";
}

// Test 3: Simulate a web request to login
echo "<h3>Test 3: Simulate Login Request</h3>";
try {
    echo "<div style='background: #f9f9f9; padding: 10px;'>";
    
    // Set up request simulation
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/login';
    $_SERVER['HTTP_HOST'] = 'nephroapp.com';
    
    echo "🔧 Request setup:<br>";
    echo "&nbsp;&nbsp;METHOD: GET<br>";
    echo "&nbsp;&nbsp;URI: /login<br>";
    echo "&nbsp;&nbsp;HOST: nephroapp.com<br>";
    
    // Try to handle the request
    $request = \Illuminate\Http\Request::capture();
    echo "✅ Request captured<br>";
    
    echo "🎯 Request path: " . $request->path() . "<br>";
    echo "🎯 Request URL: " . $request->url() . "<br>";
    
    echo "</div>";
    
} catch (Exception $e) {
    echo "❌ Error simulating request: " . $e->getMessage() . "<br>";
}

// Test 4: Check middleware
echo "<h3>Test 4: Middleware Check</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

try {
    // Check if guest middleware exists
    if (class_exists('App\Http\Middleware\Authenticate')) {
        echo "✅ Authenticate middleware exists<br>";
    }
    
    if (class_exists('App\Http\Middleware\RedirectIfAuthenticated')) {
        echo "✅ RedirectIfAuthenticated (guest) middleware exists<br>";
    } else {
        echo "❌ Guest middleware missing<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error checking middleware: " . $e->getMessage() . "<br>";
}

echo "</div>";

echo "<hr>";
echo "<h3>🎯 Direct Test URLs</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";
echo "<strong>Test these URLs in your browser:</strong><br><br>";
echo "1. <a href='/nephroapp/public/' target='_blank'>Homepage: /nephroapp/public/</a><br>";
echo "2. <a href='/nephroapp/public/login' target='_blank'>Login: /nephroapp/public/login</a><br>";
echo "3. <a href='/nephroapp/public/register' target='_blank'>Register: /nephroapp/public/register</a><br>";
echo "<br>";
echo "<strong>If all show 404, the issue is:</strong><br>";
echo "• Laravel isn't properly loading routes from auth.php<br>";
echo "• Routes are being registered but not matched<br>";
echo "• There's a fundamental routing issue<br>";
echo "</div>";
?>
