# IONOS Deployment - Manual Steps

## What I've Already Done ✅
- Optimized Laravel for production (composer install --no-dev)
- Created configuration, route, and view caches
- Created deployment guide and checklist

## What You Need to Do Next

### Step 1: Create Deployment Package (Manual)

1. **Create a new folder** called `deployment-package` in your project root

2. **Copy these folders** from your project to `deployment-package`:
   - `app/`
   - `bootstrap/`
   - `config/`
   - `database/`
   - `public/` (rename to `public_html` in the package)
   - `resources/`
   - `routes/`
   - `storage/`
   - `vendor/`

3. **Copy these files** from your project to `deployment-package`:
   - `artisan`
   - `composer.json`
   - `composer.lock`

### Step 2: Create Production .env File

Create a file called `.env` in your `deployment-package` folder with this content:

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

MAIL_MAILER=log
```

### Step 3: Create .htaccess File

Create a file called `.htaccess` in your `deployment-package` folder with this content:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public_html/$1 [L]
</IfModule>
```

### Step 4: IONOS Hosting Setup

1. **Log into IONOS Control Panel**
2. **Go to "Hosting & WordPress"**
3. **Select your hosting package**
4. **Click "Manage"**

### Step 5: Database Setup

1. **Go to "Databases" section**
2. **Create new MySQL database**
3. **Create database user with full privileges**
4. **Note down these credentials:**
   - Database name: _______________
   - Username: _______________
   - Password: _______________
   - Host: localhost

### Step 6: Upload Files

1. **Open IONOS File Manager**
2. **Navigate to your domain root** (usually `htdocs` or `public_html`)
3. **Upload all contents** of your `deployment-package` folder
4. **Ensure the directory structure looks like this:**
   ```
   yourdomain.com/
   ├── app/
   ├── bootstrap/
   ├── config/
   ├── database/
   ├── public_html/
   ├── resources/
   ├── routes/
   ├── storage/
   ├── vendor/
   ├── .env
   ├── .htaccess
   ├── artisan
   ├── composer.json
   └── composer.lock
   ```

### Step 7: Configure Environment

1. **Edit the `.env` file** on your server
2. **Update these values:**
   - `APP_URL=https://yourdomain.com` (replace with your actual domain)
   - `DB_DATABASE=your_database_name` (replace with your database name)
   - `DB_USERNAME=your_database_username` (replace with your database username)
   - `DB_PASSWORD=your_database_password` (replace with your database password)

### Step 8: Generate Application Key

**Via IONOS Control Panel Terminal/SSH:**
```bash
php artisan key:generate
```

**Or manually:** Copy the APP_KEY from your local `.env` file to the server `.env` file.

### Step 9: Run Database Migrations

```bash
php artisan migrate --force
```

### Step 10: Set Permissions

Set these permissions on your server:
- `storage/` directory: 755 or 777
- `bootstrap/cache/` directory: 755 or 777

### Step 11: Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Step 12: Test Your Application

1. **Visit your domain**
2. **Check if the homepage loads**
3. **Test user registration/login**
4. **Check for any errors**

## Troubleshooting

### If you get 500 Internal Server Error:
1. Check file permissions on `storage/` and `bootstrap/cache/`
2. Verify `.env` file exists and has correct database credentials
3. Check error logs in `storage/logs/laravel.log`

### If you get Database Connection Error:
1. Verify database credentials in `.env`
2. Ensure database exists and user has proper permissions
3. Check if database host is correct (usually `localhost`)

### If you get File Not Found Errors:
1. Check if all files uploaded correctly
2. Verify directory structure
3. Check `.htaccess` file is in place

## IONOS-Specific Notes

- **PHP Version**: Ensure your hosting supports PHP 8.1+
- **Extensions**: Verify required PHP extensions are enabled
- **Memory Limit**: May need to increase PHP memory limit
- **File Upload**: Check file upload limits

## Security Checklist

- [ ] Set APP_DEBUG=false
- [ ] Use strong database passwords
- [ ] Enable SSL certificate
- [ ] Set proper file permissions
- [ ] Keep Laravel updated

## Need Help?

If you encounter issues:
1. Check the error logs first
2. Verify all steps were completed
3. Contact IONOS support if needed
4. Check Laravel documentation for specific errors

---

**Your deployment package should be ready in the `deployment-package` folder!**
