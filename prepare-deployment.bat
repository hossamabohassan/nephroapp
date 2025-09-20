@echo off
REM Prepare Laravel Project for Fresh Deployment
echo 🚀 Preparing Laravel Project for Fresh Deployment
echo ================================================

REM Clean up development files
echo 🧹 Cleaning up development files...
if exist node_modules rmdir /s /q node_modules
if exist vendor rmdir /s /q vendor
if exist public\build rmdir /s /q public\build

REM Clean bootstrap cache
echo 🗑️ Cleaning bootstrap cache...
if exist bootstrap\cache del /q bootstrap\cache\*

REM Clean storage cache
echo 🗑️ Cleaning storage cache...
if exist storage\framework\cache del /q storage\framework\cache\*
if exist storage\framework\sessions del /q storage\framework\sessions\*
if exist storage\framework\views del /q storage\framework\views\*
if exist storage\logs del /q storage\logs\*

REM Create production env template
echo 📄 Creating production .env template...
copy .env .env.production.template

REM Install fresh dependencies
echo 📦 Installing fresh NPM dependencies...
npm install

REM Build production assets
echo 🏗️ Building production assets...
npm run build

REM Install PHP dependencies for production
echo 📦 Installing PHP dependencies...
composer install --optimize-autoloader --no-dev

REM Clear and optimize Laravel
echo ⚡ Optimizing Laravel...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo ✅ Project prepared for deployment!
echo.
echo 📋 Next steps:
echo 1. Commit and push to GitHub
echo 2. Deploy to IONOS server
echo 3. Configure environment on server
echo.
pause
