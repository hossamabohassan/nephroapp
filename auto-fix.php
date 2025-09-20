<?php
echo "<h1>🔧 Laravel Auto-Fix Tool</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.success { color: green; }
.error { color: red; }
.warning { color: orange; }
.section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
pre { background: #f5f5f5; padding: 10px; overflow-x: auto; }
</style>";

echo "<div class='section'>";
echo "<h2>🚀 Running Auto-Fixes</h2>";

// Fix 1: Ensure proper .htaccess in public directory
echo "<h3>Fix 1: Public .htaccess</h3>";
$htaccessContent = '<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>';

if (!is_dir('public')) {
    mkdir('public', 0755, true);
    echo "<span class='success'>✅ Created public directory</span><br>";
}

file_put_contents('public/.htaccess', $htaccessContent);
echo "<span class='success'>✅ Created/Updated public/.htaccess</span><br>";

// Fix 2: Remove root .htaccess that might conflict
if (file_exists('.htaccess')) {
    rename('.htaccess', '.htaccess.backup');
    echo "<span class='success'>✅ Moved root .htaccess to .htaccess.backup</span><br>";
}

// Fix 3: Ensure proper index.php in public directory
echo "<h3>Fix 2: Public index.php</h3>";
$indexContent = '<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define(\'LARAVEL_START\', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.\'/../storage/framework/maintenance.php\')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We\'ll simply require it
| into the script here so we don\'t need to manually load our classes.
|
*/

require __DIR__.\'/../vendor/autoload.php\';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application\'s HTTP kernel. Then, we will send the response back
| to this client\'s browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.\'/../bootstrap/app.php\';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
';

file_put_contents('public/index.php', $indexContent);
echo "<span class='success'>✅ Created/Updated public/index.php</span><br>";

// Fix 3: Clear all caches
echo "<h3>Fix 3: Clear Caches</h3>";
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/packages.php'
];

foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "<span class='success'>✅ Deleted $file</span><br>";
    }
}

// Fix 4: Set proper permissions
echo "<h3>Fix 4: Set Permissions</h3>";
$dirs = ['storage', 'bootstrap/cache'];
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        chmod($dir, 0755);
        echo "<span class='success'>✅ Set permissions for $dir</span><br>";
    }
}

// Fix 5: Create missing directories
echo "<h3>Fix 5: Create Missing Directories</h3>";
$requiredDirs = [
    'storage/logs',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'bootstrap/cache'
];

foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "<span class='success'>✅ Created $dir</span><br>";
    }
}

echo "</div>";

echo "<div class='section'>";
echo "<h2>🧪 Testing After Fixes</h2>";
try {
    require_once 'vendor/autoload.php';
    echo "<span class='success'>✅ Autoloader works</span><br>";
    
    $app = require_once 'bootstrap/app.php';
    echo "<span class='success'>✅ Bootstrap works</span><br>";
    
    echo "<span class='success'>✅ All fixes applied successfully!</span><br>";
    
} catch (Exception $e) {
    echo "<span class='error'>❌ Still has issues: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

echo "<h3>🎯 Next Steps</h3>";
echo "<ol>";
echo "<li>Test your main site: <a href='/public/' target='_blank'>http://nephroapp.com/nephroapp/public/</a></li>";
echo "<li>Test other pages: <a href='/public/topics' target='_blank'>Topics</a></li>";
echo "<li>If still having issues, run the debug script</li>";
echo "</ol>";
?>

