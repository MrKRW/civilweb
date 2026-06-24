<?php
$_SERVER['HTTP_HOST'] = 'localhost';
define('ROOT_DIR', __DIR__);
require_once 'app/models/PartnerLogoModel.php';
print_r((new PartnerLogoModel())->getAll());
