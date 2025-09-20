#!/bin/bash
# Deploy Laravel Project to IONOS Server
# Run this script on your IONOS server via SSH

echo "🚀 Deploying Laravel Project to IONOS"
echo "====================================="

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

# Clone fresh from GitHub
echo "📥 Cloning fresh from GitHub..."
git clone https://github.com/yourusername/nephroapp.git
cd nephroapp

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
/usr/bin/php8.2-cli /usr/bin/composer install --optimize-autoloader --no-dev

# Set proper permissions
echo "🔐 Setting proper permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env.example

# Copy environment file
echo "📄 Setting up environment..."
cp .env.example .env

# Generate app key
echo "🔑 Generating application key..."
/usr/bin/php8.2-cli artisan key:generate

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
DB_PASSWORD=YOUR_DATABASE_PASSWORD

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

# Run database migrations
echo "🗄️ Running database migrations..."
/usr/bin/php8.2-cli artisan migrate --force

# Clear and cache configuration
echo "⚡ Optimizing Laravel..."
/usr/bin/php8.2-cli artisan config:cache
/usr/bin/php8.2-cli artisan route:cache
/usr/bin/php8.2-cli artisan view:cache

# Verify Laravel version
echo "🔍 Verifying Laravel version..."
/usr/bin/php8.2-cli artisan --version

echo ""
echo "🎉 Deployment Complete!"
echo "======================"
echo ""
echo "✅ What was done:"
echo "• Backed up old deployment"
echo "• Cloned fresh from GitHub"
echo "• Installed PHP dependencies"
echo "• Set proper file permissions"
echo "• Configured environment for IONOS"
echo "• Created .htaccess file"
echo "• Ran database migrations"
echo "• Optimized Laravel"
echo ""
echo "🚀 Test Your Application:"
echo "• Homepage: http://nephroapp.com/"
echo "• Login: http://nephroapp.com/login"
echo "• Register: http://nephroapp.com/register"
echo ""
echo "⚠️ Important:"
echo "• Update database password in .env if needed"
echo "• Monitor logs: tail -f storage/logs/laravel.log"
echo ""
echo "🔄 If issues occur, rollback with:"
echo "cd ~ && rm -rf nephroapp && mv nephroapp_backup nephroapp"
