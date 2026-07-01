<?php
$url = 'https://civilanka.com/uploads/projects/proj_6a43801dec05d8.43006288.jpg';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$response = curl_exec($ch);
echo "Status: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
print_r($response);
