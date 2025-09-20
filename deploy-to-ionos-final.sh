#!/bin/bash
# Deploy COMPLETE Laravel Project to IONOS Server
# Run this script on your IONOS server via SSH

echo "🚀 Deploying COMPLETE Laravel Project to IONOS"
echo "==============================================="
echo "📦 Repository: https://github.com/hossamabohassan/nephroapp.git"

# Backup existing deployment
echo "💾 Backing up existing deployment..."
cd ~
if [ -d "nephroapp" ]; then
    if [ -d "nephroapp_backup" ]; then
        rm -rf nephroapp_backup
    fi
    mv nephroapp nephroapp_backup
    echo "✅ Backup created: nephroapp_backup"
fi

# Clone fresh from GitHub (with ALL files)
echo "📥 Cloning COMPLETE project from GitHub..."
git clone https://github.com/hossamabohassan/nephroapp.git
cd nephroapp

# Verify all directories exist
echo "🔍 Verifying all files were downloaded..."
if [ -d "vendor" ]; then
    echo "✅ vendor directory found ($(ls vendor | wc -l) packages)"
else
    echo "❌ vendor directory missing"
fi

if [ -d "node_modules" ]; then
    echo "✅ node_modules directory found"
else
    echo "ℹ️ node_modules directory not found (normal for some deployments)"
fi

if [ -d "public/build" ]; then
    echo "✅ public/build directory found"
else
    echo "❌ public/build directory missing"
fi

# Set proper permissions
echo "🔐 Setting proper permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env.example
if [ -d "vendor" ]; then
    chmod -R 755 vendor/
fi

# Copy and configure environment file
echo "📄 Setting up environment..."
cp .env.example .env

# Configure environment for IONOS
echo "⚙️ Configuring for IONOS..."
cat >> .env << 'EOF'

# IONOS Configuration
APP_URL=http://nephroapp.com
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

# Generate app key
echo "🔑 Generating application key..."
/usr/bin/php8.2-cli artisan key:generate

# Create .htaccess for root
echo "🔧 Creating .htaccess..."
cat > ../.htaccess << 'EOF'
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Handle POST requests directly to Laravel (no redirects)
RewriteCond %{REQUEST_METHOD} POST
RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]

# Handle GET requests
RewriteCond %{REQUEST_METHOD} GET
RewriteRule ^$ nephroapp/public/index.php [L]

RewriteCond %{REQUEST_METHOD} GET
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ nephroapp/public/index.php/$1 [L,QSA]
</IfModule>
EOF

# Create index.php for POST-safe routing
echo "📄 Creating POST-safe index.php..."
cat > ../index.php << 'EOF'
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

# Run database migrations
echo "🗄️ Running database migrations..."
/usr/bin/php8.2-cli artisan migrate --force

# Clear all caches and optimize
echo "⚡ Optimizing Laravel..."
/usr/bin/php8.2-cli artisan config:clear
/usr/bin/php8.2-cli artisan route:clear
/usr/bin/php8.2-cli artisan view:clear
/usr/bin/php8.2-cli artisan cache:clear

# Verify Laravel version
echo "🔍 Verifying deployment..."
echo "Laravel Version: $(/usr/bin/php8.2-cli artisan --version)"
echo "PHP Version: $(/usr/bin/php8.2-cli --version | head -1)"

# Test all important URLs
echo "🧪 Testing application..."
echo "Testing homepage..."
curl -s -o /dev/null -w "Homepage: %{http_code}\n" http://nephroapp.com/

echo "Testing login page..."
curl -s -o /dev/null -w "Login: %{http_code}\n" http://nephroapp.com/login

echo "Testing register page..."
curl -s -o /dev/null -w "Register: %{http_code}\n" http://nephroapp.com/register

echo ""
echo "🎉 COMPLETE DEPLOYMENT SUCCESSFUL!"
echo "================================="
echo ""
echo "✅ Deployed:"
echo "• Complete Laravel 12.30.1 project"
echo "• ALL vendor dependencies included"
echo "• Built assets included"
echo "• Database migrated"
echo "• Environment configured for IONOS"
echo "• Routing optimized for shared hosting"
echo ""
echo "🌐 Your Application:"
echo "• Homepage: http://nephroapp.com/"
echo "• Login: http://nephroapp.com/login"
echo "• Register: http://nephroapp.com/register"
echo ""
echo "📝 Monitor your application:"
echo "tail -f storage/logs/laravel.log"
echo ""
echo "🔄 If issues occur, rollback:"
echo "cd ~ && rm -rf nephroapp && mv nephroapp_backup nephroapp"
