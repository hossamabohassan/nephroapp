<?php
/**
 * Fix .htaccess Configuration for IONOS Shared Hosting
 * Run this file in your browser after uploading to IONOS
 */

echo "<h1>🔧 Fixing .htaccess for IONOS</h1>";

// Create root .htaccess for IONOS
$rootHtaccess = '<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Handle root requests
RewriteRule ^$ nephroapp/public/index.php [L]

# Handle all other requests to Laravel
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]
</IfModule>';

$rootHtaccessPath = __DIR__ . '/.htaccess';
file_put_contents($rootHtaccessPath, $rootHtaccess);
chmod($rootHtaccessPath, 0644);
echo "✅ Created root .htaccess<br>";

// Ensure Laravel's public .htaccess exists
$publicHtaccessPath = __DIR__ . '/public/.htaccess';
if (!file_exists($publicHtaccessPath)) {
    $publicHtaccess = '<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>';

    file_put_contents($publicHtaccessPath, $publicHtaccess);
    chmod($publicHtaccessPath, 0644);
    echo "✅ Created public/.htaccess<br>";
} else {
    echo "✅ public/.htaccess already exists<br>";
}

// Create index.php in root for POST-safe routing
$rootIndex = '<?php
$uri    = $_SERVER["REQUEST_URI"]  ?? "/";
$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

if ($method === "POST") {
    chdir(__DIR__ . "/nephroapp/public");
    require __DIR__ . "/nephroapp/public/index.php";
    exit;
}

$query = $_SERVER["QUERY_STRING"] ?? "";
$dest = "/nephroapp/public" . $uri;
if ($query) $dest .= "?" . $query;
header("Location: " . $dest, true, 302);
exit;
?>';

$rootIndexPath = __DIR__ . '/index.php';
file_put_contents($rootIndexPath, $rootIndex);
chmod($rootIndexPath, 0644);
echo "✅ Created root index.php for POST-safe routing<br>";

echo "<br><h2>🎉 .htaccess Configuration Fixed!</h2>";
echo "<p>Your Laravel app should now handle routing correctly on IONOS.</p>";
echo "<p><strong>Test these URLs:</strong></p>";
echo "<ul>";
echo "<li><a href='/'>Homepage</a></li>";
echo "<li><a href='/login'>Login</a></li>";
echo "<li><a href='/register'>Register</a></li>";
echo "</ul>";
?>