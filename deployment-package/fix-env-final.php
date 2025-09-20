<?php
// Fix the .env file with your exact IONOS database credentials
echo "<h2>🔧 Fixing .env File with IONOS Credentials</h2>";

// Your exact IONOS database credentials
$host = 'db5018653044.hosting-data.io';
$dbname = 'consultant2';
$username = 'dbu1219527';
$password = '0100421606@Nephroapp';
$port = 3306;

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>Updating .env file with these credentials:</strong><br>";
echo "DB_HOST: <code>$host</code><br>";
echo "DB_DATABASE: <code>$dbname</code><br>";
echo "DB_USERNAME: <code>$username</code><br>";
echo "DB_PASSWORD: <code>[HIDDEN]</code><br>";
echo "DB_PORT: <code>$port</code><br>";
echo "</div>";

// Read current .env file
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    // Update database settings
    $env_content = preg_replace('/DB_HOST=.*/', "DB_HOST=$host", $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$dbname", $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME=$username", $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD=$password", $env_content);
    $env_content = preg_replace('/DB_PORT=.*/', "DB_PORT=$port", $env_content);
    
    // Write back to .env
    file_put_contents('.env', $env_content);
    
    echo "✅ <strong>SUCCESS!</strong> .env file updated with correct IONOS database credentials<br>";
    echo "<br>";
    echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>🎉 Ready to Test!</h3>";
    echo "<p>Your .env file has been updated with the correct IONOS database credentials.</p>";
    echo "<p><strong>Now try visiting your main site:</strong></p>";
    echo "<ul>";
    echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Visit Main Site</a></li>";
    echo "<li><a href='db-test-final.php'>Test Database Connection Again</a></li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<hr>";
    echo "<h3>📋 What Should Happen Next:</h3>";
    echo "<ol>";
    echo "<li><strong>If database connection works:</strong> Your Laravel site should load normally</li>";
    echo "<li><strong>If you still get database errors:</strong> The IONOS database server might be down or restricted</li>";
    echo "<li><strong>If you get 'No tables found':</strong> You need to run Laravel migrations</li>";
    echo "</ol>";
    
} else {
    echo "❌ <strong>ERROR!</strong> .env file not found<br>";
    echo "<p>Please make sure you uploaded the .env file to your server.</p>";
    echo "<p>You can create one by copying from <code>env-template.txt</code> and renaming it to <code>.env</code></p>";
}
?>

