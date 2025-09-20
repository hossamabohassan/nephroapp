@echo off
REM Build all assets and push complete project to GitHub
echo 🚀 Building Complete Project for GitHub Push
echo =============================================

REM Build production assets
echo 📦 Building production assets...
npm run build

REM Check if vendor exists
echo 🔍 Checking dependencies...
if exist vendor (
    echo ✅ vendor directory exists
) else (
    echo ❌ vendor directory missing - run composer install first
    pause
    exit /b 1
)

if exist public\build (
    echo ✅ public/build directory exists
) else (
    echo ❌ public/build directory missing - build failed
    pause
    exit /b 1
)

if exist node_modules (
    echo ✅ node_modules directory exists
) else (
    echo ❌ node_modules directory missing
    pause
    exit /b 1
)

REM Add all files to git
echo 📤 Adding all files to git...
git add .

REM Show what will be committed
echo 📋 Files to be committed:
git status --porcelain | head -20
echo ...and more files

REM Commit with complete dependencies
echo 💾 Committing complete project...
git commit -m "Complete Laravel 12.30.1 deployment with ALL dependencies (vendor + node_modules + build)"

REM Push to GitHub
echo 📤 Pushing to GitHub...
git push origin master

echo ✅ Complete project pushed to GitHub!
echo.
echo 📊 What was pushed:
echo • vendor/ directory (PHP dependencies)
echo • node_modules/ directory (Node.js dependencies)
echo • public/build/ directory (Built assets)
echo • All Laravel application files
echo.
echo 🚀 Ready for IONOS deployment!
pause
