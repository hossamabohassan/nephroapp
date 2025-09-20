# 🚀 IONOS Laravel Deployment Fix Scripts

These PHP scripts will fix common issues when moving your Laravel app from localhost to IONOS shared hosting.

## 📋 Deployment Steps

### 1. Upload Your Laravel App
Upload your entire Laravel project to your IONOS hosting account.

### 2. Run These Fix Scripts (in order)

Run each script in your browser by visiting:
- `http://yourdomain.com/fix-vite-web.php`
- `http://yourdomain.com/fix-ionos-htaccess.php`
- `http://yourdomain.com/fix-bootstrap-routes.php`
- `http://yourdomain.com/fix-env-config.php`
- `http://yourdomain.com/clear-caches.php`
- `http://yourdomain.com/fix-csrf-sessions.php`

### 3. Test Your Application
After running all scripts, test:
- Homepage: `http://yourdomain.com/`
- Login: `http://yourdomain.com/login`
- Register: `http://yourdomain.com/register`

## 🔧 What Each Script Does

### `fix-vite-web.php`
- Creates missing Vite manifest file
- Generates basic CSS and JavaScript assets
- Fixes "ViteManifestNotFoundException" errors

### `fix-ionos-htaccess.php`
- Creates proper .htaccess configuration for IONOS
- Sets up URL rewriting for Laravel
- Creates POST-safe routing

### `fix-bootstrap-routes.php`
- Fixes Laravel 11 bootstrap configuration
- Ensures authentication routes are loaded
- Adds missing Route facade import

### `fix-env-config.php`
- Fixes empty mail configuration (prevents "Path cannot be empty" errors)
- Sets correct APP_URL for your domain
- Configures session settings for IONOS

### `clear-caches.php`
- Clears all Laravel cache files
- Removes compiled views
- Clears session files
- Sets proper file permissions

### `fix-csrf-sessions.php`
- Resolves 419 Page Expired errors
- Clears all session data
- Verifies/generates APP_KEY
- Updates session configuration

## ⚠️ Important Notes

1. **Run scripts in order** - Each script builds on the previous one
2. **Don't skip any scripts** - Each addresses a specific issue
3. **Clear browser cache** after running all scripts
4. **Test in incognito mode** if you still have issues

## 🐛 Common Issues Fixed

- ✅ 500 Internal Server Error
- ✅ ViteManifestNotFoundException
- ✅ 404 Not Found for routes
- ✅ 419 Page Expired (CSRF errors)
- ✅ "Path cannot be empty" errors
- ✅ Session and cookie issues
- ✅ URL rewriting problems

## 🧹 Cleanup

After everything is working, you can delete these fix scripts:
- `fix-vite-web.php`
- `fix-ionos-htaccess.php`
- `fix-bootstrap-routes.php`
- `fix-env-config.php`
- `clear-caches.php`
- `fix-csrf-sessions.php`
- `deployment-instructions.md`

## 📞 Support

If you still encounter issues after running all scripts:
1. Check the Laravel log: `storage/logs/laravel.log`
2. Verify your database connection in `.env`
3. Ensure all file permissions are correct (755 for directories, 644 for files)
4. Contact IONOS support if server-level issues persist
