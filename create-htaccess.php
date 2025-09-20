<?php
// Create .htaccess file for URL routing
echo "<h2>🔧 Create .htaccess File</h2>";

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📁 Working in:</strong> " . getcwd() . "<br>";
echo "</div>";

// Step 1: Create .htaccess file
echo "<h3>Step 1: Create .htaccess File</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$htaccessContent = '<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Handle root requests
    RewriteRule ^$ nephroapp/public/index.php [L]
    
    # Handle all other requests to Laravel
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]
</IfModule>';

if (file_put_contents('.htaccess', $htaccessContent)) {
    echo "✅ Created .htaccess file successfully<br>";
    echo "📄 File size: " . filesize('.htaccess') . " bytes<br>";
} else {
    echo "❌ Failed to create .htaccess file<br>";
    echo "⚠️ This might be a permissions issue<br>";
}

echo "</div>";

// Step 2: Verify .htaccess was created
echo "<h3>Step 2: Verify .htaccess Content</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

if (file_exists('.htaccess')) {
    echo "✅ .htaccess file now exists<br>";
    $content = file_get_contents('.htaccess');
    echo "<strong>Content:</strong><br>";
    echo "<pre style='background: white; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($content);
    echo "</pre>";
} else {
    echo "❌ .htaccess file still not found<br>";
}

echo "</div>";

// Step 3: Alternative approach if .htaccess fails
echo "<h3>Step 3: Alternative - Update index.php</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$improvedIndexContent = '<?php
// Improved redirect for Laravel routing
$uri = $_SERVER["REQUEST_URI"];
$query = $_SERVER["QUERY_STRING"] ?? "";

// Remove query string from URI for clean matching
$path = parse_url($uri, PHP_URL_PATH);

// Direct routes that should work
if ($path === "/" || $path === "") {
    header("Location: /nephroapp/public/", true, 302);
    exit;
}

// Handle login and register specifically
if ($path === "/login") {
    header("Location: /nephroapp/public/login", true, 302);
    exit;
}

if ($path === "/register") {
    header("Location: /nephroapp/public/register", true, 302);
    exit;
}

// Handle all other routes
$redirect_url = "/nephroapp/public" . $path;
if (!empty($query)) {
    $redirect_url .= "?" . $query;
}

header("Location: " . $redirect_url, true, 302);
exit;
?>';

if (file_put_contents('index.php', $improvedIndexContent)) {
    echo "✅ Updated index.php with improved routing<br>";
    echo "📄 New file size: " . filesize('index.php') . " bytes<br>";
} else {
    echo "❌ Failed to update index.php<br>";
}

echo "</div>";

// Step 4: Test the fixes
echo "<h3>Step 4: Test Your URLs Now</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";

echo "<strong>🧪 Test these URLs after the fix:</strong><br><br>";

$testUrls = [
    'http://nephroapp.com/' => 'Homepage (should redirect to Laravel)',
    'http://nephroapp.com/login' => 'Login page (should work now)',
    'http://nephroapp.com/register' => 'Register page (should work now)',
    'http://nephroapp.com/nephroapp/public/' => 'Direct Laravel (should always work)',
    'http://nephroapp.com/nephroapp/public/login' => 'Direct login (should always work)'
];

foreach ($testUrls as $url => $description) {
    echo "<div style='margin: 5px 0; padding: 8px; background: white; border-left: 3px solid #007cba;'>";
    echo "<strong><a href='$url' target='_blank' style='color: #2563eb; text-decoration: none;'>Test: $url</a></strong>";
    echo "<br><small style='color: #666;'>$description</small>";
    echo "</div>";
}

echo "</div>";

// Step 5: Troubleshooting
echo "<h3>Step 5: If URLs Still Don't Work</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px;'>";

echo "<strong>Try these in order:</strong><br><br>";

echo "1. <strong>Test direct Laravel URL first:</strong><br>";
echo "&nbsp;&nbsp;• <a href='http://nephroapp.com/nephroapp/public/login' target='_blank'>Direct Login</a><br>";
echo "&nbsp;&nbsp;• If this works, the issue is just URL rewriting<br><br>";

echo "2. <strong>Clear browser cache:</strong><br>";
echo "&nbsp;&nbsp;• Press Ctrl+F5 or Cmd+Shift+R<br>";
echo "&nbsp;&nbsp;• Or try an incognito/private window<br><br>";

echo "3. <strong>Check server configuration:</strong><br>";
echo "&nbsp;&nbsp;• IONOS might have mod_rewrite disabled<br>";
echo "&nbsp;&nbsp;• The .htaccess file might not be processed<br><br>";

echo "4. <strong>Use direct URLs as backup:</strong><br>";
echo "&nbsp;&nbsp;• Always use /nephroapp/public/ prefix<br>";
echo "&nbsp;&nbsp;• This will always work regardless of .htaccess<br>";

echo "</div>";

echo "<hr>";
echo "<h3>🎯 Expected Results</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";
echo "<strong>After this fix:</strong><br>";
echo "✅ http://nephroapp.com/login should show the login page<br>";
echo "✅ http://nephroapp.com/register should show the register page<br>";
echo "✅ http://nephroapp.com/ should show your homepage<br>";
echo "✅ All Laravel functionality should work<br>";
echo "</div>";
?>
