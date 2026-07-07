<?php
require 'config/db.php';
$db=getDB();
$stmt=$db->query('SELECT id, title, image_main FROM projects');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
