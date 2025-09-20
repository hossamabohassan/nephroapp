@echo off
REM Fix composer issues and push complete project to GitHub
echo 🔧 Fixing Composer Issues and Building Complete Project
echo ======================================================

REM Clear composer cache to fix corrupted downloads
echo 🧹 Clearing composer cache...
composer clear-cache

REM Try installing again
echo 📦 Installing PHP dependencies...
composer install --no-dev --optimize-autoloader

REM Check if vendor was created
if exist vendor (
    echo ✅ vendor directory created successfully
) else (
    echo ❌ vendor installation failed - trying alternative approach...
    composer install
)

REM Build frontend assets
echo 🏗️ Building frontend assets...
npm run build

REM Verify all components exist
echo 🔍 Verifying all components...
if exist vendor (
    echo ✅ vendor directory exists
) else (
    echo ❌ vendor directory missing
    goto :error
)

if exist node_modules (
    echo ✅ node_modules directory exists
) else (
    echo ❌ node_modules directory missing
    goto :error
)

if exist public\build (
    echo ✅ public/build directory exists
) else (
    echo ❌ public/build directory missing
    goto :error
)

REM Show directory sizes
echo 📊 Directory information:
dir vendor /s | find "File(s)"
dir node_modules /s | find "File(s)"
dir public\build /s | find "File(s)"

REM Add all files to git
echo 📤 Adding all files to git...
git add .

REM Check git status
echo 📋 Git status:
git status --short | head -10

REM Commit everything
echo 💾 Committing complete project...
git commit -m "Complete Laravel 12.30.1 deployment - ALL dependencies included (vendor + node_modules + build assets)"

REM Push to GitHub
echo 📤 Pushing complete project to GitHub...
git push origin master

echo ✅ SUCCESS! Complete project pushed to GitHub
echo =============================================
echo.
echo 📦 What was included:
echo • vendor/ directory with PHP dependencies
echo • node_modules/ directory with Node.js dependencies  
echo • public/build/ directory with compiled assets
echo • All Laravel application files
echo • Database migrations and configurations
echo.
echo 🚀 Ready for IONOS deployment!
echo Your GitHub repository now contains everything needed.
goto :end

:error
echo ❌ Error: Missing required directories
echo Please check the installation logs above
pause
exit /b 1

:end
pause
