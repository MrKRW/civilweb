<?php
require_once __DIR__ . '/../config/db.php';
try {
    $db = getDB();
    $db->exec("
        CREATE TABLE IF NOT EXISTS `shop_items` (
            `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `title`         VARCHAR(255)   NOT NULL,
            `price`         DECIMAL(10,2)  NOT NULL,
            `original_price` DECIMAL(10,2)  NULL,
            `description`   TEXT           NULL,
            `image`         VARCHAR(255)   NULL,
            `category`      VARCHAR(100)   NULL,
            `status`        ENUM('draft','published') NOT NULL DEFAULT 'published',
            `sort_order`    INT            NOT NULL DEFAULT 0,
            `created_at`    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
            `updated_at`    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");
    echo "Table created successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
