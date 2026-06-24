<?php
define('IS_LOCAL', true);
require_once __DIR__ . '/config/db.php';

try {
    $db = getDB();
    $db->exec("ALTER TABLE shop_items ADD COLUMN whats_included TEXT DEFAULT NULL;");
    $db->exec("ALTER TABLE shop_items ADD COLUMN whats_not_included TEXT DEFAULT NULL;");
    echo "Columns added successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
