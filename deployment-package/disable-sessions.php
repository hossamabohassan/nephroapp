<?php
// Temporarily disable database sessions to get site working
echo "<h2>🔧 Temporarily Disable Database Sessions</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ Temporary Solution:</strong><br>";
echo "This will change Laravel to use file-based sessions instead of database sessions<br>";
echo "This will get your site working while we fix the database connection<br>";
echo "</div>";

// Read current .env file
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    // Change session driver from database to file
    $env_content = preg_replace('/SESSION_DRIVER=.*/', "SESSION_DRIVER=file", $env_content);
    
    // If SESSION_DRIVER doesn't exist, add it
    if (strpos($env_content, 'SESSION_DRIVER') === false) {
        $env_content .= "\nSESSION_DRIVER=file\n";
    }
    
    file_put_contents('.env', $env_content);
    
    echo "✅ Session driver changed to 'file'<br>";
    echo "✅ This will prevent database session errors<br>";
    
} else {
    echo "❌ .env file not found<br>";
}

// Delete cached config files
echo "<h3>Deleting Cached Config Files</h3>";
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
echo "<p><strong>Sessions disabled, caches cleared!</strong></p>";
echo "<p>Your site should now work without database session errors:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='emergency-fix.php'>Run Emergency Fix</a></li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>📝 What This Does:</h4>";
echo "<ul>";
echo "<li>Changes SESSION_DRIVER from 'database' to 'file'</li>";
echo "<li>Deletes all cached configuration files</li>";
echo "<li>Forces Laravel to reload configuration</li>";
echo "<li>Prevents database session connection errors</li>";
echo "</ul>";
echo "</div>";
?>

