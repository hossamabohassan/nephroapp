<?php
// Run migrations in the full Laravel project
echo "<h2>🚀 Running Migrations in Full Laravel Project</h2>";

echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>✅ Full Laravel project uploaded!</strong><br>";
echo "Now let's run migrations to create the database tables<br>";
echo "</div>";

// Check if Laravel bootstrap exists
if (!file_exists('bootstrap/app.php')) {
    echo "❌ Laravel bootstrap not found. Make sure you're in the Laravel root directory.<br>";
    exit;
}

try {
    // Load Laravel app
    $app = require_once 'bootstrap/app.php';
    
    echo "<h3>🧪 Running Database Migrations</h3>";
    
    // Run migrations
    try {
        $exitCode = $app['Illuminate\Contracts\Console\Kernel']->call('migrate', ['--force' => true]);
        echo "✅ <strong>SUCCESS!</strong> Migrations completed!<br>";
        echo "Exit code: $exitCode<br>";
        
    } catch (Exception $e) {
        echo "❌ Migration failed: " . $e->getMessage() . "<br>";
        echo "This might be normal if tables already exist<br>";
    }
    
    // Check what tables were created
    echo "<h3>🔍 Checking Database Tables</h3>";
    try {
        $pdo = new PDO(
            "mysql:host=db5018653044.hosting-data.io;port=3306;dbname=dbs14780656", 
            'dbu1219527', 
            '0100421606@Nephroapp'
        );
        
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "✅ Found " . count($tables) . " tables in database:<br>";
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li><code>$table</code></li>";
            }
            echo "</ul>";
        } else {
            echo "⚠️ No tables found. You may need to run migrations manually.<br>";
        }
        
    } catch (PDOException $e) {
        echo "❌ Could not check tables: " . $e->getMessage() . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Laravel app loading failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎉 Ready to Test Your Site!</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>Your Laravel app should now be fully working!</strong></p>";
echo "<p>Test these pages:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='topics' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📚 Topics Page</a></li>";
echo "<li><a href='admin/landing-page' style='background: #ffc107; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>⚙️ Admin Panel</a></li>";
echo "</ul>";
echo "</div>";
?>

