<?php
$url = 'https://civilanka.com/uploads/blog/blog_6a3cc255352852.77729236.jpg';
$headers = @get_headers($url);
echo "Headers for $url:\n";
if ($headers) {
    foreach ($headers as $h) {
        echo $h . "\n";
    }
} else {
    echo "Failed to fetch headers.";
}
