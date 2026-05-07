<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'action' => 'create',
    'title' => 'Test Project',
    'category' => 'local',
    'status' => 'published'
];
$_FILES = [
    'image_main' => [
        'name' => 'main.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => __DIR__ . '/test.jpg',
        'error' => UPLOAD_ERR_OK,
        'size' => 1000
    ],
    'image_gallery' => [
        'name' => ['gal1.jpg', '', '', ''],
        'type' => ['image/jpeg', '', '', ''],
        'tmp_name' => [__DIR__ . '/test.jpg', '', '', ''],
        'error' => [UPLOAD_ERR_OK, UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_FILE],
        'size' => [1000, 0, 0, 0]
    ]
];
file_put_contents(__DIR__ . '/test.jpg', 'fake image data');

ob_start();
require __DIR__ . '/projects.php';
$output = ob_get_clean();
echo "OUTPUT: \n" . $output;
