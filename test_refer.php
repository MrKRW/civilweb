<?php
$url = 'https://civilanka.com/uploads/projects/proj_6a4362d43317f8.19983803.webp';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Referer: http://localhost/civilweb/projects'
]);
$response = curl_exec($ch);
echo "Status with Referer: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
