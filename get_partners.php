<?php
require 'config/db.php';
$db = getDB();
$stmt = $db->query('SELECT * FROM partners');
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res, JSON_PRETTY_PRINT);
