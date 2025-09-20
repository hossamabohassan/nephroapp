#!/bin/bash
# Fix Deployment Issues - Install Missing Dependencies and Resolve 500 Errors
# Run this script on your IONOS server via SSH

echo "🔧 Fixing Deployment Issues"
echo "==========================="

# Navigate to the project
cd ~/nephroapp

# Check current status
echo "🔍 Checking current status..."
echo "Current directory: $(pwd)"
echo "Laravel directory exists: $([ -d "." ] && echo "Yes" || echo "No")"

# Check what's missing
echo ""
echo "📋 Checking missing components..."
if [ -d "vendor" ]; then
    echo "✅ vendor directory exists"
else
    echo "❌ vendor directory missing - WILL INSTALL"
fi

if [ -d "bootstrap/cache" ]; then
    echo "✅ bootstrap/cache directory exists"
else
    echo "❌ bootstrap/cache directory missing - WILL CREATE"
fi

if [ -d "public/build" ]; then
    echo "✅ public/build directory exists"
else
    echo "❌ public/build directory missing - WILL CREATE"
fi

# Create missing directories
echo ""
echo "📁 Creating missing directories..."
mkdir -p bootstrap/cache
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p public/build/assets

echo "✅ Required directories created"

# Install vendor dependencies
echo ""
echo "📦 Installing vendor dependencies..."
/usr/bin/php8.2-cli /usr/bin/composer install --optimize-autoloader --no-dev

# Check if vendor was installed
if [ -d "vendor" ]; then
    echo "✅ vendor directory successfully installed"
else
    echo "❌ vendor installation failed"
fi

# Create basic manifest.json for Vite
echo ""
echo "🎨 Creating Vite assets..."
cat > public/build/manifest.json << 'EOF'
{
    "resources/css/app.css": {
        "file": "assets/app.css",
        "src": "resources/css/app.css",
        "isEntry": true
    },
    "resources/js/app.js": {
        "file": "assets/app.js",
        "src": "resources/js/app.js",
        "isEntry": true
    }
}
EOF

# Create basic CSS
cat > public/build/assets/app.css << 'EOF'
/* Basic styles for NephroApp */
body {
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
    color: #374151;
    background-color: #f9fafb;
}

.btn-primary {
    background-color: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-primary:hover {
    background-color: #2563eb;
}

.form-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}
EOF

# Create basic JavaScript
cat > public/build/assets/app.js << 'EOF'
// Basic JavaScript for NephroApp
console.log('NephroApp loaded successfully');

document.addEventListener('DOMContentLoaded', function() {
    // Handle form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type=submit]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processing...';
            }
        });
    });
});
EOF

# Set proper permissions
echo ""
echo "🔐 Setting proper permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/build/
chmod 644 .env
if [ -d "vendor" ]; then
    chmod -R 755 vendor/
fi

# Ensure APP_KEY is set
echo ""
echo "🔑 Ensuring APP_KEY is set..."
if ! grep -q "^APP_KEY=base64:" .env; then
    echo "Generating new APP_KEY..."
    /usr/bin/php8.2-cli artisan key:generate
else
    echo "✅ APP_KEY already set"
fi

# Clear all caches
echo ""
echo "🧹 Clearing all caches..."
rm -f bootstrap/cache/*
rm -f storage/framework/cache/*
rm -f storage/framework/sessions/*
rm -f storage/framework/views/*

# Run Laravel optimization
echo ""
echo "⚡ Optimizing Laravel..."
/usr/bin/php8.2-cli artisan config:clear
/usr/bin/php8.2-cli artisan route:clear
/usr/bin/php8.2-cli artisan view:clear
/usr/bin/php8.2-cli artisan cache:clear

# Test database connection
echo ""
echo "🗄️ Testing database connection..."
/usr/bin/php8.2-cli artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database connection: OK'; } catch(Exception \$e) { echo 'Database error: ' . \$e->getMessage(); }" 2>/dev/null

# Run migrations
echo ""
echo "🗄️ Running database migrations..."
/usr/bin/php8.2-cli artisan migrate --force

# Check Laravel version
echo ""
echo "🔍 Verifying Laravel..."
echo "Laravel Version: $(/usr/bin/php8.2-cli artisan --version)"

# Check for errors in logs
echo ""
echo "📋 Checking for recent errors..."
if [ -f "storage/logs/laravel.log" ]; then
    echo "Recent log entries:"
    tail -10 storage/logs/laravel.log
else
    echo "No log file found yet"
fi

# Test the application
echo ""
echo "🧪 Testing application..."
echo "Testing homepage..."
homepage_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/)
echo "Homepage response: $homepage_code"

echo "Testing login page..."
login_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/login)
echo "Login response: $login_code"

echo "Testing register page..."
register_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/register)
echo "Register response: $register_code"

echo ""
echo "🎯 Deployment Fix Summary"
echo "========================"
echo ""

# Summary of what was fixed
if [ -d "vendor" ]; then
    echo "✅ vendor directory: Fixed"
else
    echo "❌ vendor directory: Still missing"
fi

if [ -d "bootstrap/cache" ]; then
    echo "✅ bootstrap/cache: Fixed"
else
    echo "❌ bootstrap/cache: Still missing"
fi

if [ -d "public/build" ]; then
    echo "✅ public/build: Fixed"
else
    echo "❌ public/build: Still missing"
fi

echo ""
echo "🌐 Test your application:"
echo "• Homepage: http://nephroapp.com/ (Response: $homepage_code)"
echo "• Login: http://nephroapp.com/login (Response: $login_code)"
echo "• Register: http://nephroapp.com/register (Response: $register_code)"
echo ""

if [ "$homepage_code" = "200" ] || [ "$homepage_code" = "302" ]; then
    echo "🎉 SUCCESS! Your application should be working now!"
else
    echo "⚠️  Still having issues. Check the logs above for specific errors."
    echo ""
    echo "💡 Next steps if still not working:"
    echo "1. Check Laravel logs: tail -f storage/logs/laravel.log"
    echo "2. Verify database credentials in .env"
    echo "3. Check file permissions"
fi
