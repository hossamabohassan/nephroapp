<?php
// Force run Laravel migrations with detailed output
echo "<h2>🚀 Force Running Laravel Migrations</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ Database has 0 tables - migrations need to run</strong><br>";
echo "Let's force run the migrations to create all database tables<br>";
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
    
    // First, check if migrations table exists
    try {
        $pdo = new PDO(
            "mysql:host=db5018653044.hosting-data.io;port=3306;dbname=dbs14780656", 
            'dbu1219527', 
            '0100421606@Nephroapp'
        );
        
        $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
        $migrationsTable = $stmt->fetch();
        
        if ($migrationsTable) {
            echo "✅ Migrations table exists<br>";
        } else {
            echo "⚠️ Migrations table doesn't exist - will be created<br>";
        }
        
    } catch (PDOException $e) {
        echo "❌ Could not check migrations table: " . $e->getMessage() . "<br>";
    }
    
    // Run migrations with verbose output
    try {
        echo "🔄 Running migrations...<br>";
        
        // Try to run migrations
        $exitCode = $app['Illuminate\Contracts\Console\Kernel']->call('migrate', [
            '--force' => true,
            '--verbose' => true
        ]);
        
        echo "✅ <strong>SUCCESS!</strong> Migrations completed!<br>";
        echo "Exit code: $exitCode<br>";
        
    } catch (Exception $e) {
        echo "❌ Migration failed: " . $e->getMessage() . "<br>";
        echo "Error details: " . $e->getTraceAsString() . "<br>";
    }
    
    // Check what tables were created
    echo "<h3>🔍 Checking Database Tables After Migration</h3>";
    try {
        $pdo = new PDO(
            "mysql:host=db5018653044.hosting-data.io;port=3306;dbname=dbs14780656", 
            'dbu1219527', 
            '0100421606@Nephroapp'
        );
        
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "✅ <strong>SUCCESS!</strong> Found " . count($tables) . " tables in database:<br>";
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li><code>$table</code></li>";
            }
            echo "</ul>";
        } else {
            echo "❌ Still no tables found. Migration may have failed.<br>";
        }
        
    } catch (PDOException $e) {
        echo "❌ Could not check tables: " . $e->getMessage() . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Laravel app loading failed: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Next Steps</h3>";

if (count($tables) > 0) {
    echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>🎉 SUCCESS! Migrations Completed!</h4>";
    echo "<p>Your Laravel app is now fully ready!</p>";
    echo "<p><strong>Test your site:</strong></p>";
    echo "<ul>";
    echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
    echo "<li><a href='topics' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📚 Topics Page</a></li>";
    echo "<li><a href='admin/landing-page' style='background: #ffc107; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>⚙️ Admin Panel</a></li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div style='background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>❌ Migrations Failed</h4>";
    echo "<p>Migrations didn't create any tables. Let's try alternative approaches:</p>";
    echo "<ul>";
    echo "<li><a href='create-tables-manually.php'>Create Tables Manually</a></li>";
    echo "<li><a href='disable-database-features.php'>Disable Database Features</a></li>";
    echo "<li><a href='final-verification.php'>Check Current Status</a></li>";
    echo "</ul>";
    echo "</div>";
}
?>
