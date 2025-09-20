<?php
// Regenerate APP_KEY for Laravel
echo "<h2>🔑 Regenerating APP_KEY</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ Regenerating Laravel APP_KEY</strong><br>";
echo "This will generate a new application key for your Laravel app<br>";
echo "</div>";

// Generate a new APP_KEY
$new_key = 'base64:' . base64_encode(random_bytes(32));

echo "<h3>🔑 New APP_KEY Generated</h3>";
echo "New key: <code>$new_key</code><br>";

// Update .env file
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    // Update or add APP_KEY
    if (strpos($env_content, 'APP_KEY=') !== false) {
        $env_content = preg_replace('/APP_KEY=.*/', "APP_KEY=$new_key", $env_content);
        echo "✅ Updated existing APP_KEY<br>";
    } else {
        $env_content .= "\nAPP_KEY=$new_key\n";
        echo "✅ Added new APP_KEY<br>";
    }
    
    file_put_contents('.env', $env_content);
    echo "✅ .env file updated with new APP_KEY<br>";
    
} else {
    echo "❌ .env file not found<br>";
}

// Clear caches
echo "<h3>🧹 Clearing Caches</h3>";
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

echo "<hr>";
echo "<h3>🎯 Test Your Site Now</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>APP_KEY regenerated and caches cleared!</strong></p>";
echo "<p>Try visiting your main site:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='debug-500.php'>Debug 500 Error Again</a></li>";
echo "</ul>";
echo "</div>";
?>

