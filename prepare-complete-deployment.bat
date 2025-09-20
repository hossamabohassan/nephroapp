@echo off
REM Prepare Complete Laravel Project for GitHub Deployment
echo 🚀 Preparing COMPLETE Laravel Project for GitHub Deployment
echo ==========================================================
echo ⚠️  INCLUDING vendor, node_modules, and ALL files!

REM Make sure we're in the right directory
echo 📁 Current directory: %CD%

REM Clean any previous builds
echo 🧹 Cleaning previous builds...
if exist public\build rmdir /s /q public\build

REM Install ALL dependencies
echo 📦 Installing ALL NPM dependencies...
npm install

REM Build production assets
echo 🏗️ Building production assets...
npm run build

REM Install ALL PHP dependencies
echo 📦 Installing ALL PHP dependencies (including dev)...
composer install --optimize-autoloader

REM Create production env template
echo 📄 Creating production .env template...
copy .env .env.production.template

REM Clear Laravel caches
echo ⚡ Clearing Laravel caches...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

REM Show what will be included
echo.
echo 📋 What will be sent to GitHub:
echo ✅ /vendor (PHP dependencies)
echo ✅ /node_modules (Node.js dependencies) 
echo ✅ /public/build (Built assets)
echo ✅ All Laravel files
echo ✅ All custom files
echo ✅ Database migrations
echo ✅ Configuration files

REM Check file sizes
echo.
echo 📊 Checking important directories:
if exist vendor echo ✅ vendor directory exists
if exist node_modules echo ✅ node_modules directory exists
if exist public\build echo ✅ public/build directory exists

echo.
echo ✅ Project prepared for COMPLETE deployment!
echo.
echo 📋 Next steps:
echo 1. Run: git add .
echo 2. Run: git commit -m "Complete deployment with all dependencies"
echo 3. Run: git push origin main
echo 4. Deploy to IONOS server
echo.
echo ⚠️  Warning: This will be a large commit due to vendor and node_modules
echo.
pause
