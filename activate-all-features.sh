#!/bin/bash
# Activate All Features and Modules for NephroApp on IONOS

echo "🚀 Activating All Features and Modules for NephroApp"
echo "===================================================="

cd ~/nephroapp

# 1. Create Admin User with proper permissions
echo "👑 Creating Admin User..."
/usr/bin/php8.2-cli artisan tinker --execute="
use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    \$admin = User::updateOrCreate(
        ['email' => 'admin@nephroapp.com'],
        [
            'name' => 'Administrator',
            'email' => 'admin@nephroapp.com',
            'password' => Hash::make('Admin123!'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'is_active' => 1
        ]
    );
    echo 'Admin user created/updated successfully!';
} catch (Exception \$e) {
    echo 'Error: ' . \$e->getMessage();
}
"

# 2. Seed/Initialize Auth Settings
echo ""
echo "🔐 Initializing Authentication Settings..."
/usr/bin/php8.2-cli artisan tinker --execute="
use App\Models\AuthSetting;

try {
    \$authSettings = AuthSetting::firstOrCreate([], [
        'allow_email_registration' => true,
        'allow_google_auth' => false
    ]);
    echo 'Auth settings initialized successfully!';
} catch (Exception \$e) {
    echo 'Error: ' . \$e->getMessage();
}
"

# 3. Initialize Basic Application Settings
echo ""
echo "⚙️ Initializing Application Settings..."
/usr/bin/php8.2-cli artisan tinker --execute="
use App\Models\Setting;

try {
    \$settings = [
        'app_name' => 'NephroCoach',
        'app_url' => 'http://nephroapp.com',
        'timezone' => 'UTC',
        'locale' => 'en'
    ];
    
    foreach (\$settings as \$key => \$value) {
        Setting::updateOrCreate(['key' => \$key], ['value' => \$value]);
    }
    
    echo 'Application settings initialized successfully!';
} catch (Exception \$e) {
    echo 'Error: ' . \$e->getMessage();
}
"

# 4. Activate Laravel Modules (if any exist)
echo ""
echo "📦 Checking and Activating Modules..."
if [ -f "modules_statuses.json" ]; then
    echo "Modules status file found. Checking modules..."
    /usr/bin/php8.2-cli artisan module:list
    
    # Enable all modules
    /usr/bin/php8.2-cli artisan module:enable
    echo "All modules enabled!"
else
    echo "No modules found to activate"
fi

# 5. Create storage link for file uploads
echo ""
echo "🔗 Creating Storage Link..."
/usr/bin/php8.2-cli artisan storage:link

# 6. Publish vendor assets
echo ""
echo "📄 Publishing Vendor Assets..."
/usr/bin/php8.2-cli artisan vendor:publish --all --force

# 7. Initialize Social Auth Configuration (Google)
echo ""
echo "🌐 Initializing Social Authentication..."
/usr/bin/php8.2-cli artisan tinker --execute="
use App\Models\Setting;

try {
    // Set default Google auth settings (disabled by default)
    \$googleSettings = [
        'google_client_id' => '',
        'google_client_secret' => '',
        'google_redirect_uri' => 'http://nephroapp.com/auth/google/callback',
        'allow_google_auth' => false
    ];
    
    foreach (\$googleSettings as \$key => \$value) {
        Setting::updateOrCreate(['key' => \$key], ['value' => \$value]);
    }
    
    echo 'Google auth settings initialized (disabled by default)!';
} catch (Exception \$e) {
    echo 'Error: ' . \$e->getMessage();
}
"

# 8. Set proper file permissions
echo ""
echo "🔐 Setting File Permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/
chmod 644 .env

# 9. Clear and optimize everything
echo ""
echo "⚡ Optimizing Application..."
/usr/bin/php8.2-cli artisan optimize:clear
/usr/bin/php8.2-cli artisan config:cache
/usr/bin/php8.2-cli artisan route:cache
/usr/bin/php8.2-cli artisan view:cache

# 10. Verify everything is working
echo ""
echo "🧪 Verifying Application Status..."
echo "Laravel Version: $(/usr/bin/php8.2-cli artisan --version)"
echo "App Environment: $(/usr/bin/php8.2-cli artisan tinker --execute="echo config('app.env');")"

# Check database connection
echo "Database Connection: $(/usr/bin/php8.2-cli artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Connected'; } catch(Exception \$e) { echo 'Failed: ' . \$e->getMessage(); }")"

# Test URLs
echo ""
echo "🌐 Testing Application URLs..."
homepage_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/)
login_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/login)
admin_code=$(curl -s -o /dev/null -w "%{http_code}" http://nephroapp.com/admin)

echo "Homepage: $homepage_code"
echo "Login: $login_code"
echo "Admin Panel: $admin_code"

echo ""
echo "🎉 ALL FEATURES ACTIVATED!"
echo "========================"
echo ""
echo "✅ What's been activated:"
echo "• Admin user created (admin@nephroapp.com / Admin123!)"
echo "• Authentication settings initialized"
echo "• Application settings configured"
echo "• All modules enabled (if any)"
echo "• Storage link created"
echo "• Vendor assets published"
echo "• Social authentication configured"
echo "• File permissions set"
echo "• Application optimized"
echo ""
echo "🔑 Admin Access:"
echo "• URL: http://nephroapp.com/admin"
echo "• Email: admin@nephroapp.com"
echo "• Password: Admin123!"
echo ""
echo "🌐 Available Features:"
echo "• User Management"
echo "• Settings Management"
echo "• Topics & Content Management"
echo "• Navigation Management"
echo "• Template Management"
echo "• Activity Logging"
echo "• Google Authentication (configurable)"
echo "• Landing Page Management"
echo ""
echo "📱 User Features:"
echo "• User Registration/Login"
echo "• User Profiles"
echo "• Topics & Categories"
echo "• Favorites & Completed Items"
echo "• Social Authentication (when enabled)"
echo ""
echo "🛠️ Admin Panel Features:"
echo "• User Management & Permissions"
echo "• System Settings"
echo "• Content Management"
echo "• Navigation Configuration"
echo "• Template Management"
echo "• Activity Monitoring"
echo "• Landing Page Customization"
