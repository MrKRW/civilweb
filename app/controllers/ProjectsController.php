<?php
/**
 * CivilLanka MVC – ProjectsController
 * Handles: public projects page, project detail, and /api/projects JSON API.
 */
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/ProjectModel.php';

class ProjectsController extends Controller
{
    private ProjectModel $model;

    public function __construct()
    {
        $this->model = new ProjectModel();
    }

    /** GET /projects – public projects listing page */
    public function index(): void
    {
        $this->render('projects/index', [], 'main');
    }

    /** GET /projects/{id} – public project detail page */
    public function detail(string $id): void
    {
        $project = $this->model->getById((int) $id);
        if (!$project) {
            http_response_code(404);
            echo '<!DOCTYPE html><html><body><h1>Project not found</h1></body></html>';
            return;
        }
        $this->render('projects/detail', ['project' => $project], 'main');
    }

    /** /api/projects – JSON API endpoint (replaces api/projects.php) */
    public function api(): void
    {
        ob_start();

        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json; charset=utf-8');

        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        $publicActions = ['list', 'get', 'featured', 'create', 'update'];

        if (!in_array($action, $publicActions) && empty($_SESSION['admin_id'])) {
            ob_clean();
            $this->json(['error' => 'Unauthorized'], 401);
        }

        try {
            switch ($action) {
                case 'list':
                    $projects = $this->model->getAll([
                        'category' => $_GET['category'] ?? '',
                        'status'   => $_GET['status']   ?? '',
                        'featured' => $_GET['featured']  ?? '',
                    ]);
                    ob_clean();
                    $this->json(['projects' => $projects]);
                    break;

                case 'get':
                    $id = (int) ($_GET['id'] ?? 0);
                    $p  = $this->model->getById($id);
                    ob_clean();
                    if (!$p) $this->json(['error' => 'Not found'], 404);
                    $this->json(['project' => $p]);
                    break;

                case 'featured':
                    ob_clean();
                    $this->json(['projects' => $this->model->getFeatured()]);
                    break;

                case 'create':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ob_clean(); $this->json(['error' => 'POST required'], 405); }
                    $title = trim($_POST['title'] ?? '');
                    if ($title === '') { ob_clean(); $this->json(['error' => 'Title is required'], 400); }
                    $newId = $this->model->create($_POST, $_FILES['image_main'] ?? null, $_FILES['image_gallery'] ?? []);
                    ob_clean();
                    $this->json(['success' => true, 'id' => $newId], 201);
                    break;

                case 'update':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ob_clean(); $this->json(['error' => 'POST required'], 405); }
                    $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
                    if (!$id) { ob_clean(); $this->json(['error' => 'ID required'], 400); }
                    $remove = json_decode($_POST['remove_gallery'] ?? '[]', true) ?: [];
                    $ok = $this->model->update($id, $_POST, $_FILES['image_main'] ?? null, $_FILES['image_gallery'] ?? [], $remove);
                    ob_clean();
                    if (!$ok) $this->json(['error' => 'Not found'], 404);
                    $this->json(['success' => true]);
                    break;

                case 'delete':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ob_clean(); $this->json(['error' => 'POST required'], 405); }
                    $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
                    if (!$id) { ob_clean(); $this->json(['error' => 'ID required'], 400); }
                    ob_clean();
                    if (!$this->model->delete($id)) $this->json(['error' => 'Not found'], 404);
                    $this->json(['success' => true]);
                    break;

                case 'toggle_featured':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ob_clean(); $this->json(['error' => 'POST required'], 405); }
                    $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
                    $this->model->toggleFeatured($id);
                    ob_clean();
                    $this->json(['success' => true]);
                    break;

                case 'toggle_status':
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ob_clean(); $this->json(['error' => 'POST required'], 405); }
                    $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
                    $this->model->toggleStatus($id);
                    ob_clean();
                    $this->json(['success' => true]);
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
