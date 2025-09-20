<?php
// Laravel 11 Compatible Route Checker
echo "<h2>🔍 Laravel Route Diagnostics (Laravel 11 Compatible)</h2>";

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
    
    // Laravel 11 - Get the application instance
    echo "✅ Application instance created<br>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    exit;
}

// Check routes using Laravel 11 method
echo "<h3>Test 2: Available Routes (Laravel 11)</h3>";
try {
    // Laravel 11 way to get routes
    $kernel = $app->make(Illuminate\Foundation\Http\Kernel::class);
    
    // Boot the application to register routes
    $app->boot();
    
    // Get the router
    $router = $app['router'];
    $routes = $router->getRoutes();
    
    echo "<div style='background: #f9f9f9; padding: 10px; border-radius: 5px;'>";
    echo "<strong>📋 Registered Routes:</strong><br><br>";
    
    $routeCount = 0;
    $foundRoutes = [];
    
    foreach ($routes as $route) {
        $methods = implode('|', $route->methods());
        $uri = $route->uri();
        $name = $route->getName() ?: 'unnamed';
        $action = $route->getActionName();
        
        // Skip HEAD and OPTIONS only routes
        if (!in_array('GET', $route->methods()) && !in_array('POST', $route->methods())) {
            continue;
        }
        
        $foundRoutes[] = [
            'methods' => $methods,
            'uri' => $uri,
            'name' => $name,
            'action' => $action
        ];
        
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
    echo "Trying alternative method...<br>";
    
    // Alternative method - directly read route files
    echo "<h4>Reading Route Files Directly:</h4>";
    echo "<div style='background: #f9f9f9; padding: 10px; border-radius: 5px;'>";
    
    // Read auth.php
    if (file_exists('routes/auth.php')) {
        echo "<strong>📄 routes/auth.php exists:</strong><br>";
        $authContent = file_get_contents('routes/auth.php');
        preg_match_all("/Route::(get|post)\s*\(\s*['\"]([^'\"]+)['\"].*?name\s*\(\s*['\"]([^'\"]+)['\"]/", $authContent, $matches);
        
        for ($i = 0; $i < count($matches[0]); $i++) {
            echo "• {$matches[1][$i]} /{$matches[2][$i]} ({$matches[3][$i]})<br>";
        }
        echo "<br>";
    }
    
    // Read web.php  
    if (file_exists('routes/web.php')) {
        echo "<strong>📄 routes/web.php exists:</strong><br>";
        $webContent = file_get_contents('routes/web.php');
        preg_match_all("/Route::(get|post)\s*\(\s*['\"]([^'\"]+)['\"].*?name\s*\(\s*['\"]([^'\"]+)['\"]/", $webContent, $matches);
        
        for ($i = 0; $i < count($matches[0]); $i++) {
            echo "• {$matches[1][$i]} /{$matches[2][$i]} ({$matches[3][$i]})<br>";
        }
    }
    
    echo "</div>";
}

// Check specific routes
echo "<h3>Test 3: Check Specific Routes</h3>";
$testRoutes = ['/', 'login', 'register', 'dashboard', 'topics'];

echo "<div style='background: #f9f9f9; padding: 10px; border-radius: 5px;'>";
foreach ($testRoutes as $testRoute) {
    $routeExists = false;
    
    if (isset($foundRoutes)) {
        foreach ($foundRoutes as $route) {
            if ($route['uri'] === $testRoute || $route['uri'] === ltrim($testRoute, '/')) {
                $routeExists = true;
                break;
            }
        }
    }
    
    if ($routeExists) {
        echo "✅ Route '$testRoute' exists<br>";
    } else {
        echo "❌ Route '$testRoute' not found<br>";
    }
}
echo "</div>";

// Test direct access to auth controllers
echo "<h3>Test 4: Authentication Controllers</h3>";
try {
    $authControllerPath = 'app/Http/Controllers/Auth';
    if (is_dir($authControllerPath)) {
        echo "✅ Auth controllers directory exists<br>";
        $authFiles = scandir($authControllerPath);
        echo "<div style='background: #f9f9f9; padding: 10px; margin: 5px 0;'>";
        echo "<strong>Auth Controllers:</strong><br>";
        foreach ($authFiles as $file) {
            if (str_ends_with($file, '.php')) {
                echo "• $file<br>";
                
                // Check if specific controllers exist
                if ($file === 'AuthenticatedSessionController.php') {
                    echo "&nbsp;&nbsp;→ Login controller ✅<br>";
                }
                if ($file === 'RegisteredUserController.php') {
                    echo "&nbsp;&nbsp;→ Register controller ✅<br>";
                }
            }
        }
        echo "</div>";
    } else {
        echo "❌ Auth controllers directory not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error checking auth controllers: " . $e->getMessage() . "<br>";
}

// Test database connection
echo "<h3>Test 5: Database Connection</h3>";
try {
    // Test if we can connect to database
    $pdo = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    echo "✅ Database connection works<br>";
    
    // Check for important tables
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Users table exists<br>";
    } else {
        echo "❌ Users table missing - run migrations<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Next Steps</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";
echo "<strong>Based on the analysis:</strong><br><br>";
echo "1. If routes are found but still return 404, clear all caches<br>";
echo "2. Check if controllers are properly namespaced<br>";
echo "3. Verify middleware isn't blocking routes<br>";
echo "4. Test direct controller access<br>";
echo "<br>";
echo "<strong>Manual Tests:</strong><br>";
echo "• Try: <a href='/nephroapp/public/login'>/nephroapp/public/login</a><br>";
echo "• Try: <a href='/nephroapp/public/register'>/nephroapp/public/register</a><br>";
echo "</div>";
?>
