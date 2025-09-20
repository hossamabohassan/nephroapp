<?php
// Route Checker - Web-based Laravel Route Diagnostics
echo "<h2>🔍 Laravel Route Diagnostics</h2>";

// Set working directory to Laravel app
$laravelPath = __DIR__;
if (file_exists('nephroapp')) {
    $laravelPath = __DIR__ . '/nephroapp';
} elseif (file_exists('../nephroapp')) {
    $laravelPath = __DIR__ . '/../nephroapp';
}

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📁 Laravel Path:</strong> $laravelPath<br>";
echo "</div>";

// Check if we can bootstrap Laravel
echo "<h3>Test 1: Laravel Bootstrap</h3>";
try {
    chdir($laravelPath);
    
    if (!file_exists('vendor/autoload.php')) {
        echo "❌ Composer autoload not found<br>";
        exit;
    }
    
    require_once 'vendor/autoload.php';
    echo "✅ Autoloader loaded<br>";
    
    if (!file_exists('bootstrap/app.php')) {
        echo "❌ Laravel bootstrap not found<br>";
        exit;
    }
    
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel app bootstrapped<br>";
    
    // Laravel 11 compatibility - check if we can get the router
    try {
        $router = $app['router'];
        echo "✅ Router accessible<br>";
    } catch (Exception $e) {
        echo "⚠️ Router warning: " . $e->getMessage() . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    exit;
}

// Check routes
echo "<h3>Test 2: Available Routes</h3>";
try {
    // Laravel 11 - Get routes differently
    if (method_exists($app, 'router')) {
        $router = $app->router();
    } else {
        $router = $app['router'];
    }
    
    $routes = $router->getRoutes();
    
    echo "<div style='background: #f9f9f9; padding: 10px; border-radius: 5px;'>";
    echo "<strong>📋 Registered Routes:</strong><br><br>";
    
    $routeCount = 0;
    foreach ($routes as $route) {
        $methods = implode('|', $route->methods());
        $uri = $route->uri();
        $name = $route->getName() ?: 'unnamed';
        $action = $route->getActionName();
        
        echo "<div style='margin: 5px 0; padding: 5px; background: white; border-left: 3px solid #007cba;'>";
        echo "<strong>$methods</strong> /$uri → $action";
        if ($name !== 'unnamed') {
            echo " <em>($name)</em>";
        }
        echo "</div>";
        
        $routeCount++;
    }
    
    echo "<br><strong>Total Routes:</strong> $routeCount<br>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "❌ Error getting routes: " . $e->getMessage() . "<br>";
}

// Check specific routes
echo "<h3>Test 3: Check Specific Routes</h3>";
$testRoutes = ['/', 'login', 'register', 'dashboard', 'topics'];

foreach ($testRoutes as $testRoute) {
    try {
        $routeExists = false;
        foreach ($routes as $route) {
            if ($route->uri() === $testRoute || $route->uri() === ltrim($testRoute, '/')) {
                $routeExists = true;
                break;
            }
        }
        
        if ($routeExists) {
            echo "✅ Route '$testRoute' exists<br>";
        } else {
            echo "❌ Route '$testRoute' not found<br>";
        }
    } catch (Exception $e) {
        echo "❌ Error checking '$testRoute': " . $e->getMessage() . "<br>";
    }
}

// Check auth setup
echo "<h3>Test 4: Authentication Setup</h3>";
try {
    // Check if Laravel Breeze/UI is installed
    $authControllerPath = 'app/Http/Controllers/Auth';
    if (is_dir($authControllerPath)) {
        echo "✅ Auth controllers directory exists<br>";
        $authFiles = scandir($authControllerPath);
        echo "<div style='background: #f9f9f9; padding: 10px; margin: 5px 0;'>";
        echo "<strong>Auth Controllers:</strong><br>";
        foreach ($authFiles as $file) {
            if (str_ends_with($file, '.php')) {
                echo "• $file<br>";
            }
        }
        echo "</div>";
    } else {
        echo "❌ Auth controllers directory not found<br>";
        echo "<div style='background: #ffe6e6; padding: 10px; margin: 5px 0;'>";
        echo "<strong>⚠️ Authentication may not be set up</strong><br>";
        echo "You may need to install Laravel Breeze or manually create auth routes<br>";
        echo "</div>";
    }
    
    // Check web.php content
    echo "<h4>Routes/web.php content:</h4>";
    $webRoutes = file_get_contents('routes/web.php');
    echo "<pre style='background: #f9f9f9; padding: 10px; border-radius: 5px; overflow-x: auto;'>";
    echo htmlspecialchars($webRoutes);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "❌ Error checking auth setup: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Recommendations</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";
echo "<strong>Based on the analysis above:</strong><br><br>";
echo "1. If login/register routes are missing, you need to add authentication<br>";
echo "2. Check if Laravel Breeze is installed: <code>composer require laravel/breeze</code><br>";
echo "3. If routes exist but return 404, there might be a middleware issue<br>";
echo "4. Verify your .env APP_URL matches your domain<br>";
echo "</div>";
?>
