<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require_once __DIR__ . '/config/db.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT id, title, image_main FROM projects LIMIT 5");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
