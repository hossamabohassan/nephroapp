# Laravel Deployment to IONOS Shared Hosting

## Step-by-Step Deployment Guide

### Step 1: Prepare Your Laravel Project ✅
- [x] Run `composer install --optimize-autoloader --no-dev`
- [x] Run `php artisan config:cache`
- [x] Run `php artisan route:cache`
- [x] Run `php artisan view:cache`

### Step 2: Create Production Environment File

Create a `.env` file on your server with these settings:

```env
APP_NAME="NephroCoach"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stack
LOG_LEVEL=error
```

### Step 3: IONOS Hosting Setup

#### 3.1 Access IONOS Control Panel
1. Log into your IONOS account
2. Go to "Hosting & WordPress"
3. Select your hosting package
4. Click "Manage"

#### 3.2 Database Setup
1. Go to "Databases" section
2. Create a new MySQL database
3. Create a database user
4. Note down the database credentials

#### 3.3 File Manager Access
1. Go to "File Manager" or use FTP
2. Navigate to your domain's root directory (usually `htdocs` or `public_html`)

### Step 4: Upload Files

#### 4.1 Files to Upload
Upload these files/folders to your hosting root:
- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `public/` (rename to `public_html` or move contents to root)
- `resources/`
- `routes/`
- `storage/`
- `vendor/`
- `.env` (create this file)
- `artisan`
- `composer.json`
- `composer.lock`

#### 4.2 Directory Structure on Server
```
yourdomain.com/
├── app/
├── bootstrap/
├── config/
├── database/
├── public_html/ (or root)
│   ├── index.php
│   ├── css/
│   ├── js/
│   └── ...
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
└── composer.lock
```

### Step 5: Configure Web Server

#### 5.1 Update index.php
Edit `public_html/index.php` (or root `index.php`):

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
```

#### 5.2 Create .htaccess (if needed)
Create `.htaccess` in your root directory:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Step 6: Set Permissions

Set these permissions on your server:
- `storage/` - 755 (or 777 if needed)
- `bootstrap/cache/` - 755 (or 777 if needed)

### Step 7: Generate Application Key

Run this command on your server (via SSH or control panel):
```bash
php artisan key:generate
```

### Step 8: Run Migrations

```bash
php artisan migrate --force
```

### Step 9: Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Step 10: Test Your Application

1. Visit your domain
2. Check if the application loads
3. Test key functionality
4. Check error logs if issues occur

## Troubleshooting Common Issues

### Issue 1: 500 Internal Server Error
- Check file permissions
- Verify .env file exists and is configured correctly
- Check error logs in `storage/logs/`

### Issue 2: Database Connection Error
- Verify database credentials in .env
- Ensure database exists and user has proper permissions

### Issue 3: File Not Found Errors
- Check if all files are uploaded correctly
- Verify directory structure
- Check .htaccess configuration

### Issue 4: Permission Errors
- Set proper permissions on storage and bootstrap/cache directories
- Contact IONOS support if needed

## IONOS-Specific Notes

1. **PHP Version**: Ensure your hosting supports PHP 8.1+
2. **Extensions**: Verify required PHP extensions are enabled
3. **Memory Limit**: May need to increase PHP memory limit
4. **File Upload**: Check file upload limits for media files

## Security Checklist

- [ ] Set APP_DEBUG=false
- [ ] Use strong database passwords
- [ ] Enable SSL certificate
- [ ] Set proper file permissions
- [ ] Keep Laravel and dependencies updated
