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
        header('Content-Type: application/json; charset=utf-8');
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['admin_id'])) {
            $this->json(['error' => 'Unauthorized'], 401);
        }

        $action = $_GET['action'] ?? 'list';

        switch ($action) {

            // ── LIST all posts ──────────────────────────────────────
            case 'list':
                $filters = [];
                if (!empty($_GET['status']))   $filters['status']   = $_GET['status'];
                if (!empty($_GET['category'])) $filters['category'] = $_GET['category'];
                $this->json(['posts' => $this->model->getAll($filters)]);
                break;

            // ── GET single post ─────────────────────────────────────
            case 'get':
                $id   = (int) ($_GET['id'] ?? 0);
                $post = $this->model->getById($id);
                if (!$post) $this->json(['error' => 'Not found'], 404);
                $this->json(['post' => $post]);
                break;

            // ── CREATE ──────────────────────────────────────────────
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    $this->json(['error' => 'POST required'], 405);
                }
                $title = trim($_POST['title'] ?? '');
                if ($title === '') $this->json(['error' => 'Title is required'], 400);

                $imageFile = (!empty($_FILES['image']['name'])) ? $_FILES['image'] : null;
                $id = $this->model->create($_POST, $imageFile);
                $this->json(['success' => true, 'id' => $id]);
                break;

            // ── UPDATE ──────────────────────────────────────────────
            case 'update':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    $this->json(['error' => 'POST required'], 405);
                }
                $id    = (int) ($_GET['id'] ?? 0);
                $title = trim($_POST['title'] ?? '');
                if (!$id)      $this->json(['error' => 'ID required'], 400);
                if ($title === '') $this->json(['error' => 'Title is required'], 400);

                $imageFile = (!empty($_FILES['image']['name'])) ? $_FILES['image'] : null;
                $ok = $this->model->update($id, $_POST, $imageFile);
                $ok ? $this->json(['success' => true]) : $this->json(['error' => 'Post not found'], 404);
                break;

            // ── DELETE ──────────────────────────────────────────────
            case 'delete':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    $this->json(['error' => 'POST required'], 405);
                }
                $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
                if (!$id) $this->json(['error' => 'ID required'], 400);

                $ok = $this->model->delete($id);
                $ok ? $this->json(['success' => true]) : $this->json(['error' => 'Post not found'], 404);
                break;

            default:
                $this->json(['error' => 'Unknown action'], 400);
        }
    }
}
