<?php
/**
 * Script to drop all tables in the database.
 * Run this from the browser at: http://localhost/civilweb/drop_tables.php
 * Or via command line: php drop_tables.php
 */

require_once __DIR__ . '/config/db.php';

try {
    $pdo = getDB();
    
    // Disable foreign key checks temporarily to avoid constraint errors
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    
    // Fetch all table names in the current database
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "No tables found in the database. It is already empty.\n";
    } else {
        foreach ($tables as $table) {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
            echo "Dropped table: $table\n";
        }
        echo "All tables have been dropped successfully!\n";
    }
    
    // Re-enable foreign key checks
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    
} catch (Exception $e) {
    echo "Error dropping tables: " . $e->getMessage() . "\n";
}
