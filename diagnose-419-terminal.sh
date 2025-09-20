#!/bin/bash
# Diagnose Real Cause of 419 Page Expired (CSRF Disabled)
# Run this script on your IONOS server via SSH

echo "🔍 Diagnosing Real Cause of 419 Page Expired"
echo "============================================="
echo "CSRF is disabled but you still get 419 - let's find the real cause!"
echo ""

# Navigate to Laravel directory
cd ~/nephroapp

# 1. Check Laravel logs
echo "📋 Checking Laravel Logs..."
echo "=========================="
if [ -f "storage/logs/laravel.log" ]; then
    echo "Recent log entries:"
    tail -20 storage/logs/laravel.log
    echo ""
else
    echo "❌ Laravel log file not found"
    echo ""
fi

# 2. Check file permissions
echo "🔐 Checking File Permissions..."
echo "=============================="
directories=("storage" "storage/framework" "storage/framework/sessions" "storage/framework/cache" "storage/framework/views" "bootstrap/cache")

for dir in "${directories[@]}"; do
    if [ -d "$dir" ]; then
        perms=$(stat -c "%a" "$dir" 2>/dev/null || echo "unknown")
        writable=$(test -w "$dir" && echo "✅" || echo "❌")
        echo "$writable $dir: $perms"
    else
        echo "❌ $dir: Directory not found"
    fi
done
echo ""

# 3. Check environment configuration
echo "📄 Checking Environment Configuration..."
echo "======================================="
if [ -f ".env" ]; then
    echo "Key environment variables:"
    grep -E "^(APP_|SESSION_|DB_)" .env | head -10
    echo ""
else
    echo "❌ .env file not found"
    echo ""
fi

# 4. Test basic Laravel functionality
echo "🧪 Testing Basic Laravel Functionality..."
echo "========================================="
echo "Testing artisan commands:"
/usr/bin/php8.2-cli artisan --version 2>/dev/null && echo "✅ Artisan working" || echo "❌ Artisan not working"
echo ""

# 5. Check database connection
echo "🗄️ Testing Database Connection..."
echo "================================"
/usr/bin/php8.2-cli artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connection: OK';" 2>/dev/null && echo "✅ Database connection working" || echo "❌ Database connection failed"
echo ""

# 6. Check if routes are working
echo "🛣️ Testing Routes..."
echo "==================="
echo "Testing homepage:"
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/ | grep -q "200\|302" && echo "✅ Homepage accessible" || echo "❌ Homepage issue"

echo "Testing login page:"
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/login | grep -q "200\|302" && echo "✅ Login page accessible" || echo "❌ Login page issue"

echo "Testing direct Laravel:"
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/nephroapp/public/ | grep -q "200\|302" && echo "✅ Direct Laravel accessible" || echo "❌ Direct Laravel issue"
echo ""

# 7. Check for common issues
echo "🎯 Common 419 Causes Check..."
echo "============================"
echo "Possible causes (since CSRF is disabled):"
echo "1. Session Issues - Check if sessions are working"
echo "2. Form Method - Ensure forms use POST method"
echo "3. Route Issues - Check if routes are properly defined"
echo "4. Middleware Issues - Other middleware might be causing issues"
echo "5. Server Configuration - PHP or Apache configuration issues"
echo "6. File Permissions - Laravel can't write to storage directories"
echo "7. Database Issues - Database connection problems"
echo "8. Cache Issues - Corrupted cache files"
echo ""

# 8. Provide quick fixes
echo "🚀 Quick Fixes to Try..."
echo "======================="
echo "1. Clear all caches:"
echo "   /usr/bin/php8.2-cli artisan config:clear"
echo "   /usr/bin/php8.2-cli artisan route:clear"
echo "   /usr/bin/php8.2-cli artisan view:clear"
echo "   /usr/bin/php8.2-cli artisan cache:clear"
echo ""

echo "2. Fix file permissions:"
echo "   chmod -R 755 storage/"
echo "   chmod -R 755 bootstrap/cache/"
echo ""

echo "3. Check Laravel logs for specific errors:"
echo "   tail -f storage/logs/laravel.log"
echo ""

echo "4. Test form submission manually:"
echo "   curl -X POST http://nephroapp.com/login -d 'email=test@example.com&password=password'"
echo ""

echo "💡 The real error should be in the Laravel logs above!"
echo "Look for specific error messages that will tell us the exact cause."
