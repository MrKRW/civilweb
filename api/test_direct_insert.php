<?php
require_once __DIR__ . '/../config/db.php';
try {
    $db = getDB();
    
    // Check if table exists and describe it
    $stmt = $db->query("DESCRIBE shop_items");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($columns);

    $stmt = $db->prepare("
        INSERT INTO shop_items (title, price, original_price, description, category, image, status, sort_order)
        VALUES (:title, :price, :original_price, :description, :category, :image, :status, :sort_order)
    ");
    $stmt->execute([
        ':title' => 'Direct Insert Test',
        ':price' => 10.00,
        ':original_price' => null,
        ':description' => 'Test',
        ':category' => 'Test',
        ':image' => '',
        ':status' => 'published',
        ':sort_order' => 0,
    ]);
    echo "Inserted: " . $db->lastInsertId() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
