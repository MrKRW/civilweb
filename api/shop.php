<?php
/**
 * CivilLanka – Shop Items CRUD API
 */
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Public endpoints (no auth required)
$publicActions = ['list', 'get'];

if (!in_array($action, $publicActions)) {
    if (empty($_SESSION['admin_id'])) {
        jsonResponse(['error' => 'Unauthorized'], 401);
    }
}

$db = getDB();

switch ($action) {

    case 'list':
        $sql = 'SELECT * FROM shop_items ORDER BY sort_order ASC, created_at DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $items = $stmt->fetchAll();
        jsonResponse(['items' => $items]);
        break;

    case 'get':
        $id = (int) ($_GET['id'] ?? 0);
        $stmt = $db->prepare('SELECT * FROM shop_items WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $item = $stmt->fetch();
        if (!$item)
            jsonResponse(['error' => 'Not found'], 404);
        jsonResponse(['item' => $item]);
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $title = trim($_POST['title'] ?? '');
        $price = (float) ($_POST['price'] ?? 0);
        if ($title === '') jsonResponse(['error' => 'Title is required'], 400);

        // Handle image upload
        $imageName = '';
        if (!empty($_FILES['image']['name'])) {
            $imageName = uploadShopImage($_FILES['image']);
            if (!$imageName) jsonResponse(['error' => 'Image upload failed'], 400);
        }

        $stmt = $db->prepare("
            INSERT INTO shop_items (title, price, original_price, description, category, image, status, sort_order)
            VALUES (:title, :price, :original_price, :description, :category, :image, :status, :sort_order)
        ");
        $stmt->execute([
            ':title' => $title,
            ':price' => $price,
            ':original_price' => !empty($_POST['original_price']) ? (float)$_POST['original_price'] : null,
            ':description' => $_POST['description'] ?? '',
            ':category' => $_POST['category'] ?? '',
            ':image' => $imageName,
            ':status' => $_POST['status'] ?? 'published',
            ':sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ]);

        jsonResponse(['success' => true, 'id' => $db->lastInsertId()], 201);
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        if (!$id) jsonResponse(['error' => 'ID required'], 400);

        $stmt = $db->prepare('SELECT * FROM shop_items WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $existing = $stmt->fetch();
        if (!$existing) jsonResponse(['error' => 'Not found'], 404);

        $imageName = $existing['image'];
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $newImage = uploadShopImage($_FILES['image']);
            if ($newImage) {
                deleteShopImage($existing['image']);
                $imageName = $newImage;
            }
        }

        $stmt = $db->prepare("
            UPDATE shop_items SET
                title = :title, price = :price, original_price = :original_price,
                description = :description, category = :category, image = :image,
                status = :status, sort_order = :sort_order
            WHERE id = :id
        ");
        $stmt->execute([
            ':title' => $_POST['title'] ?? $existing['title'],
            ':price' => isset($_POST['price']) ? (float)$_POST['price'] : $existing['price'],
            ':original_price' => !empty($_POST['original_price']) ? (float)$_POST['original_price'] : null,
            ':description' => $_POST['description'] ?? $existing['description'],
            ':category' => $_POST['category'] ?? $existing['category'],
            ':image' => $imageName,
            ':status' => $_POST['status'] ?? $existing['status'],
            ':sort_order' => (int) ($_POST['sort_order'] ?? $existing['sort_order']),
            ':id' => $id,
        ]);

        jsonResponse(['success' => true]);
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        if (!$id) jsonResponse(['error' => 'ID required'], 400);

        $stmt = $db->prepare('SELECT * FROM shop_items WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $item = $stmt->fetch();
        if (!$item) jsonResponse(['error' => 'Not found'], 404);

        deleteShopImage($item['image']);

        $stmt = $db->prepare('DELETE FROM shop_items WHERE id = :id');
        $stmt->execute([':id' => $id]);

        jsonResponse(['success' => true]);
        break;

    default:
        jsonResponse(['error' => 'Unknown action'], 400);
}

function uploadShopImage(array $file): string
{
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $maxSize = 10 * 1024 * 1024; // 10 MB

    if ($file['error'] !== UPLOAD_ERR_OK) return '';
    if (!in_array($file['type'], $allowed)) return '';
    if ($file['size'] > $maxSize) return '';

    $uploadDir = __DIR__ . '/../uploads/shop/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $name = uniqid('shop_', true) . '.' . $ext;
    $dest = $uploadDir . $name;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return $name;
    }
    return '';
}

function deleteShopImage(?string $filename): void
{
    if (empty($filename)) return;
    $path = __DIR__ . '/../uploads/shop/' . $filename;
    if (file_exists($path)) {
        @unlink($path);
    }
}
