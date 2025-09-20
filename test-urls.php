<?php
// URL Test Diagnostic
echo "<h2>🔍 URL Test Diagnostic</h2>";

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📍 Current URL:</strong> " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "<br>";
echo "<strong>📁 Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>📄 Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "</div>";

// Check what files exist
echo "<h3>File Structure Check</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$importantFiles = [
    'index.php',
    'nephroapp/public/index.php',
    'nephroapp/bootstrap/app.php',
    'nephroapp/routes/web.php',
    'nephroapp/routes/auth.php'
];

foreach ($importantFiles as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file NOT found<br>";
    }
}

echo "</div>";

// Check current directory contents
echo "<h3>Current Directory Contents</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$files = scandir('.');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        if (is_dir($file)) {
            echo "📁 $file/<br>";
        } else {
            echo "📄 $file<br>";
        }
    }
}

echo "</div>";

// Test URLs
echo "<h3>🧪 Test These URLs</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";

$testUrls = [
    '/' => 'Root URL (should redirect)',
    '/nephroapp/public/' => 'Direct Laravel path',
    '/nephroapp/public/login' => 'Login page',
    '/index.php' => 'Root index file',
    '/test-urls.php' => 'This diagnostic page'
];

echo "<strong>Click these links to test:</strong><br><br>";

foreach ($testUrls as $url => $description) {
    echo "<div style='margin: 5px 0; padding: 8px; background: white; border-left: 3px solid #007cba;'>";
    echo "<strong><a href='$url' target='_blank' style='color: #2563eb; text-decoration: none;'>$url</a></strong>";
    echo "<br><small style='color: #666;'>$description</small>";
    echo "</div>";
}

echo "</div>";

// Check .htaccess status
echo "<h3>URL Routing Check</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

if (file_exists('.htaccess')) {
    echo "✅ .htaccess file exists<br>";
    $htaccessContent = file_get_contents('.htaccess');
    echo "<strong>Content preview:</strong><br>";
    echo "<pre style='background: white; padding: 10px; max-height: 200px; overflow-y: auto;'>";
    echo htmlspecialchars($htaccessContent);
    echo "</pre>";
} else {
    echo "❌ No .htaccess file found<br>";
    echo "<strong>This might be why URLs aren't working!</strong><br>";
}

if (file_exists('index.php')) {
    echo "✅ index.php exists<br>";
    $indexContent = file_get_contents('index.php');
    echo "<strong>Index.php preview:</strong><br>";
    echo "<pre style='background: white; padding: 10px; max-height: 200px; overflow-y: auto;'>";
    echo htmlspecialchars(substr($indexContent, 0, 500));
    echo "</pre>";
} else {
    echo "❌ No index.php in root<br>";
}

echo "</div>";

echo "<hr>";
echo "<h3>🎯 Next Steps</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px;'>";
echo "<strong>Based on what you find:</strong><br><br>";
echo "1. If /nephroapp/public/ works → URL routing issue<br>";
echo "2. If no URLs work → File structure problem<br>";
echo "3. If .htaccess missing → Need to recreate routing<br>";
echo "4. If index.php missing → Need to create redirect<br>";
echo "</div>";
?>
