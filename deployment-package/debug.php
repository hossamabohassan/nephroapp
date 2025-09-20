<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Laravel Debug Information</h2>";

// Test basic PHP
echo "<h3>1. PHP Information</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Directory: " . getcwd() . "<br>";

// Test file existence
echo "<h3>2. File Check</h3>";
$required_files = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    '.env',
    'artisan',
    'composer.json'
];

foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file MISSING<br>";
    }
}

// Test directories
echo "<h3>3. Directory Check</h3>";
$required_dirs = [
    'app',
    'bootstrap',
    'config',
    'storage',
    'vendor'
];

foreach ($required_dirs as $dir) {
    if (is_dir($dir)) {
        echo "✅ $dir directory exists<br>";
    } else {
        echo "❌ $dir directory MISSING<br>";
    }
}

// Test permissions
echo "<h3>4. Permission Check</h3>";
if (is_writable('storage')) {
    echo "✅ storage is writable<br>";
} else {
    echo "❌ storage is NOT writable<br>";
}

if (is_writable('bootstrap/cache')) {
    echo "✅ bootstrap/cache is writable<br>";
} else {
    echo "❌ bootstrap/cache is NOT writable<br>";
}

// Try to load Laravel
echo "<h3>5. Laravel Load Test</h3>";
try {
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        echo "✅ Composer autoloader loaded<br>";
        
        if (file_exists('bootstrap/app.php')) {
            $app = require_once 'bootstrap/app.php';
            echo "✅ Laravel app loaded<br>";
        } else {
            echo "❌ bootstrap/app.php not found<br>";
        }
    } else {
        echo "❌ vendor/autoload.php not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error loading Laravel: " . $e->getMessage() . "<br>";
}

// Show .env content (first few lines only)
echo "<h3>6. Environment Check</h3>";
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    $lines = explode("\n", $env_content);
    echo "First 5 lines of .env:<br>";
    for ($i = 0; $i < min(5, count($lines)); $i++) {
        echo htmlspecialchars($lines[$i]) . "<br>";
    }
} else {
    echo "❌ .env file not found<br>";
}
?>

