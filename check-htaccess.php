<?php
// Check and fix .htaccess file
echo "<h2>🔍 Checking .htaccess File</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ .htaccess File Check</strong><br>";
echo "The .htaccess file can cause 500 errors if it's misconfigured<br>";
echo "</div>";

// Check if .htaccess exists
echo "<h3>🔍 Checking .htaccess File</h3>";
if (file_exists('.htaccess')) {
    echo "✅ .htaccess file exists<br>";
    
    $htaccess_content = file_get_contents('.htaccess');
    echo "<strong>Current .htaccess content:</strong><br>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>";
    echo htmlspecialchars($htaccess_content);
    echo "</pre>";
    
    // Check for common issues
    echo "<h3>🔍 Checking for Common Issues</h3>";
    
    if (strpos($htaccess_content, 'RewriteEngine On') !== false) {
        echo "✅ RewriteEngine is enabled<br>";
    } else {
        echo "❌ RewriteEngine not found<br>";
    }
    
    if (strpos($htaccess_content, 'RewriteRule') !== false) {
        echo "✅ RewriteRule found<br>";
    } else {
        echo "❌ RewriteRule not found<br>";
    }
    
    if (strpos($htaccess_content, 'DirectoryIndex') !== false) {
        echo "✅ DirectoryIndex found<br>";
    } else {
        echo "❌ DirectoryIndex not found<br>";
    }
    
} else {
    echo "❌ .htaccess file not found<br>";
}

echo "<hr>";
echo "<h3>🎯 Quick Fixes</h3>";
echo "<ul>";
echo "<li><a href='fix-htaccess.php'>Fix .htaccess File</a></li>";
echo "<li><a href='disable-htaccess.php'>Disable .htaccess Temporarily</a></li>";
echo "<li><a href='create-simple-htaccess.php'>Create Simple .htaccess</a></li>";
echo "</ul>";
?>

