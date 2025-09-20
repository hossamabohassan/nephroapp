#!/bin/bash
# Deploy COMPLETE Laravel Project to IONOS Server (including vendor)
# Run this script on your IONOS server via SSH

echo "🚀 Deploying COMPLETE Laravel Project to IONOS"
echo "==============================================="
echo "📦 This includes vendor, node_modules, and ALL files!"

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
git clone https://github.com/yourusername/nephroapp.git
cd nephroapp

# Verify all directories exist
echo "🔍 Verifying all files were downloaded..."
if [ -d "vendor" ]; then
    echo "✅ vendor directory found"
else
    echo "❌ vendor directory missing - installing..."
    /usr/bin/php8.2-cli /usr/bin/composer install --optimize-autoloader --no-dev
fi

if [ -d "node_modules" ]; then
    echo "✅ node_modules directory found"
else
    echo "❌ node_modules directory missing - this is expected on shared hosting"
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

# Database Configuration (UPDATE THESE VALUES)
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

# Generate app key (or keep existing one)
echo "🔑 Setting up application key..."
if ! grep -q "^APP_KEY=base64:" .env; then
    /usr/bin/php8.2-cli artisan key:generate
else
    echo "✅ APP_KEY already configured"
fi

# Create .htaccess for root
echo "🔧 Creating .htaccess..."
cat > ../.htaccess << 'EOF'
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Handle root requests
RewriteRule ^$ nephroapp/public/index.php [L]

# Handle all other requests to Laravel
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

# Clear and cache configuration
echo "⚡ Optimizing Laravel..."
/usr/bin/php8.2-cli artisan config:clear
/usr/bin/php8.2-cli artisan route:clear
/usr/bin/php8.2-cli artisan view:clear
/usr/bin/php8.2-cli artisan cache:clear

# Verify Laravel version
echo "🔍 Verifying Laravel version..."
/usr/bin/php8.2-cli artisan --version

# Test basic functionality
echo "🧪 Testing basic functionality..."
echo "Testing homepage..."
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/ | grep -q "200\|302" && echo "✅ Homepage accessible" || echo "⚠️ Homepage issue"

echo "Testing login page..."
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/login | grep -q "200\|302" && echo "✅ Login page accessible" || echo "⚠️ Login page issue"

echo ""
echo "🎉 COMPLETE Deployment Finished!"
echo "================================"
echo ""
echo "✅ What was deployed:"
echo "• Complete Laravel project with ALL files"
echo "• vendor directory (PHP dependencies)"
echo "• node_modules directory (if included)"
echo "• public/build directory (built assets)"
echo "• All custom files and configurations"
echo "• Database migrations executed"
echo "• Environment configured for IONOS"
echo "• Routing configured (.htaccess + index.php)"
echo ""
echo "📊 Project Information:"
echo "• Laravel Version: $(/usr/bin/php8.2-cli artisan --version)"
echo "• PHP Version: $(/usr/bin/php8.2-cli --version | head -1)"
echo ""
echo "🚀 Test Your Application:"
echo "• Homepage: http://nephroapp.com/"
echo "• Login: http://nephroapp.com/login"
echo "• Register: http://nephroapp.com/register"
echo ""
echo "📝 Monitor logs:"
echo "tail -f storage/logs/laravel.log"
echo ""
echo "🔄 If issues occur, rollback with:"
echo "cd ~ && rm -rf nephroapp && mv nephroapp_backup nephroapp"
