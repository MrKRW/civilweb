<?php
require_once __DIR__ . '/../config/db.php';
try {
    $db = getDB();
    $stmt = $db->prepare('SELECT * FROM shop_items');
    $stmt->execute();
    $items = $stmt->fetchAll();
    echo "Count: " . count($items) . "\n";
    print_r($items);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
