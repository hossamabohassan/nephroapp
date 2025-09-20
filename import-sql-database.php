<?php
/**
 * Import SQL Database File to Production
 * This script imports a SQL file exported from phpMyAdmin to your production database
 */

require_once 'vendor/autoload.php';

// Load your production .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration for production
$host = $_ENV['DB_HOST'] ?? 'localhost';
$database = $_ENV['DB_DATABASE'] ?? 'nephroapp';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

// SQL file to import (change this to your exported file name)
$sqlFile = 'consultant_export.sql';

if (!file_exists($sqlFile)) {
    echo "❌ SQL file not found: $sqlFile\n";
    echo "💡 Please upload your exported SQL file to this directory first\n";
    echo "📁 Expected file: $sqlFile\n";
    exit(1);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to production database: $database\n";
    
    // Read SQL file
    $sql = file_get_contents($sqlFile);
    
    if (!$sql) {
        echo "❌ Failed to read SQL file\n";
        exit(1);
    }
    
    echo "📦 SQL file size: " . number_format(strlen($sql)) . " bytes\n";
    
    // Disable foreign key checks temporarily
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");
    $pdo->exec("SET AUTOCOMMIT = 0");
    $pdo->exec("START TRANSACTION");
    
    echo "🔄 Starting import...\n";
    
    // Split SQL into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^--/', $stmt);
        }
    );
    
    $imported = 0;
    $errors = 0;
    
    foreach ($statements as $statement) {
        if (empty(trim($statement))) continue;
        
        try {
            $pdo->exec($statement);
            $imported++;
            
            // Show progress for large imports
            if ($imported % 100 === 0) {
                echo "   Processed $imported statements...\n";
            }
        } catch (PDOException $e) {
            $errors++;
            echo "   ⚠️  Error in statement: " . substr($statement, 0, 100) . "...\n";
            echo "      " . $e->getMessage() . "\n";
        }
    }
    
    // Commit transaction
    $pdo->exec("COMMIT");
    
    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "\n🎉 Import completed!\n";
    echo "📊 Statistics:\n";
    echo "   • Statements executed: $imported\n";
    echo "   • Errors encountered: $errors\n";
    
    // Verify import by checking table counts
    echo "\n🔍 Verifying import...\n";
    $tables = [
        'users', 'categories', 'topics', 'menu_items', 
        'navigation_sections', 'settings', 'templates'
    ];
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "   • $table: $count records\n";
        } catch (PDOException $e) {
            echo "   • $table: Table doesn't exist\n";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "\n💡 Make sure your production database is accessible\n";
}
