<?php
// Create IONOS-compatible .htaccess file
echo "<h2>🔧 Creating IONOS-Compatible .htaccess File</h2>";

echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>✅ Confirmed: .htaccess is causing the 500 error!</strong><br>";
echo "Let's create a simple .htaccess file that works with IONOS hosting<br>";
echo "</div>";

// IONOS-compatible .htaccess content
$htaccess_content = 'RewriteEngine On

# Handle Authorization Header
RewriteCond %{HTTP:Authorization} .
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

# Redirect Trailing Slashes If Not A Folder...
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI} (.+)/$
RewriteRule ^ %1 [L,R=301]

# Send Requests To Front Controller...
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
';

// Create the .htaccess file
if (file_put_contents('.htaccess', $htaccess_content)) {
    echo "✅ <strong>SUCCESS!</strong> IONOS-compatible .htaccess file created<br>";
    
    echo "<br>";
    echo "<strong>Created .htaccess content:</strong><br>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($htaccess_content);
    echo "</pre>";
    
    echo "<br>";
    echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>🎯 Test Your Site Now</h3>";
    echo "<p><strong>IONOS-compatible .htaccess file created!</strong></p>";
    echo "<p>Try visiting your main site:</p>";
    echo "<ul>";
    echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
    echo "<li><a href='debug-current-500.php'>🔍 Debug Again</a></li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>📝 What This .htaccess Does:</h4>";
    echo "<ul>";
    echo "<li>Enables URL rewriting for Laravel</li>";
    echo "<li>Redirects all requests to index.php</li>";
    echo "<li>Handles authorization headers</li>";
    echo "<li>Removes trailing slashes</li>";
    echo "<li>Compatible with IONOS hosting</li>";
    echo "</ul>";
    echo "</div>";
    
} else {
    echo "❌ Could not create .htaccess file<br>";
    echo "You may not have permission to create files<br>";
}

echo "<hr>";
echo "<h3>🔧 If You Still Get 500 Error</h3>";
echo "<p>If you still get 500 error with this simple .htaccess, try:</p>";
echo "<ul>";
echo "<li><a href='disable-htaccess.php'>Disable .htaccess completely</a></li>";
echo "<li><a href='create-minimal-htaccess.php'>Create even simpler .htaccess</a></li>";
echo "</ul>";

echo "<h3>🔧 Alternative: No .htaccess</h3>";
echo "<p>If .htaccess keeps causing problems, you can run your Laravel app without it:</p>";
echo "<ul>";
echo "<li>Access pages directly: <code>index.php</code></li>";
echo "<li>Use query parameters: <code>index.php?page=topics</code></li>";
echo "</ul>";
?>

