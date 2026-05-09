<?php
$_POST = [
    'action' => 'create',
    'title' => 'Test Item',
    'price' => '10.00',
    'status' => 'published'
];
$_SERVER['REQUEST_METHOD'] = 'POST';

// Mock session to bypass auth
session_start();
$_SESSION['admin_id'] = 1;

require_once __DIR__ . '/shop.php';
