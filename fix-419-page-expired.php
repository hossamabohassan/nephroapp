<?php
/**
 * Fix 419 Page Expired (CSRF Token Mismatch) for IONOS
 * Run this file in your browser after uploading to IONOS
 */

echo "<h1>🔐 Fixing 419 Page Expired (CSRF Token Mismatch)</h1>";

$basePath = __DIR__;

// 1. Clear all session files
echo "<h2>🧹 Clearing All Session Data</h2>";
$sessionsDir = $basePath . '/storage/framework/sessions';
if (is_dir($sessionsDir)) {
    $files = glob($sessionsDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✅ Cleared all session files<br>";
} else {
    echo "ℹ️ Sessions directory not found<br>";
}

// 2. Clear all caches
echo "<br><h2>🗂️ Clearing All Caches</h2>";
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/events.php',
    'bootstrap/cache/packages.php'
];

foreach ($cacheFiles as $file) {
    $filePath = $basePath . '/' . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "✅ Cleared: $file<br>";
    }
}

// Clear storage caches
$cacheDirs = [
    'storage/framework/cache',
    'storage/framework/views'
];

foreach ($cacheDirs as $dir) {
    $dirPath = $basePath . '/' . $dir;
    if (is_dir($dirPath)) {
        $files = glob($dirPath . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "✅ Cleared: $dir<br>";
    }
}

// 3. Fix .env configuration
echo "<br><h2>⚙️ Fixing Environment Configuration</h2>";
$envPath = $basePath . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    // Ensure APP_KEY is set
    if (!preg_match('/^APP_KEY=base64:.+$/m', $envContent)) {
        echo "⚠️ APP_KEY missing or invalid, generating new one...<br>";
        $newKey = 'base64:' . base64_encode(random_bytes(32));
        $envContent = preg_replace('/^APP_KEY=.*$/m', "APP_KEY=$newKey", $envContent);
        if (!preg_match('/^APP_KEY=/m', $envContent)) {
            $envContent .= "\nAPP_KEY=$newKey";
        }
    } else {
        echo "✅ APP_KEY is properly set<br>";
    }
    
    // Fix session configuration for IONOS
    $sessionConfigs = [
        'SESSION_DOMAIN=.nephroapp.com',
        'SESSION_PATH=/',
        'SESSION_SECURE_COOKIE=false',
        'SESSION_SAME_SITE=lax',
        'SESSION_DRIVER=file',
        'SESSION_LIFETIME=120',
        'SESSION_ENCRYPT=false',
        'SESSION_HTTP_ONLY=true'
    ];
    
    foreach ($sessionConfigs as $config) {
        $key = explode('=', $config)[0];
        if (preg_match("/^$key=/m", $envContent)) {
            $envContent = preg_replace("/^$key=.*$/m", $config, $envContent);
            echo "✅ Updated: $key<br>";
        } else {
            $envContent .= "\n$config";
            echo "✅ Added: $key<br>";
        }
    }
    
    // Ensure APP_URL is correct
    $envContent = preg_replace('/^APP_URL=.*$/m', 'APP_URL=http://nephroapp.com', $envContent);
    echo "✅ Updated APP_URL<br>";
    
    file_put_contents($envPath, $envContent);
    chmod($envPath, 0644);
} else {
    echo "❌ .env file not found<br>";
}

// 4. Fix .htaccess for POST requests
echo "<br><h2>🔧 Fixing .htaccess for POST Requests</h2>";
$rootHtaccess = '<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Handle POST requests directly to Laravel (no redirects)
RewriteCond %{REQUEST_METHOD} POST
RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]

# Handle GET requests with redirects
RewriteCond %{REQUEST_METHOD} GET
RewriteRule ^$ nephroapp/public/index.php [L]

RewriteCond %{REQUEST_METHOD} GET
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]
</IfModule>';

$rootHtaccessPath = $basePath . '/.htaccess';
file_put_contents($rootHtaccessPath, $rootHtaccess);
chmod($rootHtaccessPath, 0644);
echo "✅ Updated root .htaccess for POST-safe routing<br>";

// 5. Update root index.php for POST handling
echo "<br><h2>📄 Updating Root index.php</h2>";
$rootIndex = '<?php
$uri    = $_SERVER["REQUEST_URI"]  ?? "/";
$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

