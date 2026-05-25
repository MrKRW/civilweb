<?php
/**
 * CivilLanka – Hostinger Migration Script
 * Run this by visiting: civilanka.com/migrate.php
 * It reads config/database.sql and runs it on the current database connection.
 */

// Define IS_LOCAL so db.php doesn't throw a notice if included standalone
if (!defined('IS_LOCAL')) {
    define('IS_LOCAL', false);
}

require_once __DIR__ . '/config/db.php';

try {
    $pdo = getDB();
    
    // Read the SQL file
    $sqlFile = __DIR__ . '/config/database.sql';
    if (!file_exists($sqlFile)) {
        die("❌ Error: config/database.sql not found!");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // Remove the CREATE DATABASE and USE statements because Hostinger doesn't allow CREATE DATABASE
    $sql = preg_replace('/CREATE DATABASE[^;]+;/i', '', $sql);
    $sql = preg_replace('/USE `[^`]+`;/i', '', $sql);
    
    // Execute the modified SQL
    $pdo->exec($sql);
    
    echo "<h1>✅ Database Migration Successful!</h1>";
    echo "<p>All tables and the default admin user have been created.</p>";
    echo "<p><a href='/admin/login'>Click here to go to the Admin Login</a></p>";
    echo "<p><strong>⚠️ IMPORTANT: Please delete this migrate.php file from your server after you verify it works!</strong></p>";

} catch (PDOException $e) {
    echo "<h1>❌ Database Migration Failed!</h1>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
