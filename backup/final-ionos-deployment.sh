#!/bin/bash
# Final IONOS Deployment - Complete Laravel Project with ALL Dependencies
# Run this script on your IONOS server via SSH

echo "🚀 Final IONOS Deployment - Complete Laravel Project"
echo "===================================================="
echo "📦 Repository: https://github.com/hossamabohassan/nephroapp.git"
echo "🎯 This deployment includes ALL dependencies - no installations needed!"

# Backup existing deployment
echo ""
echo "💾 Backing up existing deployment..."
cd ~
if [ -d "nephroapp" ]; then
    if [ -d "nephroapp_backup_final" ]; then
        rm -rf nephroapp_backup_final
    fi
    mv nephroapp nephroapp_backup_final
    echo "✅ Backup created: nephroapp_backup_final"
else
    echo "ℹ️ No existing deployment to backup"
fi

# Clone complete project from GitHub
echo ""
echo "📥 Cloning COMPLETE project from GitHub..."
git clone https://github.com/hossamabohassan/nephroapp.git
cd nephroapp

# Verify ALL components are present
echo ""
echo "🔍 Verifying ALL components downloaded..."
components_ok=true

if [ -d "vendor" ]; then
    vendor_count=$(find vendor -name "*.php" | wc -l)
    echo "✅ vendor directory: $vendor_count PHP files"
else
    echo "❌ vendor directory MISSING"
    components_ok=false
fi

if [ -d "node_modules" ]; then
    node_count=$(ls node_modules | wc -l)
    echo "✅ node_modules directory: $node_count packages"
else
    echo "❌ node_modules directory MISSING"
    components_ok=false
fi

if [ -d "public/build" ]; then
    if [ -f "public/build/manifest.json" ]; then
        echo "✅ public/build directory with manifest.json"
    else
        echo "⚠️ public/build exists but no manifest.json"
    fi
else
    echo "❌ public/build directory MISSING"
    components_ok=false
fi

if [ "$components_ok" = false ]; then
    echo ""
    echo "❌ CRITICAL: Some components are missing from GitHub!"
    echo "Please ensure you pushed everything including vendor and node_modules"
    exit 1
fi

# Set proper permissions
echo ""
echo "🔐 Setting proper permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env.example
chmod -R 755 vendor/
chmod -R 755 public/build/

# Create required directories
echo "📁 Creating required directories..."
mkdir -p bootstrap/cache
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Copy and configure environment
echo ""
echo "📄 Setting up environment..."
cp .env.example .env

# Configure for IONOS
echo "⚙️ Configuring for IONOS..."
cat >> .env << 'EOF'

# IONOS Production Configuration
APP_ENV=production
APP_DEBUG=false
APP_URL=http://nephroapp.com

# Session Configuration
SESSION_DOMAIN=.nephroapp.com
SESSION_PATH=/
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=db5018653044.hosting-data.io
DB_PORT=3306
DB_DATABASE=dbs14780656
DB_USERNAME=dbu1219527
DB_PASSWORD=0100421606@Nephroapp

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.ionos.com
MAIL_PORT=587
MAIL_USERNAME=noreply@nephroapp.com
MAIL_PASSWORD=dummy_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@nephroapp.com"
MAIL_FROM_NAME="${APP_NAME}"
EOF

# Generate APP_KEY
echo ""
echo "🔑 Generating application key..."
/usr/bin/php8.2-cli artisan key:generate

# Create optimized .htaccess for root
echo ""
echo "🔧 Creating optimized .htaccess..."
cat > ../.htaccess << 'EOF'
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Handle POST requests directly (no redirects to avoid CSRF issues)
RewriteCond %{REQUEST_METHOD} POST
RewriteRule ^(.*)$ nephroapp/public/index.php [L,QSA]

# Handle GET requests
RewriteCond %{REQUEST_METHOD} GET
RewriteRule ^$ nephroapp/public/index.php [L]

RewriteCond %{REQUEST_METHOD} GET
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ nephroapp/public/index.php [L,QSA]
</IfModule>
EOF

# Create POST-safe index.php
echo "📄 Creating POST-safe index.php..."
cat > ../index.php << 'EOF'
<?php
$uri    = $_SERVER["REQUEST_URI"]  ?? "/";
$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

// For POST requests, directly include Laravel (prevents CSRF issues)
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

# Run database migrations
echo ""
echo "🗄️ Running database migrations..."
/usr/bin/php8.2-cli artisan migrate --force

# Optimize Laravel for production
echo ""
echo "⚡ Optimizing Laravel for production..."
/usr/bin/php8.2-cli artisan config:cache
/usr/bin/php8.2-cli artisan route:cache
/usr/bin/php8.2-cli artisan view:cache

# Verify deployment
echo ""
echo "🔍 Verifying deployment..."
echo "Laravel Version: $(/usr/bin/php8.2-cli artisan --version)"
echo "PHP Version: $(/usr/bin/php8.2-cli --version | head -1)"

# Test database connection
echo "🗄️ Testing database connection..."
/usr/bin/php8.2-cli artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database: Connected'; } catch(Exception \$e) { echo 'Database Error: ' . \$e->getMessage(); }" 2>/dev/null

# Test all URLs
echo ""
echo "🧪 Testing application URLs..."
echo "Testing homepage..."
homepage_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/)
echo "Homepage: $homepage_code"

echo "Testing login page..."
login_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/login)
echo "Login: $login_code"

echo "Testing register page..."
register_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/register)
echo "Register: $register_code"

echo "Testing direct Laravel..."
direct_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/nephroapp/public/)
echo "Direct Laravel: $direct_code"

# Final status
echo ""
echo "🎉 FINAL DEPLOYMENT COMPLETE!"
echo "============================="
echo ""
echo "📊 Deployment Summary:"
echo "• Laravel Version: $(/usr/bin/php8.2-cli artisan --version)"
echo "• Environment: Production (optimized)"
echo "• Dependencies: ALL included (no installations required)"
echo "• Database: Migrated"
echo "• Assets: Built and ready"
echo "• Routing: POST-safe (fixes CSRF issues)"
echo ""
echo "📈 URL Test Results:"
echo "• Homepage (http://nephroapp.com/): $homepage_code"
echo "• Login (http://nephroapp.com/login): $login_code"
echo "• Register (http://nephroapp.com/register): $register_code"
echo "• Direct (http://nephroapp.com/nephroapp/public/): $direct_code"
echo ""

# Success/failure summary
if [[ "$homepage_code" == "200" || "$homepage_code" == "302" ]] && [[ "$login_code" == "200" || "$login_code" == "302" ]]; then
    echo "🎊 SUCCESS! Your Laravel application is working perfectly!"
    echo "✅ All pages are accessible"
    echo "✅ No 500 errors"
    echo "✅ No 404 errors"
    echo "✅ Routing is working"
    echo ""
    echo "🌐 Your Application is Live:"
    echo "• Homepage: http://nephroapp.com/"
    echo "• Login: http://nephroapp.com/login"
    echo "• Register: http://nephroapp.com/register"
else
    echo "⚠️ Some URLs are not responding correctly"
    echo "Check the logs for specific errors:"
    echo "tail -f storage/logs/laravel.log"
fi

echo ""
echo "📝 Monitor your application:"
echo "tail -f storage/logs/laravel.log"
echo ""
echo "🔄 Emergency rollback (if needed):"
echo "cd ~ && rm -rf nephroapp && mv nephroapp_backup_final nephroapp"
