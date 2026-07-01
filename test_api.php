<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require_once __DIR__ . '/config/db.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT id, title, image_main FROM projects WHERE status='published'");
$projects = $stmt->fetchAll();
echo json_encode(['projects' => $projects]);
