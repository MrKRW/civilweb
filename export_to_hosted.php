<?php
/**
 * CivilLanka – Local → Hosted DB Export Helper
 * Run locally: http://localhost/civilweb/export_to_hosted.php
 * Copy the generated SQL and run it in the hosted phpMyAdmin.
 * DELETE THIS FILE after use!
 */

define('IS_LOCAL', true);
require_once __DIR__ . '/config/db.php';

$db = getDB();

// Tables to export
$tables = ['shop_items', 'projects', 'blog_posts', 'product_reviews'];

header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="civilanka_export_' . date('Y-m-d_H-i-s') . '.sql"');

echo "-- CivilLanka Database Export\n";
echo "-- Generated: " . date('Y-m-d H:i:s') . "\n";
echo "-- Run this in your hosted phpMyAdmin (select database u828029692_civilankadb first)\n\n";
echo "SET NAMES utf8mb4;\n";
echo "SET FOREIGN_KEY_CHECKS=0;\n\n";

foreach ($tables as $table) {
    try {
        $stmt = $db->query("SELECT * FROM `$table`");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            echo "-- Table `$table` is empty, skipping.\n\n";
            continue;
        }

        echo "-- Exporting table: $table (" . count($rows) . " rows)\n";

        foreach ($rows as $row) {
            $cols = implode('`, `', array_keys($row));
            $vals = array_map(function($v) use ($db) {
                if ($v === null) return 'NULL';
                return $db->quote($v);
            }, array_values($row));
            $valsStr = implode(', ', $vals);
            echo "INSERT IGNORE INTO `$table` (`$cols`) VALUES ($valsStr);\n";
        }

        echo "\n";
    } catch (PDOException $e) {
        echo "-- SKIP: Table `$table` not found or error: " . $e->getMessage() . "\n\n";
    }
}

echo "SET FOREIGN_KEY_CHECKS=1;\n";
echo "-- Export complete.\n";
