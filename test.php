<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require_once 'c:/xampp/htdocs/civilweb/config/db.php';
$stmt = getDB()->query('SELECT * FROM partner_logos');
print_r($stmt->fetchAll());
