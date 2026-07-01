<?php
$_SERVER['HTTP_HOST'] = 'localhost';
define('ROOT_DIR', __DIR__);
require_once 'app/models/PartnerLogoModel.php';
$m = new PartnerLogoModel();
$logos = $m->getAll();
print_r($logos);
