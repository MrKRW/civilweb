<?php
/**
 * CivilLanka – Shop Migration
 * Adds additional_info (rich text) and additional_info_images (JSON) to shop_items.
 * Run once: http://localhost/civilweb/migrate_shop.php
 * DELETE after running.
 */
define('IS_LOCAL', true);
require_once __DIR__ . '/config/db.php';

echo "<pre style='font-family:monospace;background:#111;color:#0f0;padding:30px;font-size:14px;'>";
echo "╔═══════════════════════════════════════════╗\n";
echo "║   CivilLanka Shop Migration               ║\n";
echo "╚═══════════════════════════════════════════╝\n\n";

try {
    $pdo = getDB();

    // Add additional_info column if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `shop_items` LIKE 'additional_info'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `shop_items` ADD COLUMN `additional_info` LONGTEXT NULL AFTER `description`");
        echo "✓ Column 'additional_info' added\n";
    } else {
        echo "✓ Column 'additional_info' already exists\n";
    }

    // Add additional_info_images column if not exists
    $cols2 = $pdo->query("SHOW COLUMNS FROM `shop_items` LIKE 'additional_info_images'")->fetchAll();
    if (empty($cols2)) {
        $pdo->exec("ALTER TABLE `shop_items` ADD COLUMN `additional_info_images` JSON NULL AFTER `additional_info`");
        echo "✓ Column 'additional_info_images' added\n";
    } else {
        echo "✓ Column 'additional_info_images' already exists\n";
    }

    echo "\n══════════════════════════════════════════\n";
    echo "  ✅ MIGRATION COMPLETE! Delete this file.\n";
    echo "══════════════════════════════════════════\n";

} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
}

echo "</pre>";
