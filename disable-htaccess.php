<?php
// Disable .htaccess temporarily to test
echo "<h2>🔧 Disabling .htaccess Temporarily</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ Temporary Solution</strong><br>";
echo "This will rename .htaccess to .htaccess.disabled to test if it's causing the 500 error<br>";
echo "</div>";

// Check if .htaccess exists
if (file_exists('.htaccess')) {
    // Rename .htaccess to .htaccess.disabled
    if (rename('.htaccess', '.htaccess.disabled')) {
        echo "✅ <strong>SUCCESS!</strong> .htaccess file disabled<br>";
        echo "✅ Renamed .htaccess to .htaccess.disabled<br>";
        
        echo "<br>";
        echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>🎯 Test Your Site Now</h3>";
        echo "<p><strong>.htaccess file disabled!</strong></p>";
        echo "<p>Try visiting your main site:</p>";
        echo "<ul>";
        echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
        echo "<li><a href='debug-current-500.php'>🔍 Debug Again</a></li>";
        echo "</ul>";
        echo "</div>";
        
        echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h4>📝 What This Does:</h4>";
        echo "<ul>";
        echo "<li>Disables .htaccess file by renaming it</li>";
        echo "<li>Tests if .htaccess was causing the 500 error</li>";
        echo "<li>Allows you to access your site without URL rewriting</li>";
        echo "</ul>";
        echo "</div>";
        
    } else {
        echo "❌ Could not rename .htaccess file<br>";
        echo "You may not have permission to modify the file<br>";
    }
} else {
    echo "⚠️ .htaccess file not found<br>";
    echo "The 500 error might be caused by something else<br>";
}

echo "<hr>";
echo "<h3>🔧 If Site Works Without .htaccess</h3>";
echo "<p>If your site works after disabling .htaccess, then the .htaccess file was the problem.</p>";
echo "<p>You can then:</p>";
echo "<ul>";
echo "<li><a href='create-simple-htaccess.php'>Create a simple .htaccess file</a></li>";
echo "<li><a href='fix-htaccess.php'>Fix the original .htaccess file</a></li>";
echo "</ul>";

echo "<h3>🔧 If Site Still Doesn't Work</h3>";
echo "<p>If your site still shows 500 error, then .htaccess wasn't the problem.</p>";
echo "<p>You can then:</p>";
echo "<ul>";
echo "<li><a href='debug-current-500.php'>Debug the 500 error again</a></li>";
echo "<li><a href='check-vendor-directory.php'>Check vendor directory</a></li>";
echo "</ul>";
?>
