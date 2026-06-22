<?php
/**
 * CivilLanka MVC – BlogController
 * Handles: public blog page + /api/blog JSON API.
 */
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/BlogModel.php';

class BlogController extends Controller
{
    private BlogModel $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new BlogModel();
    }

    /** GET /blog – public blog listing page */
    public function index(): void
    {
        $posts = [];
        try {
            $posts = $this->model->getPublished();
        } catch (\Throwable $e) {
            // Table may not exist yet — silently pass empty array
        }
        $this->render('blog/index', ['posts' => $posts], 'main');
    }

    /** GET /blog/post/{id} – single blog post page */
    public function detail(int $id): void
    {
        $post = $this->model->getById($id);
        if (!$post || $post['status'] !== 'published') {
            $this->redirect(BASE_PATH . '/blog');
        }
        
        // Also fetch recent posts for the sidebar/footer
        $recent = array_slice($this->model->getPublished(), 0, 4);
        
        $this->render('blog/post', [
            'post'   => $post,
            'recent' => $recent
        ], 'main');
    }

    /** /api/blog – JSON API (requires admin auth) */
    public function api(): void
    {
        ob_start();

        header('Content-Type: application/json; charset=utf-8');
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['admin_id'])) {
            ob_clean();
            $this->json(['error' => 'Unauthorized'], 401);
        }

        $action = $_GET['action'] ?? 'list';

        try {
            switch ($action) {

                // ── LIST all posts ───────────────────────────────────────
                case 'list':
                    $filters = [];
                    if (!empty($_GET['status']))   $filters['status']   = $_GET['status'];
                    if (!empty($_GET['category'])) $filters['category'] = $_GET['category'];
                    ob_clean();
                    $this->json(['posts' => $this->model->getAll($filters)]);
                    break;

                // ── GET single post ───────────────────────────────────
                case 'get':
                    $id   = (int) ($_GET['id'] ?? 0);
                    $post = $this->model->getById($id);
                    ob_clean();
                    if (!$post) $this->json(['error' => 'Not found'], 404);
                    $this->json(['post' => $post]);
                    break;

                // ── CREATE ────────────────────────────────────────────
                case 'create':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        ob_clean();
                        $this->json(['error' => 'POST required'], 405);
                    }
                    $title = trim($_POST['title'] ?? '');
                    if ($title === '') { ob_clean(); $this->json(['error' => 'Title is required'], 400); }

                    $imageFile = (!empty($_FILES['image']['name'])) ? $_FILES['image'] : null;
                    $id = $this->model->create($_POST, $imageFile);
                    ob_clean();
                    $this->json(['success' => true, 'id' => $id]);
                    break;

                // ── UPDATE ────────────────────────────────────────────
                case 'update':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        ob_clean();
                        $this->json(['error' => 'POST required'], 405);
                    }
                    $id    = (int) ($_GET['id'] ?? 0);
                    $title = trim($_POST['title'] ?? '');
                    if (!$id)      { ob_clean(); $this->json(['error' => 'ID required'], 400); }
                    if ($title === '') { ob_clean(); $this->json(['error' => 'Title is required'], 400); }

                    $imageFile = (!empty($_FILES['image']['name'])) ? $_FILES['image'] : null;
                    $ok = $this->model->update($id, $_POST, $imageFile);
                    ob_clean();
                    $ok ? $this->json(['success' => true]) : $this->json(['error' => 'Post not found'], 404);
                    break;

                // ── DELETE ────────────────────────────────────────────
                case 'delete':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        ob_clean();
                        $this->json(['error' => 'POST required'], 405);
                    }
                    $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
                    if (!$id) { ob_clean(); $this->json(['error' => 'ID required'], 400); }

                    $ok = $this->model->delete($id);
                    ob_clean();
                    $ok ? $this->json(['success' => true]) : $this->json(['error' => 'Post not found'], 404);
                    break;

                // ── CLEANUP orphaned content images ───────────────────
                case 'cleanup_images':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        ob_clean();
                        $this->json(['error' => 'POST required'], 405);
                    }
                    $deleted = $this->model->cleanupContentImages();
                    ob_clean();
                    $this->json([
                        'success' => true,
                        'deleted' => $deleted,
                        'message' => $deleted === 0
                            ? 'No orphaned images found.'
                            : $deleted . ' orphaned image' . ($deleted === 1 ? '' : 's') . ' deleted.'
                    ]);
                    break;

                // ── UPLOAD inline image (for TinyMCE body) ────────────
                case 'upload_image':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        ob_clean();
                        $this->json(['error' => 'POST required'], 405);
                    }
                    if (empty($_FILES['file']['name']) || ($_FILES['file']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                        ob_clean();
                        $this->json(['error' => 'No file uploaded'], 400);
                    }
                    $file    = $_FILES['file'];
                    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                    if (!in_array($file['type'] ?? '', $allowed)) {
                        ob_clean();
                        $this->json(['error' => 'Invalid file type'], 400);
                    }
                    if (($file['size'] ?? 0) > 10 * 1024 * 1024) {
                        ob_clean();
                        $this->json(['error' => 'File too large (max 10 MB)'], 400);
                    }
                    $contentDir = ROOT_DIR . '/uploads/blog/content/';
                    if (!is_dir($contentDir)) mkdir($contentDir, 0755, true);
                    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $filename = uniqid('blogimg_', true) . '.' . $ext;
                    if (!move_uploaded_file($file['tmp_name'], $contentDir . $filename)) {
                        ob_clean();
                        $this->json(['error' => 'Upload failed'], 500);
                    }
                    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
                             . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')
                             . (defined('BASE_PATH') ? BASE_PATH : '/civilweb');
                    ob_clean();
                    $this->json(['location' => $baseUrl . '/uploads/blog/content/' . $filename]);
                    break;

                default:
                    ob_clean();
                    $this->json(['error' => 'Unknown action'], 400);
            }
        } catch (Throwable $e) {
            ob_clean();
            $this->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
