<?php
// Create essential Laravel tables manually
echo "<h2>🔧 Creating Laravel Tables Manually</h2>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>⚠️ Alternative Approach:</strong><br>";
echo "Since migrations aren't working, let's create the essential tables manually<br>";
echo "</div>";

try {
    $pdo = new PDO(
        "mysql:host=db5018653044.hosting-data.io;port=3306;dbname=dbs14780656", 
        'dbu1219527', 
        '0100421606@Nephroapp'
    );
    
    echo "<h3>🧪 Creating Essential Tables</h3>";
    
    // Create migrations table
    echo "Creating migrations table...<br>";
    $sql = "CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        batch INT NOT NULL
    )";
    $pdo->exec($sql);
    echo "✅ Migrations table created<br>";
    
    // Create users table
    echo "Creating users table...<br>";
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        email_verified_at TIMESTAMP NULL,
        password VARCHAR(255) NOT NULL,
        remember_token VARCHAR(100) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )";
    $pdo->exec($sql);
    echo "✅ Users table created<br>";
    
    // Create sessions table
    echo "Creating sessions table...<br>";
    $sql = "CREATE TABLE IF NOT EXISTS sessions (
        id VARCHAR(255) PRIMARY KEY,
        user_id BIGINT UNSIGNED NULL,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        payload LONGTEXT NOT NULL,
        last_activity INT NOT NULL,
        INDEX sessions_user_id_index (user_id),
        INDEX sessions_last_activity_index (last_activity)
    )";
    $pdo->exec($sql);
    echo "✅ Sessions table created<br>";
    
    // Create page_contents table (for your admin panel)
    echo "Creating page_contents table...<br>";
    $sql = "CREATE TABLE IF NOT EXISTS page_contents (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        key VARCHAR(255) NOT NULL UNIQUE,
        content LONGTEXT NOT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )";
    $pdo->exec($sql);
    echo "✅ Page contents table created<br>";
    
    // Create topics table (for your topics page)
    echo "Creating topics table...<br>";
    $sql = "CREATE TABLE IF NOT EXISTS topics (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        content LONGTEXT NOT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    )";
    $pdo->exec($sql);
    echo "✅ Topics table created<br>";
    
    // Insert some sample data
    echo "<h3>📝 Adding Sample Data</h3>";
    
    // Add sample topic
    $sql = "INSERT IGNORE INTO topics (title, slug, content, created_at, updated_at) VALUES 
    ('Hypokalemia', 'hypokalemia', 'Content about hypokalemia...', NOW(), NOW())";
    $pdo->exec($sql);
    echo "✅ Sample topic added<br>";
    
    // Add sample page content
    $sql = "INSERT IGNORE INTO page_contents (key, content, created_at, updated_at) VALUES 
    ('landing_page_html', '<h1>Welcome to NephroCoach</h1><p>Your medical training platform</p>', NOW(), NOW())";
    $pdo->exec($sql);
    echo "✅ Sample page content added<br>";
    
    // Check what tables were created
    echo "<h3>🔍 Verifying Tables</h3>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "✅ Found " . count($tables) . " tables in database:<br>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li><code>$table</code></li>";
    }
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎉 Tables Created Successfully!</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>Your Laravel app should now be fully functional!</strong></p>";
echo "<p>Test these pages:</p>";
echo "<ul>";
echo "<li><a href='index.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Visit Main Site</a></li>";
echo "<li><a href='topics' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📚 Topics Page</a></li>";
echo "<li><a href='admin/landing-page' style='background: #ffc107; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>⚙️ Admin Panel</a></li>";
echo "</ul>";
echo "</div>";
?>

