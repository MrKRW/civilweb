<?php
$_SERVER['HTTP_HOST'] = 'localhost';
define('ROOT_DIR', 'c:/xampp/htdocs/civilweb');
require_once 'c:/xampp/htdocs/civilweb/app/models/PartnerLogoModel.php';
$model = new PartnerLogoModel();
// Fake a $_FILES array
$tmpPath = 'c:/xampp/htdocs/civilweb/uploads/logos/fake.jpg';
file_put_contents($tmpPath, 'fake_image_data');
$file = [
    'name' => 'test.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => $tmpPath,
    'error' => UPLOAD_ERR_OK,
    'size' => 100
];
$id = $model->create(['alt_text' => 'Test Logo', 'sort_order' => 1], $file);
echo "Inserted ID: $id\n";
print_r($model->getById($id));
