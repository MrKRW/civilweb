<?php
/**
 * CivilLanka – Key Specs Migration
 * Adds key specs columns to shop_items.
 * Run once: http://localhost/civilweb/migrate_specs.php
 * DELETE after running.
 */
require_once __DIR__ . '/config/db.php';

echo "<pre style='font-family:monospace;background:#111;color:#0f0;padding:30px;font-size:14px;'>";
echo "╔═══════════════════════════════════════════╗\n";
echo "║   CivilLanka Key Specs Migration          ║\n";
echo "╚═══════════════════════════════════════════╝\n\n";

try {
    $pdo = Database::getInstance()->getConnection();

    $columns = [
        'spec_sqft'    => 'VARCHAR(50) NULL AFTER additional_info_images',
        'spec_beds'    => 'VARCHAR(50) NULL AFTER spec_sqft',
        'spec_baths'   => 'VARCHAR(50) NULL AFTER spec_beds',
        'spec_floors'  => 'VARCHAR(50) NULL AFTER spec_baths',
        'spec_garages' => 'VARCHAR(50) NULL AFTER spec_floors',
    ];

    foreach ($columns as $col => $def) {
        $cols = $pdo->query("SHOW COLUMNS FROM `shop_items` LIKE '$col'")->fetchAll();
        if (empty($cols)) {
            $pdo->exec("ALTER TABLE `shop_items` ADD COLUMN `$col` $def");
            echo "✓ Column '$col' added\n";
        } else {
            echo "✓ Column '$col' already exists\n";
        }
    }

    echo "\n══════════════════════════════════════════\n";
    echo "  ✅ MIGRATION COMPLETE! Delete this file.\n";
    echo "══════════════════════════════════════════\n";

} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
}

echo "</pre>";
