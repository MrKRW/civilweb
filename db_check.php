<?php
$conn = new mysqli('localhost', 'root', '', 'civillanka_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT id, title, image FROM blog_posts");
$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
echo json_encode($rows, JSON_PRETTY_PRINT);
