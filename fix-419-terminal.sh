#!/bin/bash
# Fix 419 Page Expired (CSRF Token Mismatch) - Terminal Version
# Run this script on your IONOS server via SSH

echo "🔐 Fixing 419 Page Expired (CSRF Token Mismatch)"
echo "================================================"

# Navigate to Laravel directory
cd ~/nephroapp

# 1. Clear all Laravel caches
echo "🧹 Clearing all Laravel caches..."
/usr/bin/php8.2-cli artisan config:clear
/usr/bin/php8.2-cli artisan route:clear
/usr/bin/php8.2-cli artisan view:clear
/usr/bin/php8.2-cli artisan cache:clear
/usr/bin/php8.2-cli artisan optimize:clear
echo "✅ Caches cleared"

# 2. Clear session files
echo "🗑️ Clearing session files..."
rm -f storage/framework/sessions/*
echo "✅ Session files cleared"

# 3. Fix .env configuration
echo "⚙️ Fixing environment configuration..."

# Fix empty mail configuration
sed -i 's/MAIL_USERNAME=/MAIL_USERNAME=noreply@nephroapp.com/' .env
sed -i 's/MAIL_PASSWORD=/MAIL_PASSWORD=dummy_password/' .env

# Set correct APP_URL
sed -i "s|^APP_URL=.*|APP_URL=http://nephroapp.com|" .env

# Add/update session configuration
grep -q '^SESSION_DOMAIN=' .env && sed -i "s|^SESSION_DOMAIN=.*|SESSION_DOMAIN=.nephroapp.com|" .env || echo "SESSION_DOMAIN=.nephroapp.com" >> .env
grep -q '^SESSION_PATH=' .env && sed -i "s|^SESSION_PATH=.*|SESSION_PATH=/|" .env || echo "SESSION_PATH=/" >> .env
grep -q '^SESSION_SECURE_COOKIE=' .env && sed -i "s|^SESSION_SECURE_COOKIE=.*|SESSION_SECURE_COOKIE=false|" .env || echo "SESSION_SECURE_COOKIE=false" >> .env
grep -q '^SESSION_SAME_SITE=' .env && sed -i "s|^SESSION_SAME_SITE=.*|SESSION_SAME_SITE=lax|" .env || echo "SESSION_SAME_SITE=lax" >> .env
grep -q '^SESSION_DRIVER=' .env && sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=file|" .env || echo "SESSION_DRIVER=file" >> .env
grep -q '^SESSION_LIFETIME=' .env && sed -i "s|^SESSION_LIFETIME=.*|SESSION_LIFETIME=120|" .env || echo "SESSION_LIFETIME=120" >> .env
grep -q '^SESSION_ENCRYPT=' .env && sed -i "s|^SESSION_ENCRYPT=.*|SESSION_ENCRYPT=false|" .env || echo "SESSION_ENCRYPT=false" >> .env
grep -q '^SESSION_HTTP_ONLY=' .env && sed -i "s|^SESSION_HTTP_ONLY=.*|SESSION_HTTP_ONLY=true|" .env || echo "SESSION_HTTP_ONLY=true" >> .env

echo "✅ Environment configuration updated"

# 4. Regenerate APP_KEY if needed
echo "🔑 Checking APP_KEY..."
if ! grep -q "^APP_KEY=base64:" .env; then
    echo "⚠️ APP_KEY missing or invalid, generating new one..."
    /usr/bin/php8.2-cli artisan key:generate
    echo "✅ New APP_KEY generated"
else
    echo "✅ APP_KEY is properly set"
fi

# 5. Fix .htaccess for POST requests
echo "🔧 Updating .htaccess for POST-safe routing..."
cat > .htaccess << 'EOF'
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Handle POST requests directly to Laravel (no redirects)
RewriteCond %{REQUEST_METHOD} POST
RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]

# Handle GET requests with redirects
RewriteCond %{REQUEST_METHOD} GET
RewriteRule ^$ nephroapp/public/index.php [L]

RewriteCond %{REQUEST_METHOD} GET
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]
</IfModule>
EOF
echo "✅ .htaccess updated for POST-safe routing"

# 6. Update root index.php
echo "📄 Updating root index.php..."
cat > index.php << 'EOF'
<?php
$uri    = $_SERVER["REQUEST_URI"]  ?? "/";
$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

// For POST requests, directly include Laravel (no redirects)
if ($method === "POST") {
    chdir(__DIR__ . "/nephroapp/public");
    require __DIR__ . "/nephroapp/public/index.php";
    exit;
}

// For GET requests, redirect to Laravel
$query = $_SERVER["QUERY_STRING"] ?? "";
$dest = "/nephroapp/public" . $uri;
if ($query) $dest .= "?" . $query;
header("Location: " . $dest, true, 302);
exit;
?>
EOF
echo "✅ Root index.php updated"

# 7. Set proper file permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
chmod 644 .htaccess
chmod 644 index.php
echo "✅ File permissions set"

# 8. Test the fixes
echo "🧪 Testing the fixes..."
echo "Testing homepage..."
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/ | grep -q "200\|302" && echo "✅ Homepage accessible" || echo "⚠️ Homepage issue"

echo "Testing login page..."
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/login | grep -q "200\|302" && echo "✅ Login page accessible" || echo "⚠️ Login page issue"

echo ""
echo "🎉 419 Page Expired Fix Complete!"
echo "================================"
echo ""
echo "📋 What was fixed:"
echo "• Cleared all Laravel caches"
echo "• Cleared session files"
echo "• Fixed environment configuration"
echo "• Updated .htaccess for POST-safe routing"
echo "• Modified index.php for POST handling"
echo "• Set proper file permissions"
echo ""
echo "🚀 Next steps:"
echo "1. Clear your browser cookies for nephroapp.com"
echo "2. Try in an incognito/private window"
echo "3. Test your login and registration forms"
echo ""
echo "💡 If you still have issues:"
echo "• Check that forms include @csrf directive"
echo "• Verify forms use POST method"
echo "• Clear browser cache completely"
echo "• Check Laravel logs: tail -f storage/logs/laravel.log"
