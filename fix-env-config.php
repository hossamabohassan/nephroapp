<?php
/**
 * Fix Environment Configuration for IONOS
 * Run this file in your browser after uploading to IONOS
 */

echo "<h1>🔧 Fixing Environment Configuration for IONOS</h1>";

$envPath = __DIR__ . '/.env';

// Check if .env exists
if (!file_exists($envPath)) {
    echo "❌ .env file not found!<br>";
    exit;
}

echo "✅ Found .env file<br>";

// Read current .env content
$envContent = file_get_contents($envPath);

// Fix empty mail configuration (causes "Path cannot be empty" error)
$envContent = preg_replace('/^MAIL_USERNAME=$/m', 'MAIL_USERNAME=noreply@nephroapp.com', $envContent);
$envContent = preg_replace('/^MAIL_PASSWORD=$/m', 'MAIL_PASSWORD=dummy_password', $envContent);

// Ensure APP_URL is set correctly
$envContent = preg_replace('/^APP_URL=.*$/m', 'APP_URL=http://nephroapp.com', $envContent);

// Add session configuration for IONOS
$sessionConfigs = [
    'SESSION_DOMAIN=.nephroapp.com',
    'SESSION_PATH=/',
    'SESSION_SECURE_COOKIE=false',
    'SESSION_SAME_SITE=lax',
    'SESSION_DRIVER=file'
];

foreach ($sessionConfigs as $config) {
    $key = explode('=', $config)[0];
    if (preg_match("/^$key=/m", $envContent)) {
        $envContent = preg_replace("/^$key=.*$/m", $config, $envContent);
    } else {
        $envContent .= "\n$config";
    }
}

// Write updated .env
file_put_contents($envPath, $envContent);
chmod($envPath, 0644);

echo "✅ Updated .env configuration<br>";

// Verify changes
$updatedContent = file_get_contents($envPath);

echo "<br><h2>📋 Configuration Changes Applied:</h2>";

// Check mail configuration
$mailUsername = preg_match('/^MAIL_USERNAME=(.+)$/m', $updatedContent, $matches) ? $matches[1] : 'not set';
$mailPassword = preg_match('/^MAIL_PASSWORD=(.+)$/m', $updatedContent, $matches) ? $matches[1] : 'not set';
echo "✅ MAIL_USERNAME: $mailUsername<br>";
echo "✅ MAIL_PASSWORD: " . (empty($mailPassword) ? 'not set' : 'set') . "<br>";

// Check APP_URL
$appUrl = preg_match('/^APP_URL=(.+)$/m', $updatedContent, $matches) ? $matches[1] : 'not set';
echo "✅ APP_URL: $appUrl<br>";

// Check session configuration
$sessionDomain = preg_match('/^SESSION_DOMAIN=(.+)$/m', $updatedContent, $matches) ? $matches[1] : 'not set';
$sessionPath = preg_match('/^SESSION_PATH=(.+)$/m', $updatedContent, $matches) ? $matches[1] : 'not set';
$sessionSecure = preg_match('/^SESSION_SECURE_COOKIE=(.+)$/m', $updatedContent, $matches) ? $matches[1] : 'not set';
$sessionSameSite = preg_match('/^SESSION_SAME_SITE=(.+)$/m', $updatedContent, $matches) ? $matches[1] : 'not set';
$sessionDriver = preg_match('/^SESSION_DRIVER=(.+)$/m', $updatedContent, $matches) ? $matches[1] : 'not set';

echo "✅ SESSION_DOMAIN: $sessionDomain<br>";
echo "✅ SESSION_PATH: $sessionPath<br>";
echo "✅ SESSION_SECURE_COOKIE: $sessionSecure<br>";
echo "✅ SESSION_SAME_SITE: $sessionSameSite<br>";
echo "✅ SESSION_DRIVER: $sessionDriver<br>";

echo "<br><h2>🎉 Environment Configuration Fixed!</h2>";
echo "<p>Your Laravel app should now have proper environment configuration for IONOS.</p>";
echo "<p><strong>Next steps:</strong></p>";
echo "<ol>";
echo "<li>Run <a href='clear-caches.php'>clear-caches.php</a> to clear Laravel caches</li>";
echo "<li>Test your application</li>";
echo "</ol>";

echo "<br><h3>🔍 Current .env Summary:</h3>";
echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; font-size: 12px;'>";
$lines = explode("\n", $updatedContent);
foreach ($lines as $line) {
    if (strpos($line, 'APP_') === 0 || 
        strpos($line, 'DB_') === 0 || 
        strpos($line, 'MAIL_') === 0 || 
        strpos($line, 'SESSION_') === 0) {
        echo htmlspecialchars($line) . "\n";
    }
}
echo "</pre>";
?>
