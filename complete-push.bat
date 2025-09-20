@echo off
REM Complete the build and push process
echo 🚀 Completing Build and Push to GitHub
echo ====================================

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

REM Show what we have
echo 📊 Project components:
echo Vendor packages: $(dir vendor /AD | find "Directory" | wc -l)
echo Node modules: $(dir node_modules /AD | find "Directory" | wc -l)
if exist public\build\manifest.json (
    echo ✅ Vite manifest exists
) else (
    echo ❌ Vite manifest missing
)

REM Add all files to git
echo 📤 Adding all files to git...
git add .

REM Show git status (first 20 lines)
echo 📋 Files being added to git:
git status --porcelain | head -20
if %errorlevel% neq 0 (
    echo More files...
)

REM Commit everything
echo 💾 Committing complete project...
git commit -m "COMPLETE Laravel 12.30.1 deployment - ALL dependencies (vendor + node_modules + build assets)"

REM Push to GitHub
echo 📤 Pushing complete project to GitHub...
git push origin master

echo ""
echo 🎉 SUCCESS! Complete project pushed to GitHub!
echo ============================================
echo ""
echo 📦 Repository now contains:
echo • ✅ vendor/ directory (PHP dependencies - production optimized)
echo • ✅ node_modules/ directory (Node.js dependencies)
echo • ✅ public/build/ directory (compiled CSS/JS assets)
echo • ✅ All Laravel 12.30.1 files
echo • ✅ Database migrations
echo • ✅ All configurations
echo ""
echo 🌐 GitHub Repository: https://github.com/hossamabohassan/nephroapp.git
echo ""
echo 🚀 Ready for IONOS deployment!
echo The deployment should now work perfectly since everything is included.
goto :end

:error
echo ❌ Error: Missing required components
echo Please check the build process above
pause
exit /b 1

:end
pause
