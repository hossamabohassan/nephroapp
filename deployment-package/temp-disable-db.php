<?php
// Temporarily disable database features to test the site
echo "<h2>Temporarily Disabling Database Features</h2>";

// Read current .env file
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    
    // Replace database-related settings
    $env_content = str_replace('SESSION_DRIVER=database', 'SESSION_DRIVER=file', $env_content);
    $env_content = str_replace('CACHE_STORE=database', 'CACHE_STORE=file', $env_content);
    $env_content = str_replace('QUEUE_CONNECTION=database', 'QUEUE_CONNECTION=sync', $env_content);
    
    // Write back to .env
    file_put_contents('.env', $env_content);
    
    echo "✅ Database features temporarily disabled<br>";
    echo "SESSION_DRIVER changed to: file<br>";
    echo "CACHE_STORE changed to: file<br>";
    echo "QUEUE_CONNECTION changed to: sync<br>";
    echo "<br>";
    echo "Now try visiting your main site. It should work without database.<br>";
    echo "<br>";
    echo "<a href='index.php'>Visit Main Site</a><br>";
} else {
    echo "❌ .env file not found<br>";
}
?>
