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
        // Decode gallery_images JSON for each item
        foreach ($items as &$item) {
            $item['gallery_images'] = !empty($item['gallery_images'])
                ? json_decode($item['gallery_images'], true)
                : [];
        }
        unset($item);
        jsonResponse(['items' => $items]);
        break;

    case 'get':
        $id = (int) ($_GET['id'] ?? 0);
        $stmt = $db->prepare('SELECT * FROM shop_items WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $item = $stmt->fetch();
        if (!$item)
            jsonResponse(['error' => 'Not found'], 404);
        // Decode gallery_images
        $item['gallery_images'] = !empty($item['gallery_images'])
            ? json_decode($item['gallery_images'], true)
            : [];
        jsonResponse(['item' => $item]);
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $title = trim($_POST['title'] ?? '');
        $price = (float) ($_POST['price'] ?? 0);
        if ($title === '') jsonResponse(['error' => 'Title is required'], 400);

        // Handle main image upload
        $imageName = '';
        if (!empty($_FILES['image']['name'])) {
            $imageName = uploadShopImage($_FILES['image']);
            if (!$imageName) jsonResponse(['error' => 'Main image upload failed'], 400);
        }

        // Handle gallery images upload (up to 4)
        $galleryImages = uploadShopGalleryImages();

        $stmt = $db->prepare("
            INSERT INTO shop_items (title, price, original_price, description, category, image, gallery_images, status, sort_order)
            VALUES (:title, :price, :original_price, :description, :category, :image, :gallery_images, :status, :sort_order)
        ");
        $stmt->execute([
            ':title'          => $title,
            ':price'          => $price,
            ':original_price' => !empty($_POST['original_price']) ? (float)$_POST['original_price'] : null,
            ':description'    => $_POST['description'] ?? '',
            ':category'       => $_POST['category'] ?? '',
            ':image'          => $imageName,
            ':gallery_images' => json_encode($galleryImages),
            ':status'         => $_POST['status'] ?? 'published',
            ':sort_order'     => (int) ($_POST['sort_order'] ?? 0),
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

        // Handle main image
        $imageName = $existing['image'];
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $newImage = uploadShopImage($_FILES['image']);
            if ($newImage) {
                deleteShopImage($existing['image']);
                $imageName = $newImage;
            }
        }

        // Decode existing gallery
        $existingGallery = !empty($existing['gallery_images'])
            ? json_decode($existing['gallery_images'], true)
            : [];

        // Handle gallery removals
        $toRemove = json_decode($_POST['remove_gallery'] ?? '[]', true) ?: [];
        foreach ($toRemove as $fname) {
            deleteShopImage($fname);
            $existingGallery = array_values(array_filter($existingGallery, fn($g) => $g !== $fname));
        }

        // Handle new gallery uploads (slots 1-4 sent as gallery_images[0..3])
        $newGallery = uploadShopGalleryImages();
        $mergedGallery = array_values(array_merge($existingGallery, $newGallery));
        // Cap at 4
        $mergedGallery = array_slice($mergedGallery, 0, 4);

        $stmt = $db->prepare("
            UPDATE shop_items SET
                title = :title, price = :price, original_price = :original_price,
                description = :description, category = :category, image = :image,
                gallery_images = :gallery_images, status = :status, sort_order = :sort_order
            WHERE id = :id
        ");
        $stmt->execute([
            ':title'          => $_POST['title'] ?? $existing['title'],
            ':price'          => isset($_POST['price']) ? (float)$_POST['price'] : $existing['price'],
            ':original_price' => !empty($_POST['original_price']) ? (float)$_POST['original_price'] : null,
            ':description'    => $_POST['description'] ?? $existing['description'],
            ':category'       => $_POST['category'] ?? $existing['category'],
            ':image'          => $imageName,
            ':gallery_images' => json_encode($mergedGallery),
            ':status'         => $_POST['status'] ?? $existing['status'],
            ':sort_order'     => (int) ($_POST['sort_order'] ?? $existing['sort_order']),
            ':id'             => $id,
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

        // Delete main image
        deleteShopImage($item['image']);

        // Delete all gallery images
        $gallery = !empty($item['gallery_images'])
            ? json_decode($item['gallery_images'], true)
            : [];
        foreach ($gallery as $fname) {
            deleteShopImage($fname);
        }

        $stmt = $db->prepare('DELETE FROM shop_items WHERE id = :id');
        $stmt->execute([':id' => $id]);

        jsonResponse(['success' => true]);
        break;

    default:
        jsonResponse(['error' => 'Unknown action'], 400);
}

/* ── Helpers ─────────────────────────────────────────── */

function uploadShopImage(array $file): string
{
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $maxSize = 10 * 1024 * 1024;

    if ($file['error'] !== UPLOAD_ERR_OK) return '';
    if (!in_array($file['type'], $allowed)) return '';
    if ($file['size'] > $maxSize) return '';

    $uploadDir = __DIR__ . '/../uploads/shop/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $name = uniqid('shop_', true) . '.' . $ext;
    $dest = $uploadDir . $name;

    return move_uploaded_file($file['tmp_name'], $dest) ? $name : '';
}

/**
 * Upload gallery images from $_FILES['gallery_images'] (array of files).
 * Returns array of uploaded filenames.
 */
function uploadShopGalleryImages(): array
{
    $result = [];
    if (empty($_FILES['gallery_images'])) return $result;

    $files = $_FILES['gallery_images'];
    // Normalise the multi-file array structure
    $count = is_array($files['name']) ? count($files['name']) : 1;

    for ($i = 0; $i < $count; $i++) {
        $single = [
            'name'     => is_array($files['name'])     ? $files['name'][$i]     : $files['name'],
            'type'     => is_array($files['type'])     ? $files['type'][$i]     : $files['type'],
            'tmp_name' => is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'],
            'error'    => is_array($files['error'])    ? $files['error'][$i]    : $files['error'],
            'size'     => is_array($files['size'])     ? $files['size'][$i]     : $files['size'],
        ];

        if ($single['error'] !== UPLOAD_ERR_OK || empty($single['name'])) continue;

        $name = uploadShopImage($single);
        if ($name) $result[] = $name;
    }

    return $result;
}

function deleteShopImage(?string $filename): void
{
    if (empty($filename)) return;
    $path = __DIR__ . '/../uploads/shop/' . $filename;
    if (file_exists($path)) {
        @unlink($path);
    }
}
