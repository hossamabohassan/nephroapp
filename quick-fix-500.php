<?php
// Quick fix for 500 error
echo "<h2>🚀 Quick Fix for 500 Error</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ Quick Fix Approach</strong><br>";
echo "Let's fix the most common causes of 500 errors<br>";
echo "</div>";

// Step 1: Fix .env file
echo "<h3>Step 1: Fixing .env File</h3>";
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    // Update database settings
    $env_content = preg_replace('/DB_HOST=.*/', "DB_HOST=db5018653044.hosting-data.io", $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=dbs14780656", $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME=dbu1219527", $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD=0100421606@Nephroapp", $env_content);
    $env_content = preg_replace('/DB_PORT=.*/', "DB_PORT=3306", $env_content);
    
    // Set session driver to file
    $env_content = preg_replace('/SESSION_DRIVER=.*/', "SESSION_DRIVER=file", $env_content);
    if (strpos($env_content, 'SESSION_DRIVER=') === false) {
        $env_content .= "\nSESSION_DRIVER=file\n";
    }
    
    // Set app environment
    $env_content = preg_replace('/APP_ENV=.*/', "APP_ENV=production", $env_content);
    if (strpos($env_content, 'APP_ENV=') === false) {
        $env_content .= "\nAPP_ENV=production\n";
    }
    
    // Set debug mode
    $env_content = preg_replace('/APP_DEBUG=.*/', "APP_DEBUG=false", $env_content);
    if (strpos($env_content, 'APP_DEBUG=') === false) {
        $env_content .= "\nAPP_DEBUG=false\n";
    }
    
    file_put_contents('.env', $env_content);
    echo "✅ .env file updated<br>";
} else {
    echo "❌ .env file not found<br>";
}

// Step 2: Clear caches
echo "<h3>Step 2: Clearing Caches</h3>";
$cache_files = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/routes.php'
];

foreach ($cache_files as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "✅ Deleted: $file<br>";
        } else {
            echo "❌ Could not delete: $file<br>";
        }
    } else {
        echo "✅ No cached file: $file<br>";
    }
}

// Step 3: Fix permissions
echo "<h3>Step 3: Fixing Permissions</h3>";
$writable_dirs = [
    'storage',
    'storage/logs',
    'bootstrap/cache'
];

foreach ($writable_dirs as $dir) {
    if (file_exists($dir)) {
        if (chmod($dir, 0755)) {
            echo "✅ Set permissions for: $dir<br>";
        } else {
            echo "❌ Could not set permissions for: $dir<br>";
        }
    } else {
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created directory: $dir<br>";
        } else {
            echo "❌ Could not create directory: $dir<br>";
        }
    }
}

// Step 4: Test database connection
echo "<h3>Step 4: Testing Database Connection</h3>";
try {
    $pdo = new PDO(
        "mysql:host=db5018653044.hosting-data.io;port=3306;dbname=dbs14780656", 
        'dbu1219527', 
        '0100421606@Nephroapp'
    );
    echo "✅ Database connection works<br>";
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " tables<br>";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Test Your Site Now</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>Quick fixes applied!</strong></p>";
echo "<p>Try visiting your main site:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='debug-current-500.php'>🔍 Debug Again</a></li>";
echo "</ul>";
echo "</div>";
?>
