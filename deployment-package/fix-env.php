<?php
// Fix the .env file with correct IONOS database credentials
echo "<h2>Fixing .env File with IONOS Credentials</h2>";

// Your actual IONOS database credentials
$host = 'db5018653044.hosting-data.io';
$dbname = 'consultant2';
$username = 'dbu1219527';
$password = '0100421606@Nephroapp';

// Read current .env file
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    // Update database settings
    $env_content = preg_replace('/DB_HOST=.*/', "DB_HOST=$host", $env_content);
    $env_content = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$dbname", $env_content);
    $env_content = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME=$username", $env_content);
    $env_content = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD=$password", $env_content);
    
    // Write back to .env
    file_put_contents('.env', $env_content);
    
    echo "✅ .env file updated with correct IONOS database credentials<br>";
    echo "DB_HOST: $host<br>";
    echo "DB_DATABASE: $dbname<br>";
    echo "DB_USERNAME: $username<br>";
    echo "DB_PASSWORD: [HIDDEN]<br>";
    echo "<br>";
    echo "Now try visiting your main site. The database connection should work!<br>";
    echo "<br>";
    echo "<a href='index.php'>Visit Main Site</a><br>";
    echo "<a href='db-test-corrected.php'>Test Database Connection</a><br>";
} else {
    echo "❌ .env file not found<br>";
}
?>

