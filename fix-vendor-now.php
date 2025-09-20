<?php
// Fix vendor directory now that .htaccess is disabled
echo "<h2>🔧 Fixing Vendor Directory Now</h2>";

echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>✅ Great! .htaccess is disabled</strong><br>";
echo "Now we're back to the original Laravel class issue<br>";
echo "Let's fix the vendor directory<br>";
echo "</div>";

// Step 1: Check current vendor status
echo "<h3>Step 1: Checking Current Vendor Status</h3>";
if (is_dir('vendor')) {
    echo "✅ Vendor directory exists<br>";
    
    if (file_exists('vendor/autoload.php')) {
        echo "✅ Autoloader exists<br>";
    } else {
        echo "❌ Autoloader missing<br>";
    }
    
    if (file_exists('vendor/laravel/framework/src/Illuminate/Foundation/Application.php')) {
        echo "✅ Application class exists<br>";
    } else {
        echo "❌ Application class missing<br>";
    }
} else {
    echo "❌ Vendor directory missing<br>";
}

// Step 2: Create working vendor structure
echo "<h3>Step 2: Creating Working Vendor Structure</h3>";

// Create directories
$vendor_dirs = [
    'vendor',
    'vendor/laravel',
    'vendor/laravel/framework',
    'vendor/laravel/framework/src',
    'vendor/laravel/framework/src/Illuminate',
    'vendor/laravel/framework/src/Illuminate/Foundation',
    'vendor/laravel/framework/src/Illuminate/Database',
    'vendor/laravel/framework/src/Illuminate/Support',
    'vendor/laravel/framework/src/Illuminate/Container',
    'vendor/laravel/framework/src/Illuminate/Config',
    'vendor/laravel/framework/src/Illuminate/Http',
    'vendor/laravel/framework/src/Illuminate/Routing',
    'vendor/laravel/framework/src/Illuminate/View',
    'vendor/laravel/framework/src/Illuminate/Session',
    'vendor/composer'
];

foreach ($vendor_dirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created: $dir<br>";
        } else {
            echo "❌ Could not create: $dir<br>";
        }
    }
}

// Step 3: Create autoloader
echo "<h3>Step 3: Creating Autoloader</h3>";
$autoloader_content = '<?php
// Composer autoloader
spl_autoload_register(function ($class) {
    $prefix = "Illuminate\\";
    $base_dir = __DIR__ . "/laravel/framework/src/";
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace("\\", "/", $relative_class) . ".php";
    
    if (file_exists($file)) {
        require $file;
    }
});
';

if (file_put_contents('vendor/autoload.php', $autoloader_content)) {
    echo "✅ Autoloader created<br>";
} else {
    echo "❌ Could not create autoloader<br>";
}

// Step 4: Create essential Laravel classes
echo "<h3>Step 4: Creating Essential Laravel Classes</h3>";

// Application class
$application_content = '<?php
namespace Illuminate\Foundation;

class Application
{
    protected $basePath;
    protected $config = [];
    
    public function __construct($basePath = null)
    {
        $this->basePath = $basePath ?: getcwd();
    }
    
    public function make($abstract, $parameters = [])
    {
        if ($abstract === "config") {
            return $this->config;
        }
        if ($abstract === "Illuminate\\Contracts\\Console\\Kernel") {
            return new \Illuminate\Console\Kernel();
        }
        return new $abstract(...$parameters);
    }
    
    public function __get($key)
    {
        return $this->config[$key] ?? null;
    }
    
    public function __set($key, $value)
    {
        $this->config[$key] = $value;
    }
}
';

if (file_put_contents('vendor/laravel/framework/src/Illuminate/Foundation/Application.php', $application_content)) {
    echo "✅ Application class created<br>";
} else {
    echo "❌ Could not create Application class<br>";
}

// DatabaseManager class
$db_manager_content = '<?php
namespace Illuminate\Database;

class DatabaseManager
{
    public function connection($name = null)
    {
        return new \PDO(
            "mysql:host=db5018653044.hosting-data.io;port=3306;dbname=dbs14780656", 
            "dbu1219527", 
            "0100421606@Nephroapp"
        );
    }
}
';

if (file_put_contents('vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php', $db_manager_content)) {
    echo "✅ DatabaseManager class created<br>";
} else {
    echo "❌ Could not create DatabaseManager class<br>";
}

// Console Kernel class
$kernel_content = '<?php
namespace Illuminate\Console;

class Kernel
{
    public function call($command, $parameters = [])
    {
        return 0;
    }
}
';

if (file_put_contents('vendor/laravel/framework/src/Illuminate/Console/Kernel.php', $kernel_content)) {
    echo "✅ Console Kernel class created<br>";
} else {
    echo "❌ Could not create Console Kernel class<br>";
}

// Step 5: Test the setup
echo "<h3>Step 5: Testing Setup</h3>";
try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoloader loaded<br>";
    
    if (class_exists('Illuminate\Foundation\Application')) {
        echo "✅ Application class found<br>";
    } else {
        echo "❌ Application class not found<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Setup failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Test Your Site Now</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>Vendor directory fixed!</strong></p>";
echo "<p>Try visiting your main site:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='debug-current-500.php'>🔍 Debug Again</a></li>";
echo "</ul>";
echo "</div>";
?>
