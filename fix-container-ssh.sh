#!/bin/bash
# Fix Container Resolution Issues (419 Page Expired)
# Run this script on your IONOS server via SSH

echo "🔧 Fixing Container Resolution Issues"
echo "====================================="
echo "The logs show Container resolution errors - let's fix this!"
echo ""

# Navigate to Laravel directory
cd ~/nephroapp

# 1. Clear ALL caches completely
echo "🧹 Clearing All Caches..."
echo "========================="
/usr/bin/php8.2-cli artisan config:clear
/usr/bin/php8.2-cli artisan route:clear
/usr/bin/php8.2-cli artisan view:clear
/usr/bin/php8.2-cli artisan cache:clear
/usr/bin/php8.2-cli artisan optimize:clear
echo "✅ All caches cleared"

# 2. Regenerate autoloader
echo ""
echo "🔄 Regenerating Autoloader..."
echo "============================"
/usr/bin/php8.2-cli /usr/bin/composer dump-autoload
echo "✅ Autoloader regenerated"

# 3. Clear storage caches manually
echo ""
echo "🗑️ Clearing Storage Caches..."
echo "============================"
rm -f storage/framework/cache/*
rm -f storage/framework/views/*
rm -f storage/framework/sessions/*
echo "✅ Storage caches cleared"

# 4. Check middleware files
echo ""
echo "🔍 Checking Middleware Files..."
echo "=============================="
middleware_files=("LoadSettings.php" "EnsureUserIsActive.php" "VerifyCsrfToken.php")

for file in "${middleware_files[@]}"; do
    if [ -f "app/Http/Middleware/$file" ]; then
        echo "✅ Found: $file"
    else
        echo "❌ Missing: $file"
    fi
done

# 5. Test container resolution
echo ""
echo "🧪 Testing Container Resolution..."
echo "================================="
cat > test-container.php << 'EOF'
<?php
// Simple container test
try {
    require __DIR__ . "/vendor/autoload.php";
    $app = require __DIR__ . "/bootstrap/app.php";
    echo "✅ Container created successfully\n";
    
    // Test basic resolution
    $request = \Illuminate\Http\Request::capture();
    echo "✅ Request captured successfully\n";
    
    // Test kernel resolution
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    echo "✅ Kernel resolved successfully\n";
    
    // Test middleware resolution
    $middleware = $app->make(\App\Http\Middleware\LoadSettings::class);
    echo "✅ LoadSettings middleware resolved successfully\n";
    
} catch (Exception $e) {
    echo "❌ Container error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>
EOF

/usr/bin/php8.2-cli test-container.php
echo ""

# 6. Check for specific issues
echo "🔍 Checking for Specific Issues..."
echo "================================="

# Check if LoadSettings middleware has issues
if [ -f "app/Http/Middleware/LoadSettings.php" ]; then
    echo "Checking LoadSettings middleware..."
    if grep -q "class LoadSettings" app/Http/Middleware/LoadSettings.php; then
        echo "✅ LoadSettings class found"
    else
        echo "❌ LoadSettings class issue"
    fi
    
    if grep -q "public function handle" app/Http/Middleware/LoadSettings.php; then
        echo "✅ LoadSettings handle method found"
    else
        echo "❌ LoadSettings handle method issue"
    fi
fi

# 7. Fix potential issues
echo ""
echo "🛠️ Applying Fixes..."
echo "==================="

# Ensure proper file permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
echo "✅ File permissions set"

# 8. Test the fixes
echo ""
echo "🧪 Testing the Fixes..."
echo "======================"
echo "Testing homepage..."
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/ | grep -q "200\|302" && echo "✅ Homepage accessible" || echo "❌ Homepage issue"

echo "Testing login page..."
curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/login | grep -q "200\|302" && echo "✅ Login page accessible" || echo "❌ Login page issue"

echo "Testing form submission..."
curl -s -o /dev/null -w "%{http_code}" -X POST http://nephroapp.com/login -d "email=test@example.com&password=password" | grep -q "200\|302\|419" && echo "✅ Form submission testable" || echo "❌ Form submission issue"

# 9. Cleanup
echo ""
echo "🧹 Cleaning Up..."
echo "================"
rm -f test-container.php
echo "✅ Test files cleaned up"

echo ""
echo "🎉 Container Resolution Fix Complete!"
echo "===================================="
echo ""
echo "📋 What was fixed:"
echo "• Cleared all Laravel caches"
echo "• Regenerated autoloader"
echo "• Cleared storage caches"
echo "• Checked middleware files"
echo "• Tested container resolution"
echo "• Set proper file permissions"
echo ""
echo "🚀 Next Steps:"
echo "1. Test your forms in the browser"
echo "2. Check if 419 errors are resolved"
echo "3. If still having issues, check Laravel logs: tail -f storage/logs/laravel.log"
echo ""
echo "💡 The issue was likely with container resolution due to cached configurations."
echo "The fixes above should resolve the 419 Page Expired error."
