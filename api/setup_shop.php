<?php
require_once __DIR__ . '/../config/db.php';
try {
    $db = getDB();

    // Create table if not exists (includes gallery_images column)
    $db->exec("
        CREATE TABLE IF NOT EXISTS `shop_items` (
            `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `title`          VARCHAR(255)   NOT NULL,
            `price`          DECIMAL(10,2)  NOT NULL,
            `original_price` DECIMAL(10,2)  NULL,
            `description`    TEXT           NULL,
            `image`          VARCHAR(255)   NULL,
            `gallery_images` TEXT           NULL,
            `category`       VARCHAR(100)   NULL,
            `status`         ENUM('draft','published') NOT NULL DEFAULT 'published',
            `sort_order`     INT            NOT NULL DEFAULT 0,
            `created_at`     TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
            `updated_at`     TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");

    // Safe migration: add gallery_images column if missing on existing installs
    $cols = $db->query("SHOW COLUMNS FROM `shop_items` LIKE 'gallery_images'")->fetchAll();
    if (empty($cols)) {
        $db->exec("ALTER TABLE `shop_items` ADD COLUMN `gallery_images` TEXT NULL AFTER `image`");
        echo "Column `gallery_images` added. ";
    }

    echo "Shop table ready.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
