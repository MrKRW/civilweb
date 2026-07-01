<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require_once __DIR__ . '/config/db.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT * FROM projects WHERE title LIKE '%PROVIDENCE%'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
