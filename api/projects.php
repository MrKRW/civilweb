<?php
/**
 * CivilLanka – Projects CRUD API
 *
 * GET  ?action=list[&category=local|international][&status=published|draft][&featured=1]
 * GET  ?action=get&id=X
 * GET  ?action=featured            → published + featured projects for homepage
 * POST ?action=create              → multipart form with image
 * POST ?action=update&id=X         → multipart form with optional new image
 * POST ?action=delete&id=X
 * POST ?action=toggle_featured&id=X
 * POST ?action=toggle_status&id=X
 */
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Public endpoints (no auth required)
$publicActions = ['list', 'get', 'featured', 'create', 'update'];

if (!in_array($action, $publicActions)) {
    if (empty($_SESSION['admin_id'])) {
        jsonResponse(['error' => 'Unauthorized'], 401);
    }
}

$db = getDB();

switch ($action) {

    /* ── LIST ─────────────────────────────────────── */
    case 'list':
        $where = [];
        $params = [];

        if (!empty($_GET['category'])) {
            $where[] = 'category = :cat';
            $params[':cat'] = $_GET['category'];
        }
        if (!empty($_GET['status'])) {
            $where[] = 'status = :st';
            $params[':st'] = $_GET['status'];
        }
        if (isset($_GET['featured']) && $_GET['featured'] !== '') {
            $where[] = 'featured = :feat';
            $params[':feat'] = (int) $_GET['featured'];
        }

        $sql = 'SELECT * FROM projects';
        if ($where)
            $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY sort_order ASC, created_at DESC';

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $projects = $stmt->fetchAll();

        // Decode image_gallery JSON for each project
        foreach ($projects as &$p) {
            $p['image_gallery'] = $p['image_gallery'] ? json_decode($p['image_gallery'], true) : [];
        }

        jsonResponse(['projects' => $projects]);
        break;

    /* ── GET SINGLE ──────────────────────────────── */
    case 'get':
        $id = (int) ($_GET['id'] ?? 0);
        $stmt = $db->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $project = $stmt->fetch();
        if (!$project)
            jsonResponse(['error' => 'Not found'], 404);

        $project['image_gallery'] = $project['image_gallery'] ? json_decode($project['image_gallery'], true) : [];
        jsonResponse(['project' => $project]);
        break;

    /* ── FEATURED (public homepage) ──────────────── */
    case 'featured':
        $stmt = $db->prepare("SELECT * FROM projects WHERE featured = 1 AND status = 'published' ORDER BY sort_order ASC, created_at DESC");
        $stmt->execute();
        $projects = $stmt->fetchAll();

        foreach ($projects as &$p) {
            $p['image_gallery'] = $p['image_gallery'] ? json_decode($p['image_gallery'], true) : [];
        }

        jsonResponse(['projects' => $projects]);
        break;

    /* ── CREATE ───────────────────────────────────── */
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $title = trim($_POST['title'] ?? '');
        if ($title === '')
            jsonResponse(['error' => 'Title is required'], 400);

        // Handle main image upload
        $imageName = '';
        if (!empty($_FILES['image_main']['name'])) {
            $imageName = uploadImage($_FILES['image_main']);
            if (!$imageName)
                jsonResponse(['error' => 'Image upload failed'], 400);
        }

        // Handle gallery images
        $gallery = [];
        if (!empty($_FILES['image_gallery'])) {
            $names = (array) ($_FILES['image_gallery']['name'] ?? []);
            $types = (array) ($_FILES['image_gallery']['type'] ?? []);
            $tmp_names = (array) ($_FILES['image_gallery']['tmp_name'] ?? []);
            $errors = (array) ($_FILES['image_gallery']['error'] ?? []);
            $sizes = (array) ($_FILES['image_gallery']['size'] ?? []);

            $fileCount = count($names);
            for ($i = 0; $i < $fileCount; $i++) {
                if (($errors[$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $names[$i] ?? '',
                        'type' => $types[$i] ?? '',
                        'tmp_name' => $tmp_names[$i] ?? '',
                        'error' => $errors[$i] ?? UPLOAD_ERR_NO_FILE,
                        'size' => $sizes[$i] ?? 0,
                    ];
                    $gName = uploadImage($file);
                    if ($gName)
                        $gallery[] = $gName;
                }
            }
        }

        $stmt = $db->prepare("
            INSERT INTO projects (title, category, description, location, client, year, service_type, image_main, image_gallery, featured, status, sort_order)
            VALUES (:title, :category, :description, :location, :client, :year, :service_type, :image_main, :image_gallery, :featured, :status, :sort_order)
        ");
        $stmt->execute([
            ':title' => $title,
            ':category' => $_POST['category'] ?? 'local',
            ':description' => $_POST['description'] ?? '',
            ':location' => $_POST['location'] ?? '',
            ':client' => $_POST['client'] ?? '',
            ':year' => !empty($_POST['year']) ? $_POST['year'] : null,
            ':service_type' => $_POST['service_type'] ?? '',
            ':image_main' => $imageName,
            ':image_gallery' => json_encode($gallery),
            ':featured' => (int) ($_POST['featured'] ?? 0),
            ':status' => $_POST['status'] ?? 'published',
            ':sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ]);

        $newId = $db->lastInsertId();
        jsonResponse(['success' => true, 'id' => $newId], 201);
        break;

    /* ── UPDATE ───────────────────────────────────── */
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        if (!$id)
            jsonResponse(['error' => 'ID required'], 400);

        // Fetch existing
        $stmt = $db->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $existing = $stmt->fetch();
        if (!$existing)
            jsonResponse(['error' => 'Not found'], 404);

        // Handle main image
        $imageName = $existing['image_main'];
        if (!empty($_FILES['image_main']['name']) && $_FILES['image_main']['error'] === UPLOAD_ERR_OK) {
            $newImage = uploadImage($_FILES['image_main']);
            if ($newImage) {
                // Delete old image
                deleteImage($existing['image_main']);
                $imageName = $newImage;
            }
        }

        // Handle gallery images
        $gallery = $existing['image_gallery'] ? json_decode($existing['image_gallery'], true) : [];
        if (!is_array($gallery))
            $gallery = [];
        if (!empty($_FILES['image_gallery'])) {
            $names = (array) ($_FILES['image_gallery']['name'] ?? []);
            $types = (array) ($_FILES['image_gallery']['type'] ?? []);
            $tmp_names = (array) ($_FILES['image_gallery']['tmp_name'] ?? []);
            $errors = (array) ($_FILES['image_gallery']['error'] ?? []);
            $sizes = (array) ($_FILES['image_gallery']['size'] ?? []);

            $fileCount = count($names);
            for ($i = 0; $i < $fileCount; $i++) {
                if (($errors[$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $names[$i] ?? '',
                        'type' => $types[$i] ?? '',
                        'tmp_name' => $tmp_names[$i] ?? '',
                        'error' => $errors[$i] ?? UPLOAD_ERR_NO_FILE,
                        'size' => $sizes[$i] ?? 0,
                    ];
                    $gName = uploadImage($file);
                    if ($gName)
                        $gallery[] = $gName;
                }
            }
        }

        // Handle removed gallery images
        if (!empty($_POST['remove_gallery'])) {
            $toRemove = json_decode($_POST['remove_gallery'], true) ?: [];
            foreach ($toRemove as $rem) {
                deleteImage($rem);
                $gallery = array_values(array_filter($gallery, fn($g) => $g !== $rem));
            }
        }

        $stmt = $db->prepare("
            UPDATE projects SET
                title = :title, category = :category, description = :description,
                location = :location, client = :client, year = :year,
                service_type = :service_type, image_main = :image_main,
                image_gallery = :image_gallery, featured = :featured,
                status = :status, sort_order = :sort_order
            WHERE id = :id
        ");
        $stmt->execute([
            ':title' => $_POST['title'] ?? $existing['title'],
            ':category' => $_POST['category'] ?? $existing['category'],
            ':description' => $_POST['description'] ?? $existing['description'],
            ':location' => $_POST['location'] ?? $existing['location'],
            ':client' => $_POST['client'] ?? $existing['client'],
            ':year' => !empty($_POST['year']) ? $_POST['year'] : $existing['year'],
            ':service_type' => $_POST['service_type'] ?? $existing['service_type'],
            ':image_main' => $imageName,
            ':image_gallery' => json_encode($gallery),
            ':featured' => (int) ($_POST['featured'] ?? $existing['featured']),
            ':status' => $_POST['status'] ?? $existing['status'],
            ':sort_order' => (int) ($_POST['sort_order'] ?? $existing['sort_order']),
            ':id' => $id,
        ]);

        jsonResponse(['success' => true]);
        break;

    /* ── DELETE ───────────────────────────────────── */
    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        if (!$id)
            jsonResponse(['error' => 'ID required'], 400);

        // Fetch to delete images
        $stmt = $db->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $project = $stmt->fetch();
        if (!$project)
            jsonResponse(['error' => 'Not found'], 404);

        // Remove images
        deleteImage($project['image_main']);
        $galleryImages = $project['image_gallery'] ? json_decode($project['image_gallery'], true) : [];
        foreach ($galleryImages as $gi) {
            deleteImage($gi);
        }

        $stmt = $db->prepare('DELETE FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);

        jsonResponse(['success' => true]);
        break;

    /* ── TOGGLE FEATURED ─────────────────────────── */
    case 'toggle_featured':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        $stmt = $db->prepare('UPDATE projects SET featured = NOT featured WHERE id = :id');
        $stmt->execute([':id' => $id]);

        jsonResponse(['success' => true]);
        break;

    /* ── TOGGLE STATUS ───────────────────────────── */
    case 'toggle_status':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            jsonResponse(['error' => 'POST required'], 405);

        $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        $stmt = $db->prepare("UPDATE projects SET status = IF(status='published','draft','published') WHERE id = :id");
        $stmt->execute([':id' => $id]);

        jsonResponse(['success' => true]);
        break;

    default:
        jsonResponse(['error' => 'Unknown action'], 400);
}

/* ── IMAGE HELPERS ───────────────────────────────── */

function uploadImage(array $file): string
{
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $maxSize = 10 * 1024 * 1024; // 10 MB

    if ($file['error'] !== UPLOAD_ERR_OK)
        return '';
    if (!in_array($file['type'], $allowed))
        return '';
    if ($file['size'] > $maxSize)
        return '';

    $uploadDir = __DIR__ . '/../uploads/projects/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $name = uniqid('proj_', true) . '.' . $ext;
    $dest = $uploadDir . $name;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return $name;
    }
    return '';
}

function deleteImage(string $filename): void
{
    if (empty($filename))
        return;
    $path = __DIR__ . '/../uploads/projects/' . $filename;
    if (file_exists($path)) {
        @unlink($path);
    }
}
