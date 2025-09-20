# 🚀 Fresh Laravel Deployment Guide - Localhost to IONOS

## 📋 Current Local Environment
- **Laravel Framework**: 12.30.1
- **PHP**: 8.3.25
- **Composer**: 2.8.11
- **Node.js**: 22.19.0
- **NPM**: 10.9.3

## 🧹 Step 1: Clean Up Local Project

### Remove Development Files
```bash
# Remove node_modules (will reinstall on server)
rm -rf node_modules

# Remove vendor (will install fresh on server)
rm -rf vendor

# Remove build files
rm -rf public/build

# Remove development caches
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# Remove logs
rm -rf storage/logs/*
```

### Clean .env for Production
```bash
# Create production .env template
cp .env .env.production.template
```

## 🔧 Step 2: Prepare for Deployment

### Build Assets Locally
```bash
# Install fresh dependencies
npm install

# Build production assets
npm run build
```

### Install PHP Dependencies
```bash
# Install fresh composer dependencies
composer install --optimize-autoloader --no-dev
```

## 📤 Step 3: Push to GitHub

### Initialize/Update Git Repository
```bash
# Add all files
git add .

# Commit changes
git commit -m "Fresh deployment - Laravel 12.30.1"

# Push to GitHub
git push origin main
```

## 🌐 Step 4: Deploy to IONOS

### Download from GitHub
```bash
# On IONOS server
cd ~
rm -rf nephroapp_backup
mv nephroapp nephroapp_backup  # Backup old version
git clone https://github.com/yourusername/nephroapp.git
cd nephroapp
```

### Install Dependencies on IONOS
```bash
# Install PHP dependencies
/usr/bin/php8.2-cli /usr/bin/composer install --optimize-autoloader --no-dev

# Set proper permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
```

### Configure Environment
```bash
# Copy and configure .env
cp .env.example .env
# Edit .env with IONOS database credentials

# Generate app key
/usr/bin/php8.2-cli artisan key:generate

# Clear and cache config
/usr/bin/php8.2-cli artisan config:cache
/usr/bin/php8.2-cli artisan route:cache
/usr/bin/php8.2-cli artisan view:cache
```

### Run Migrations
```bash
# Run database migrations
/usr/bin/php8.2-cli artisan migrate --force
```

## ⚙️ Step 5: Configure IONOS-Specific Settings

### Create .htaccess
```apache
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
```

### Configure Session Settings
```bash
# Add to .env
SESSION_DOMAIN=.nephroapp.com
SESSION_PATH=/
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
SESSION_DRIVER=file
```

## 🧪 Step 6: Test Deployment

### Test URLs
- Homepage: http://nephroapp.com/
- Login: http://nephroapp.com/login
- Register: http://nephroapp.com/register

### Verify Versions Match
```bash
# Check Laravel version on server
/usr/bin/php8.2-cli artisan --version
# Should show: Laravel Framework 12.30.1
```

## 🔍 Step 7: Monitor and Debug

### Check Logs
```bash
# Monitor Laravel logs
tail -f storage/logs/laravel.log
```

### Common Issues and Fixes
1. **Permission Issues**: `chmod -R 755 storage/ bootstrap/cache/`
2. **Cache Issues**: `/usr/bin/php8.2-cli artisan optimize:clear`
3. **Database Issues**: Check .env database credentials
4. **Session Issues**: Verify session configuration in .env

## ✅ Success Checklist
- [ ] Local version matches server version (Laravel 12.30.1)
- [ ] All routes accessible (/, /login, /register)
- [ ] No 500 errors
- [ ] No 404 errors
- [ ] No 419 errors
- [ ] Forms submit successfully
- [ ] Database connected
- [ ] Assets loading properly

## 🚨 Emergency Rollback
If something goes wrong:
```bash
# Restore backup
cd ~
rm -rf nephroapp
mv nephroapp_backup nephroapp
```
