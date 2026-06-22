<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'config/db.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT content FROM blog_posts ORDER BY id DESC LIMIT 1;");
var_dump($stmt->fetchColumn());
