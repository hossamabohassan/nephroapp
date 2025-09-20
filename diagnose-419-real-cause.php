<?php
/**
 * Diagnose Real Cause of 419 Page Expired (CSRF Disabled)
 * Since CSRF is disabled and you still get 419, let's find the real cause
 */

echo "<h1>🔍 Diagnosing Real Cause of 419 Page Expired</h1>";
echo "<p><strong>CSRF is disabled but you still get 419 - let's find the real cause!</strong></p>";

$basePath = __DIR__;

// 1. Check Laravel logs for errors
echo "<h2>📋 Checking Laravel Logs</h2>";
$logFile = $basePath . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    $lines = explode("\n", $logContent);
    $recentLines = array_slice($lines, -50); // Last 50 lines
    
    echo "<h3>Recent Log Entries:</h3>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>";
    foreach ($recentLines as $line) {
        if (!empty(trim($line))) {
            echo htmlspecialchars($line) . "\n";
        }
    }
    echo "</pre>";
} else {
    echo "❌ Laravel log file not found<br>";
}

// 2. Check if forms are actually submitting
echo "<br><h2>🧪 Testing Form Submission</h2>";
echo "<h3>Test Form (POST to /login):</h3>";
echo "<form method='POST' action='/login' style='background: #f9f9f9; padding: 15px; border-radius: 5px;'>";
echo "<input type='hidden' name='_token' value='test-token'>";
echo "<input type='email' name='email' placeholder='Email' value='test@example.com' style='width: 100%; padding: 8px; margin: 5px 0;'>";
echo "<input type='password' name='password' placeholder='Password' value='password' style='width: 100%; padding: 8px; margin: 5px 0;'>";
echo "<button type='submit' style='background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Test Login Form</button>";
echo "</form>";

// 3. Check server configuration
echo "<br><h2>⚙️ Server Configuration Check</h2>";
echo "<h3>PHP Configuration:</h3>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion() . "</li>";
echo "<li>Session Save Path: " . session_save_path() . "</li>";
echo "<li>Session Name: " . session_name() . "</li>";
echo "<li>Max Execution Time: " . ini_get('max_execution_time') . "</li>";
echo "<li>Memory Limit: " . ini_get('memory_limit') . "</li>";
echo "<li>Upload Max Filesize: " . ini_get('upload_max_filesize') . "</li>";
echo "<li>Post Max Size: " . ini_get('post_max_size') . "</li>";
echo "</ul>";

// 4. Check file permissions
echo "<br><h2>🔐 File Permissions Check</h2>";
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
        $perms = substr(sprintf('%o', fileperms($dirPath)), -4);
        $writable = is_writable($dirPath) ? '✅' : '❌';
        echo "$writable $dir: $perms<br>";
    } else {
        echo "❌ $dir: Directory not found<br>";
    }
}

// 5. Check .env configuration
echo "<br><h2>📄 Environment Configuration</h2>";
$envPath = $basePath . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $envLines = explode("\n", $envContent);
    
    echo "<h3>Key Environment Variables:</h3>";
    echo "<ul>";
    foreach ($envLines as $line) {
        $line = trim($line);
        if (strpos($line, 'APP_') === 0 || 
            strpos($line, 'SESSION_') === 0 || 
            strpos($line, 'DB_') === 0) {
            echo "<li>" . htmlspecialchars($line) . "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "❌ .env file not found<br>";
}

// 6. Check if routes are working
echo "<br><h2>🛣️ Route Testing</h2>";
echo "<h3>Test these URLs:</h3>";
echo "<ul>";
echo "<li><a href='/'>Homepage</a></li>";
echo "<li><a href='/login'>Login Page</a></li>";
echo "<li><a href='/register'>Register Page</a></li>";
echo "<li><a href='/nephroapp/public/'>Direct Laravel</a></li>";
echo "</ul>";

// 7. Check if the issue is with form processing
echo "<br><h2>🔍 Form Processing Test</h2>";
echo "<h3>Simple Test Form (POST to current page):</h3>";
echo "<form method='POST' action='' style='background: #f9f9f9; padding: 15px; border-radius: 5px;'>";
echo "<input type='text' name='test_field' placeholder='Test Field' value='test value' style='width: 100%; padding: 8px; margin: 5px 0;'>";
echo "<button type='submit' name='test_submit' style='background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Test Form Submission</button>";
echo "</form>";

// Handle the test form submission
if ($_POST && isset($_POST['test_submit'])) {
    echo "<br><h3>✅ Form Submission Test Results:</h3>";
    echo "<ul>";
    echo "<li>POST data received: " . (count($_POST) > 0 ? 'Yes' : 'No') . "</li>";
    echo "<li>Test field value: " . htmlspecialchars($_POST['test_field'] ?? 'Not set') . "</li>";
    echo "<li>Request method: " . $_SERVER['REQUEST_METHOD'] . "</li>";
    echo "<li>Request URI: " . $_SERVER['REQUEST_URI'] . "</li>";
    echo "<li>Content type: " . ($_SERVER['CONTENT_TYPE'] ?? 'Not set') . "</li>";
    echo "</ul>";
    
    if (count($_POST) > 0) {
        echo "<p style='color: green;'><strong>✅ Form submission is working! The issue is not with form processing.</strong></p>";
    } else {
        echo "<p style='color: red;'><strong>❌ Form submission is not working! This might be the issue.</strong></p>";
    }
}

// 8. Check for common 419 causes
echo "<br><h2>🎯 Common 419 Causes Check</h2>";
echo "<h3>Possible Causes (since CSRF is disabled):</h3>";
echo "<ol>";
echo "<li><strong>Session Issues:</strong> Check if sessions are working properly</li>";
echo "<li><strong>Form Method:</strong> Ensure forms use POST method</li>";
echo "<li><strong>Route Issues:</strong> Check if routes are properly defined</li>";
echo "<li><strong>Middleware Issues:</strong> Other middleware might be causing issues</li>";
echo "<li><strong>Server Configuration:</strong> PHP or Apache configuration issues</li>";
echo "<li><strong>File Permissions:</strong> Laravel can't write to storage directories</li>";
echo "<li><strong>Database Issues:</strong> Database connection problems</li>";
echo "<li><strong>Cache Issues:</strong> Corrupted cache files</li>";
echo "</ol>";

// 9. Provide next steps
echo "<br><h2>🚀 Next Steps</h2>";
echo "<p>Since CSRF is disabled and you still get 419, try these solutions:</p>";
echo "<ol>";
echo "<li><strong>Check Laravel logs</strong> above for specific error messages</li>";
echo "<li><strong>Test the form above</strong> to see if form submission works</li>";
echo "<li><strong>Clear all caches</strong> completely</li>";
echo "<li><strong>Check file permissions</strong> on storage directories</li>";
echo "<li><strong>Verify database connection</strong> is working</li>";
echo "<li><strong>Check if routes are properly defined</strong></li>";
echo "</ol>";

echo "<br><h3>🔧 Quick Fixes to Try:</h3>";
echo "<ul>";
echo "<li><a href='clear-caches.php'>Clear All Caches</a></li>";
echo "<li><a href='fix-env-config.php'>Fix Environment Configuration</a></li>";
echo "<li><a href='fix-ionos-htaccess.php'>Fix .htaccess Configuration</a></li>";
echo "</ul>";

echo "<br><p><strong>Note:</strong> Since CSRF is disabled and you still get 419, the issue is definitely something else. The logs above should show the real error.</p>";
?>
