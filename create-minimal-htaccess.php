<?php
// Create minimal .htaccess file
echo "<h2>🔧 Creating Minimal .htaccess File</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ Minimal .htaccess</strong><br>";
echo "This creates the simplest possible .htaccess file for Laravel<br>";
echo "</div>";

// Minimal .htaccess content
$htaccess_content = 'RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L]
';

// Create the .htaccess file
if (file_put_contents('.htaccess', $htaccess_content)) {
    echo "✅ <strong>SUCCESS!</strong> Minimal .htaccess file created<br>";
    
    echo "<br>";
    echo "<strong>Created .htaccess content:</strong><br>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($htaccess_content);
    echo "</pre>";
    
    echo "<br>";
    echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>🎯 Test Your Site Now</h3>";
    echo "<p><strong>Minimal .htaccess file created!</strong></p>";
    echo "<p>Try visiting your main site:</p>";
    echo "<ul>";
    echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
    echo "<li><a href='debug-current-500.php'>🔍 Debug Again</a></li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>📝 What This Minimal .htaccess Does:</h4>";
    echo "<ul>";
    echo "<li>Enables URL rewriting</li>";
    echo "<li>Redirects requests to index.php</li>";
    echo "<li>Only 4 lines - minimal complexity</li>";
    echo "<li>Should work with most hosting providers</li>";
    echo "</ul>";
    echo "</div>";
    
} else {
    echo "❌ Could not create .htaccess file<br>";
}

echo "<hr>";
echo "<h3>🔧 If You Still Get 500 Error</h3>";
echo "<p>If even this minimal .htaccess causes 500 error:</p>";
echo "<ul>";
echo "<li><a href='disable-htaccess.php'>Disable .htaccess completely</a></li>";
echo "<li>Run your Laravel app without URL rewriting</li>";
echo "</ul>";
?>