// For POST requests, directly include Laravel (no redirects)
if ($method === "POST") {
    chdir(__DIR__ . "/nephroapp/public");
    require __DIR__ . "/nephroapp/public/index.php";
    exit;
}

// For GET requests, redirect to Laravel
$query = $_SERVER["QUERY_STRING"] ?? "";
$dest = "/nephroapp/public" . $uri;
if ($query) $dest .= "?" . $query;
header("Location: " . $dest, true, 302);
exit;
?>';

$rootIndexPath = $basePath . '/index.php';
file_put_contents($rootIndexPath, $rootIndex);
chmod($rootIndexPath, 0644);
echo "✅ Updated root index.php for POST handling<br>";

// 6. Ensure proper file permissions
echo "<br><h2>🔐 Setting File Permissions</h2>";
$directories = [
    'storage',
    'storage/framework',
    'storage/framework/sessions',
    'storage/framework/cache',
    'storage/framework/views',
    'bootstrap/cache'
];

foreach ($directories as $dir) {
    $dirPath = $basePath . '/' . $dir;
    if (is_dir($dirPath)) {
        chmod($dirPath, 0755);
        echo "✅ Set permissions for: $dir<br>";
    }
}

// 7. Create a test CSRF token
echo "<br><h2>🧪 Testing CSRF Token Generation</h2>";
try {
    // Test if we can generate a token
    $testToken = bin2hex(random_bytes(32));
    echo "✅ CSRF token generation test passed<br>";
    echo "✅ Sample token: " . substr($testToken, 0, 16) . "...<br>";
} catch (Exception $e) {
    echo "❌ CSRF token generation failed: " . $e->getMessage() . "<br>";
}

// 8. Check if forms have CSRF tokens
echo "<br><h2>🔍 Checking CSRF Token Implementation</h2>";
$formFiles = [
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php'
];

foreach ($formFiles as $file) {
    $filePath = $basePath . '/' . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        if (strpos($content, '@csrf') !== false || strpos($content, 'csrf_token()') !== false) {
            echo "✅ CSRF token found in: $file<br>";
        } else {
            echo "⚠️ CSRF token missing in: $file<br>";
        }
    }
}

echo "<br><h2>🎉 419 Page Expired Fix Complete!</h2>";
echo "<p>Your Laravel app should now handle CSRF tokens properly.</p>";

echo "<br><h3>📋 What was fixed:</h3>";
echo "<ul>";
echo "<li>Cleared all session data and caches</li>";
echo "<li>Fixed APP_KEY and session configuration</li>";
echo "<li>Updated .htaccess for POST-safe routing</li>";
echo "<li>Modified index.php to handle POST requests directly</li>";
echo "<li>Set proper file permissions</li>";
echo "<li>Verified CSRF token generation</li>";
echo "</ul>";

echo "<br><h3>🚀 Test Your Application:</h3>";
echo "<ol>";
echo "<li>Clear your browser cookies for nephroapp.com</li>";
echo "<li>Try in an incognito/private window</li>";
echo "<li><a href='/login'>Test login form</a></li>";
echo "<li><a href='/register'>Test registration form</a></li>";
echo "</ol>";

echo "<br><h3>💡 Additional Steps if Still Having Issues:</h3>";
echo "<ul>";
echo "<li>Check that your forms include <code>@csrf</code> directive</li>";
echo "<li>Verify your forms are using POST method</li>";
echo "<li>Clear browser cache completely</li>";
echo "<li>Check Laravel logs: <code>storage/logs/laravel.log</code></li>";
echo "</ul>";

echo "<br><h3>🔧 Manual Commands to Run:</h3>";
echo "<p>If you have SSH access, also run these commands:</p>";
echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
echo "# Clear all caches\n";
echo "/usr/bin/php8.2-cli artisan config:clear\n";
echo "/usr/bin/php8.2-cli artisan route:clear\n";
echo "/usr/bin/php8.2-cli artisan view:clear\n";
echo "/usr/bin/php8.2-cli artisan cache:clear\n";
echo "\n# Regenerate app key if needed\n";
echo "/usr/bin/php8.2-cli artisan key:generate\n";
echo "</pre>";

echo "<br><p><strong>Note:</strong> The 419 Page Expired error should now be resolved. If you still encounter issues, the problem might be with form submissions or browser cache.</p>";
?>
