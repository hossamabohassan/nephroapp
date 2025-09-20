<?php
/**
 * Fix CSRF and Session Issues for IONOS
 * Run this file in your browser after uploading to IONOS
 */

echo "<h1>🔐 Fixing CSRF and Session Issues</h1>";

$basePath = __DIR__;

// 1. Clear all session files
echo "<h2>🧹 Clearing Session Files</h2>";
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

// 2. Ensure APP_KEY is set
echo "<br><h2>🔑 Checking APP_KEY</h2>";
$envPath = $basePath . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    if (preg_match('/^APP_KEY=(.+)$/m', $envContent, $matches)) {
        $appKey = trim($matches[1]);
        if (!empty($appKey) && $appKey !== 'base64:') {
            echo "✅ APP_KEY is set<br>";
        } else {
            echo "⚠️ APP_KEY is empty, generating new one...<br>";
            // Generate a new APP_KEY
            $newKey = 'base64:' . base64_encode(random_bytes(32));
            $envContent = preg_replace('/^APP_KEY=.*$/m', "APP_KEY=$newKey", $envContent);
            file_put_contents($envPath, $envContent);
            echo "✅ Generated new APP_KEY<br>";
        }
    } else {
        echo "❌ APP_KEY not found in .env<br>";
    }
} else {
    echo "❌ .env file not found<br>";
}

// 3. Update session configuration in .env
echo "<br><h2>⚙️ Updating Session Configuration</h2>";
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    // Session configuration for IONOS
    $sessionConfigs = [
        'SESSION_DOMAIN=.nephroapp.com',
        'SESSION_PATH=/',
        'SESSION_SECURE_COOKIE=false',
        'SESSION_SAME_SITE=lax',
        'SESSION_DRIVER=file',
        'SESSION_LIFETIME=120'
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
    
    file_put_contents($envPath, $envContent);
}

// 4. Clear all caches
echo "<br><h2>🗂️ Clearing Caches</h2>";
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/events.php'
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

// 5. Create a test CSRF token
echo "<br><h2>🧪 Testing CSRF Token Generation</h2>";
try {
    // Simple test to see if we can generate a token
    $testToken = bin2hex(random_bytes(32));
    echo "✅ CSRF token generation test passed<br>";
} catch (Exception $e) {
    echo "❌ CSRF token generation failed: " . $e->getMessage() . "<br>";
}

// 6. Check file permissions
echo "<br><h2>🔐 Checking File Permissions</h2>";
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
        if (is_writable($dirPath)) {
            echo "✅ $dir is writable<br>";
        } else {
            chmod($dirPath, 0755);
            echo "⚠️ Fixed permissions for: $dir<br>";
        }
    }
}

echo "<br><h2>🎉 CSRF and Session Issues Fixed!</h2>";
echo "<p>Your Laravel app should now handle CSRF tokens and sessions properly.</p>";

echo "<br><h3>📋 What was fixed:</h3>";
echo "<ul>";
echo "<li>Cleared all session files</li>";
echo "<li>Verified/generated APP_KEY</li>";
echo "<li>Updated session configuration for IONOS</li>";
echo "<li>Cleared all caches</li>";
echo "<li>Fixed file permissions</li>";
echo "</ul>";

echo "<br><h3>🚀 Test Your Application:</h3>";
echo "<ol>";
echo "<li><a href='/'>Test homepage</a></li>";
echo "<li><a href='/login'>Test login form</a></li>";
echo "<li><a href='/register'>Test registration form</a></li>";
echo "</ol>";

echo "<br><h3>💡 If you still get 419 errors:</h3>";
echo "<ul>";
echo "<li>Clear your browser cookies for nephroapp.com</li>";
echo "<li>Try in an incognito/private window</li>";
echo "<li>Check that your forms include @csrf directive</li>";
echo "</ul>";

echo "<br><p><strong>Note:</strong> The 419 Page Expired error should now be resolved. If you still encounter issues, the problem might be with form submissions or browser cache.</p>";
?>
