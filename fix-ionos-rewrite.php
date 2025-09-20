<?php
// IONOS Web Hosting Plus - Proper .htaccess Configuration
echo "<h2>🔧 IONOS Web Hosting Plus - Laravel .htaccess Fix</h2>";

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🌐 IONOS Web Hosting Plus</strong><br>";
echo "mod_rewrite is enabled - configuring proper .htaccess with RewriteBase<br>";
echo "</div>";

// Step 1: Remove old .htaccess
echo "<h3>Step 1: Remove Old .htaccess</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

if (file_exists('.htaccess')) {
    if (unlink('.htaccess')) {
        echo "✅ Removed old .htaccess file<br>";
    } else {
        echo "❌ Could not remove old .htaccess<br>";
    }
} else {
    echo "✅ No old .htaccess to remove<br>";
}

echo "</div>";

// Step 2: Create proper IONOS .htaccess
echo "<h3>Step 2: Create IONOS-Compatible .htaccess</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$ionosHtaccess = 'RewriteEngine On
RewriteBase /

# Handle root requests - redirect to Laravel
RewriteRule ^$ nephroapp/public/index.php [L]

# Handle all other requests - redirect to Laravel with path
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]';

if (file_put_contents('.htaccess', $ionosHtaccess)) {
    echo "✅ Created IONOS-compatible .htaccess<br>";
    echo "📄 Size: " . filesize('.htaccess') . " bytes<br>";
    
    // Set correct permissions (644)
    if (chmod('.htaccess', 0644)) {
        echo "✅ Set permissions to 644<br>";
    } else {
        echo "⚠️ Could not set permissions (may not be needed)<br>";
    }
    
    echo "<strong>Content:</strong><br>";
    echo "<pre style='background: white; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($ionosHtaccess);
    echo "</pre>";
} else {
    echo "❌ Could not create .htaccess file<br>";
}

echo "</div>";

// Step 3: Update Laravel's public .htaccess  
echo "<h3>Step 3: Update Laravel's Public .htaccess</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$laravelPublicHtaccess = 'RewriteEngine On
RewriteBase /nephroapp/public/

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
RewriteRule ^ index.php [L]';

$publicHtaccessPath = 'nephroapp/public/.htaccess';

if (file_put_contents($publicHtaccessPath, $laravelPublicHtaccess)) {
    echo "✅ Updated Laravel's public .htaccess<br>";
    echo "📄 Size: " . filesize($publicHtaccessPath) . " bytes<br>";
    
    if (chmod($publicHtaccessPath, 0644)) {
        echo "✅ Set permissions to 644<br>";
    }
} else {
    echo "❌ Could not update Laravel's public .htaccess<br>";
}

echo "</div>";

// Step 4: Test the configuration
echo "<h3>Step 4: Test .htaccess Configuration</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

// Check if files exist with correct permissions
$files = ['.htaccess', 'nephroapp/public/.htaccess'];
foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "✅ $file exists (permissions: $perms)<br>";
    } else {
        echo "❌ $file missing<br>";
    }
}

echo "</div>";

// Step 5: Test URLs
echo "<h3>Step 5: Test Your URLs</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";

echo "<strong>🧪 Test these URLs in order:</strong><br><br>";

$testUrls = [
    'http://nephroapp.com/nephroapp/public/' => 'Direct Laravel (should always work)',
    'http://nephroapp.com/nephroapp/public/login' => 'Direct login (should always work)',
    'http://nephroapp.com/' => 'Homepage with .htaccess redirect',
    'http://nephroapp.com/login' => 'Login with .htaccess redirect',
    'http://nephroapp.com/register' => 'Register with .htaccess redirect'
];

$priority = 1;
foreach ($testUrls as $url => $description) {
    echo "<div style='margin: 5px 0; padding: 8px; background: white; border-left: 3px solid #007cba;'>";
    echo "<strong>$priority. <a href='$url' target='_blank' style='color: #2563eb;'>$url</a></strong>";
    echo "<br><small>$description</small>";
    echo "</div>";
    $priority++;
}

echo "<br><strong>🎯 Test Strategy:</strong><br>";
echo "1. Test direct URLs first (#1, #2) - these should always work<br>";
echo "2. If direct URLs work, test .htaccess redirects (#3, #4, #5)<br>";
echo "3. If redirects work, your Laravel app is fully functional!<br>";

echo "</div>";

// Step 6: Troubleshooting for IONOS
echo "<h3>Step 6: IONOS-Specific Troubleshooting</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px;'>";

echo "<strong>🔧 If you still see errors:</strong><br><br>";

echo "<strong>1. Check .htaccess syntax:</strong><br>";
echo "• Make sure there are no extra spaces or characters<br>";
echo "• Verify the file is named exactly '.htaccess' (no .txt extension)<br>";
echo "• Ensure Unix line endings (not Windows CRLF)<br><br>";

echo "<strong>2. File permissions:</strong><br>";
echo "• .htaccess should be 644<br>";
echo "• If 644 doesn't work, try 604 or 600<br>";
echo "• Some hosts prefer different permission levels<br><br>";

echo "<strong>3. IONOS control panel:</strong><br>";
echo "• Check if there are any additional Apache settings<br>";
echo "• Verify PHP version is 8.2+ for Laravel 11<br>";
echo "• Look for any hosting-specific restrictions<br><br>";

echo "<strong>4. Clear browser cache:</strong><br>";
echo "• Press Ctrl+F5 or Cmd+Shift+R<br>";
echo "• Try incognito/private browsing mode<br>";
echo "• Clear browser cache completely<br>";

echo "</div>";

// Step 7: Success indicators
echo "<h3>Step 7: Success Indicators</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";

echo "<strong>✅ You'll know it's working when:</strong><br><br>";

echo "• <strong>http://nephroapp.com/</strong> shows your Laravel homepage<br>";
echo "• <strong>http://nephroapp.com/login</strong> shows the login form<br>";
echo "• <strong>http://nephroapp.com/register</strong> shows the registration form<br>";
echo "• No more 'Not Found' or '500 Internal Server' errors<br>";
echo "• Clean URLs work without '/nephroapp/public/' prefix<br><br>";

echo "<strong>🎉 If successful:</strong><br>";
echo "Your Laravel NephroApp will be fully functional with clean URLs!<br>";
echo "Users can access login, register, and all features normally.<br>";

echo "</div>";

echo "<hr>";
echo "<p><strong>💡 Key Point:</strong> Since IONOS Web Hosting Plus has mod_rewrite enabled, this proper configuration with RewriteBase should resolve all URL routing issues!</p>";
?>
