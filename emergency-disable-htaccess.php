<?php
// Emergency disable .htaccess
echo "<h2>🚨 Emergency Disable .htaccess</h2>";

echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>🚨 EMERGENCY FIX</strong><br>";
echo "All links are giving 500 errors because .htaccess is still active<br>";
echo "Let's disable it completely<br>";
echo "</div>";

// Check if .htaccess exists
if (file_exists('.htaccess')) {
    // Try to rename .htaccess to .htaccess.disabled
    if (rename('.htaccess', '.htaccess.disabled')) {
        echo "✅ <strong>SUCCESS!</strong> .htaccess file disabled<br>";
        echo "✅ Renamed .htaccess to .htaccess.disabled<br>";
        
        echo "<br>";
        echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>🎯 .htaccess Disabled!</h3>";
        echo "<p><strong>The .htaccess file has been disabled!</strong></p>";
        echo "<p>Now try visiting your main site:</p>";
        echo "<ul>";
        echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
        echo "<li><a href='debug-current-500.php'>🔍 Debug 500 Error</a></li>";
        echo "</ul>";
        echo "</div>";
        
    } else {
        echo "❌ Could not rename .htaccess file<br>";
        echo "You may not have permission to modify the file<br>";
        
        echo "<br>";
        echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>🔧 Manual Solution</h3>";
        echo "<p>If you can't rename the file automatically, you need to:</p>";
        echo "<ol>";
        echo "<li><strong>Go to your IONOS file manager</strong></li>";
        echo "<li><strong>Find the .htaccess file</strong></li>";
        echo "<li><strong>Delete it or rename it to .htaccess.disabled</strong></li>";
        echo "<li><strong>Then visit your main site</strong></li>";
        echo "</ol>";
        echo "</div>";
    }
} else {
    echo "⚠️ .htaccess file not found<br>";
    echo "The 500 error might be caused by something else<br>";
}

echo "<hr>";
echo "<h3>🔧 What to Do Next</h3>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>After disabling .htaccess:</h4>";
echo "<ol>";
echo "<li><strong>Test your main site:</strong> Visit index.php</li>";
echo "<li><strong>If it works:</strong> Your Laravel app is working without URL rewriting</li>";
echo "<li><strong>If it still fails:</strong> The problem is not .htaccess</li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<h4>⚠️ Running Without .htaccess:</h4>";
echo "<p>Without .htaccess, you'll need to access pages like this:</p>";
echo "<ul>";
echo "<li>Main site: <code>index.php</code></li>";
echo "<li>Topics: <code>index.php?page=topics</code></li>";
echo "<li>Admin: <code>index.php?page=admin</code></li>";
echo "</ul>";
echo "<p>This is not ideal, but it will get your site working!</p>";
echo "</div>";
?>
