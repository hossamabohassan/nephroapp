<?php
/**
 * Re-enable CSRF Protection After Testing
 * Run this file to restore CSRF protection after testing
 */

echo "<h1>🔒 Re-enabling CSRF Protection</h1>";

$basePath = __DIR__;

// 1. Restore the backup
echo "<h2>🔄 Restoring CSRF Protection</h2>";
$middlewarePath = $basePath . '/app/Http/Middleware/VerifyCsrfToken.php';
$backupPath = $basePath . '/app/Http/Middleware/VerifyCsrfToken.php.backup';

if (file_exists($backupPath)) {
    copy($backupPath, $middlewarePath);
    chmod($middlewarePath, 0644);
    echo "✅ CSRF protection restored from backup<br>";
    
    // Remove the backup file
    unlink($backupPath);
    echo "✅ Backup file removed<br>";
} else {
    echo "❌ Backup file not found. Creating default CSRF middleware...<br>";
    
    // Create a default CSRF middleware
    $defaultContent = '<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}';
    
    file_put_contents($middlewarePath, $defaultContent);
    chmod($middlewarePath, 0644);
    echo "✅ Default CSRF middleware created<br>";
}

// 2. Clear caches
echo "<br><h2>🧹 Clearing Caches</h2>";
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

echo "<br><h2>🎉 CSRF Protection Re-enabled!</h2>";
echo "<p><strong>CSRF protection is now active again.</strong></p>";

echo "<br><h3>🔒 Security Restored:</h3>";
echo "<ul>";
echo "<li>CSRF tokens are now required for form submissions</li>";
echo "<li>Forms must include @csrf directive</li>";
echo "<li>POST requests without valid CSRF tokens will be rejected</li>";
echo "</ul>";

echo "<br><h3>🧪 Test Your Application:</h3>";
echo "<ol>";
echo "<li><a href='/login'>Test login form</a></li>";
echo "<li><a href='/register'>Test registration form</a></li>";
echo "<li>Verify that forms work with CSRF protection enabled</li>";
echo "</ol>";

echo "<br><h3>💡 If You Still Get 419 Errors:</h3>";
echo "<p>If you still get 419 Page Expired errors after re-enabling CSRF:</p>";
echo "<ol>";
echo "<li>Run <a href='fix-419-page-expired.php'>fix-419-page-expired.php</a> to fix CSRF issues</li>";
echo "<li>Check that your forms include @csrf directive</li>";
echo "<li>Verify session configuration in .env</li>";
echo "<li>Clear browser cookies and try again</li>";
echo "</ol>";

echo "<br><p><strong>Note:</strong> CSRF protection is now active. Your application is secure again!</p>";
?>
