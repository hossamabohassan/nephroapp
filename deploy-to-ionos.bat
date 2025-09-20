@echo off
echo ========================================
echo Laravel Deployment to IONOS Hosting
echo ========================================
echo.

echo Step 1: Optimizing Laravel for production...
call composer install --optimize-autoloader --no-dev
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

echo.
echo Step 2: Creating deployment package...
if exist "deployment-package" rmdir /s /q "deployment-package"
mkdir "deployment-package"

echo Copying files to deployment package...
xcopy "app" "deployment-package\app" /E /I /Y
xcopy "bootstrap" "deployment-package\bootstrap" /E /I /Y
xcopy "config" "deployment-package\config" /E /I /Y
xcopy "database" "deployment-package\database" /E /I /Y
xcopy "public" "deployment-package\public_html" /E /I /Y
xcopy "resources" "deployment-package\resources" /E /I /Y
xcopy "routes" "deployment-package\routes" /E /I /Y
xcopy "storage" "deployment-package\storage" /E /I /Y
xcopy "vendor" "deployment-package\vendor" /E /I /Y
copy "artisan" "deployment-package\"
copy "composer.json" "deployment-package\"
copy "composer.lock" "deployment-package\"

echo.
echo Step 3: Creating production .env template...
echo APP_NAME="NephroCoach" > "deployment-package\.env.template"
echo APP_ENV=production >> "deployment-package\.env.template"
echo APP_KEY=base64:YOUR_APP_KEY_HERE >> "deployment-package\.env.template"
echo APP_DEBUG=false >> "deployment-package\.env.template"
echo APP_TIMEZONE=UTC >> "deployment-package\.env.template"
echo APP_URL=https://yourdomain.com >> "deployment-package\.env.template"
echo. >> "deployment-package\.env.template"
echo DB_CONNECTION=mysql >> "deployment-package\.env.template"
echo DB_HOST=localhost >> "deployment-package\.env.template"
echo DB_PORT=3306 >> "deployment-package\.env.template"
echo DB_DATABASE=your_database_name >> "deployment-package\.env.template"
echo DB_USERNAME=your_database_username >> "deployment-package\.env.template"
echo DB_PASSWORD=your_database_password >> "deployment-package\.env.template"
echo. >> "deployment-package\.env.template"
echo SESSION_DRIVER=database >> "deployment-package\.env.template"
echo CACHE_STORE=database >> "deployment-package\.env.template"
echo QUEUE_CONNECTION=database >> "deployment-package\.env.template"
echo LOG_CHANNEL=stack >> "deployment-package\.env.template"
echo LOG_LEVEL=error >> "deployment-package\.env.template"

echo.
echo Step 4: Creating .htaccess for shared hosting...
echo ^<IfModule mod_rewrite.c^> > "deployment-package\.htaccess"
echo     RewriteEngine On >> "deployment-package\.htaccess"
echo     RewriteRule ^^(.*^)$ public_html/$1 [L] >> "deployment-package\.htaccess"
echo ^</IfModule^> >> "deployment-package\.htaccess"

echo.
echo ========================================
echo Deployment package created successfully!
echo ========================================
echo.
echo Next steps:
echo 1. Upload the contents of 'deployment-package' folder to your IONOS hosting
echo 2. Rename .env.template to .env and configure with your database details
echo 3. Run: php artisan key:generate
echo 4. Run: php artisan migrate --force
echo 5. Set proper permissions on storage/ and bootstrap/cache/ directories
echo.
echo See DEPLOYMENT_GUIDE.md for detailed instructions.
echo.
pause
