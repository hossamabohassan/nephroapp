<?php
echo "PHP is working!<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current directory: " . getcwd() . "<br>";

// Test if we can access Laravel files
if (file_exists('vendor/autoload.php')) {
    echo "✅ vendor/autoload.php exists<br>";
} else {
    echo "❌ vendor/autoload.php NOT found<br>";
}

if (file_exists('bootstrap/app.php')) {
    echo "✅ bootstrap/app.php exists<br>";
} else {
    echo "❌ bootstrap/app.php NOT found<br>";
}

if (file_exists('.env')) {
    echo "✅ .env file exists<br>";
} else {
    echo "❌ .env file NOT found<br>";
}

if (file_exists('storage')) {
    echo "✅ storage directory exists<br>";
} else {
    echo "❌ storage directory NOT found<br>";
}

// Test file permissions
if (is_writable('storage')) {
    echo "✅ storage directory is writable<br>";
} else {
    echo "❌ storage directory is NOT writable<br>";
}

echo "<br>Directory listing:<br>";
$files = scandir('.');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "- " . $file . "<br>";
    }
}
?>
