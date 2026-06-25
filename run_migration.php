<?php
require_once __DIR__ . '/config/db.php';

try {
    $db = getDB();
    $db->exec("ALTER TABLE shop_items ADD COLUMN whats_included TEXT DEFAULT NULL;");
    $db->exec("ALTER TABLE shop_items ADD COLUMN whats_not_included TEXT DEFAULT NULL;");
    echo "Columns added successfully to the database!";
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Columns already exist in the database.";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
