<?php
/**
 * Fix Bootstrap Routes for Laravel 11 on IONOS
 * Run this file in your browser after uploading to IONOS
 */

echo "<h1>🔧 Fixing Bootstrap Routes for Laravel 11</h1>";

$bootstrapPath = __DIR__ . '/bootstrap/app.php';

// Check if bootstrap file exists
if (!file_exists($bootstrapPath)) {
    echo "❌ bootstrap/app.php not found!<br>";
    exit;
}

echo "✅ Found bootstrap/app.php<br>";

// Read current bootstrap content
$currentContent = file_get_contents($bootstrapPath);

// Check if Route facade is imported
if (strpos($currentContent, 'use Illuminate\Support\Facades\Route;') === false) {
    echo "⚠️ Route facade not imported, adding it...<br>";
    
    // Add Route facade import after other use statements
    $lines = explode("\n", $currentContent);
    $newLines = [];
    $useStatementsAdded = false;
    
    foreach ($lines as $line) {
        $newLines[] = $line;
        
        // Add Route facade after the last use statement
        if (strpos($line, 'use ') === 0 && !$useStatementsAdded) {
            $newLines[] = 'use Illuminate\Support\Facades\Route;';
            $useStatementsAdded = true;
        }
    }
    
    $currentContent = implode("\n", $newLines);
}

// Check if auth.php routes are loaded in withRouting
if (strpos($currentContent, "base_path('routes/auth.php')") === false) {
    echo "⚠️ Auth routes not loaded, adding them...<br>";
    
    // Find the withRouting section and add auth routes
    $pattern = '/->withRouting\(\s*web:\s*__DIR__\.\'\/\.\.\/routes\/web\.php\',\s*api:\s*__DIR__\.\'\/\.\.\/routes\/api\.php\',\s*commands:\s*__DIR__\.\'\/\.\.\/routes\/console\.php\',\s*health:\s*\'\/up\',\s*\)/';
    
    $replacement = '->withRouting(
        web: __DIR__.\'/../routes/web.php\',
        api: __DIR__.\'/../routes/api.php\',
        commands: __DIR__.\'/../routes/console.php\',
        health: \'/up\',
        then: function () {
            Route::middleware(\'web\')
                ->group(base_path(\'routes/auth.php\'));
        },
    )';
    
    $currentContent = preg_replace($pattern, $replacement, $currentContent);
    
    if ($currentContent === null) {
        echo "❌ Failed to update withRouting section<br>";
        exit;
    }
}

// Write the updated bootstrap file
file_put_contents($bootstrapPath, $currentContent);
chmod($bootstrapPath, 0644);

echo "✅ Updated bootstrap/app.php<br>";

// Verify the changes
$updatedContent = file_get_contents($bootstrapPath);
$hasRouteFacade = strpos($updatedContent, 'use Illuminate\Support\Facades\Route;') !== false;
$hasAuthRoutes = strpos($updatedContent, "base_path('routes/auth.php')") !== false;

echo "<br><h2>📋 Verification Results:</h2>";
echo $hasRouteFacade ? "✅ Route facade imported<br>" : "❌ Route facade missing<br>";
echo $hasAuthRoutes ? "✅ Auth routes configured<br>" : "❌ Auth routes missing<br>";

if ($hasRouteFacade && $hasAuthRoutes) {
    echo "<br><h2>🎉 Bootstrap Routes Fixed!</h2>";
    echo "<p>Your Laravel 11 app should now properly load authentication routes.</p>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ol>";
    echo "<li>Run <a href='clear-caches.php'>clear-caches.php</a> to clear Laravel caches</li>";
    echo "<li>Test your <a href='/login'>login page</a></li>";
    echo "<li>Test your <a href='/register'>register page</a></li>";
    echo "</ol>";
} else {
    echo "<br><h2>⚠️ Manual Fix Required</h2>";
    echo "<p>Please manually check bootstrap/app.php and ensure:</p>";
    echo "<ul>";
    echo "<li>Route facade is imported: <code>use Illuminate\\Support\\Facades\\Route;</code></li>";
    echo "<li>Auth routes are loaded in withRouting with a 'then' callback</li>";
    echo "</ul>";
}
?>
