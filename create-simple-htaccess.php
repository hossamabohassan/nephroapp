<?php
// Create a simple .htaccess file for Laravel
echo "<h2>🔧 Creating Simple .htaccess File</h2>";

echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>✅ Creating Simple .htaccess</strong><br>";
echo "This will create a basic .htaccess file that should work with IONOS hosting<br>";
echo "</div>";

// Simple .htaccess content for Laravel
$htaccess_content = '<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

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
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
</IfModule>

# Disable server signature
ServerSignature Off

# Hide .env file
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

# Hide composer files
<Files "composer.json">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.lock">
    Order allow,deny
    Deny from all
</Files>
';

// Create the .htaccess file
if (file_put_contents('.htaccess', $htaccess_content)) {
    echo "✅ <strong>SUCCESS!</strong> Simple .htaccess file created<br>";
    
    echo "<br>";
    echo "<strong>Created .htaccess content:</strong><br>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>";
    echo htmlspecialchars($htaccess_content);
    echo "</pre>";
    
    echo "<br>";
    echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>🎯 Test Your Site Now</h3>";
    echo "<p><strong>Simple .htaccess file created!</strong></p>";
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
    echo "<li>Adds security headers</li>";
    echo "<li>Hides sensitive files (.env, composer.json)</li>";
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
echo "<li><a href='disable-htaccess.php'>Disable .htaccess again</a></li>";
echo "<li><a href='debug-current-500.php'>Debug the 500 error</a></li>";
echo "</ul>";
?>
