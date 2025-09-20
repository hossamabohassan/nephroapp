<?php
/**
 * Temporarily Disable CSRF Protection for Testing
 * Run this file in your browser to disable CSRF and test if it's the cause
 * WARNING: This is for testing only - re-enable CSRF after testing!
 */

echo "<h1>🔓 Temporarily Disabling CSRF Protection</h1>";
echo "<p><strong>⚠️ WARNING:</strong> This disables CSRF protection for testing only!</p>";

$basePath = __DIR__;

// 1. Create a backup of the current VerifyCsrfToken middleware
echo "<h2>💾 Creating Backup</h2>";
$middlewarePath = $basePath . '/app/Http/Middleware/VerifyCsrfToken.php';
$backupPath = $basePath . '/app/Http/Middleware/VerifyCsrfToken.php.backup';

if (file_exists($middlewarePath)) {
    copy($middlewarePath, $backupPath);
    echo "✅ Backup created: VerifyCsrfToken.php.backup<br>";
} else {
    echo "❌ VerifyCsrfToken.php not found<br>";
    exit;
}

// 2. Read the current middleware
$currentContent = file_get_contents($middlewarePath);

// 3. Create a modified version that disables CSRF
$modifiedContent = '<?php

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
        // Temporarily disable CSRF for all routes (TESTING ONLY)
        "*"
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // Temporarily disable CSRF protection (TESTING ONLY)
        return $next($request);
    }
}';

// 4. Write the modified middleware
file_put_contents($middlewarePath, $modifiedContent);
chmod($middlewarePath, 0644);
echo "✅ CSRF protection disabled<br>";

// 5. Clear caches
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

echo "<br><h2>🎉 CSRF Protection Disabled!</h2>";
echo "<p><strong>CSRF protection is now temporarily disabled for testing.</strong></p>";

echo "<br><h3>🧪 Test Your Application:</h3>";
echo "<ol>";
echo "<li><a href='/login'>Test login form</a></li>";
echo "<li><a href='/register'>Test registration form</a></li>";
echo "<li>Try submitting forms without CSRF tokens</li>";
echo "</ol>";

echo "<br><h3>📋 What to Check:</h3>";
echo "<ul>";
echo "<li>Do forms submit successfully now?</li>";
echo "<li>Do you still get 419 Page Expired errors?</li>";
echo "<li>Are there any other errors in the browser console?</li>";
echo "</ul>";

echo "<br><h3>⚠️ IMPORTANT - Re-enable CSRF After Testing:</h3>";
echo "<p>After testing, you MUST re-enable CSRF protection for security:</p>";
echo "<ol>";
echo "<li>Run <a href='enable-csrf-test.php'>enable-csrf-test.php</a> to restore CSRF protection</li>";
echo "<li>Or manually restore the backup file</li>";
echo "</ol>";

echo "<br><h3>🔍 If CSRF Was the Problem:</h3>";
echo "<p>If disabling CSRF fixes the issue, then the problem is with:</p>";
echo "<ul>";
echo "<li>Session configuration</li>";
echo "<li>CSRF token generation</li>";
echo "<li>Form CSRF token implementation</li>";
echo "<li>Cookie/session domain settings</li>";
echo "</ul>";

echo "<br><p><strong>Note:</strong> This is a temporary fix for testing only. CSRF protection is important for security!</p>";
?>
