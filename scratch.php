<?php
require 'config/database.php';
$db = getDB();
$stmt = $db->prepare("SELECT id, title, service_type, image_main FROM projects WHERE featured = 1 AND status = 'published' ORDER BY sort_order ASC, created_at DESC");
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
