<?php
/**
 * CivilLanka MVC – ShopController
 * Handles: public shop page, product detail, and /api/shop JSON API.
 */
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/ShopModel.php';

class ShopController extends Controller
{
    private ShopModel $model;

    public function __construct()
    {
        $this->model = new ShopModel();
    }

    /** GET /shop – public shop listing */
    public function index(): void
    {
        $this->render('shop/index', [], 'main');
    }

    /** GET /shop/product/{id} – public product detail */
    public function product(string $id): void
    {
        $item = $this->model->getById((int) $id);
        if (!$item) {
            http_response_code(404);
            echo '<!DOCTYPE html><html><body><h1>Product not found</h1></body></html>';
            return;
        }
        $pid = (int) $item['id'];
        $reviews      = $this->model->getReviews($pid);
        $reviewCount  = count($reviews);
        $avgRating    = $this->model->getAverageRating($pid);
        $this->render('shop/product', [
            'item'        => $item,
            'reviews'     => $reviews,
            'reviewCount' => $reviewCount,
            'avgRating'   => $avgRating,
        ], 'main');
    }

    /** /api/shop – JSON API endpoint (replaces api/shop.php) */
    public function api(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json; charset=utf-8');

        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        $publicActions = ['list', 'get', 'get_reviews', 'add_review'];

        if (!in_array($action, $publicActions) && empty($_SESSION['admin_id'])) {
            $this->json(['error' => 'Unauthorized'], 401);
        }

        switch ($action) {
            case 'list':
                $this->json(['items' => $this->model->getAll()]);
                break;

            case 'get':
                $id   = (int) ($_GET['id'] ?? 0);
                $item = $this->model->getById($id);
                if (!$item) $this->json(['error' => 'Not found'], 404);
                $this->json(['item' => $item]);
                break;

            case 'create':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->json(['error' => 'POST required'], 405);
                $title = trim($_POST['title'] ?? '');
                if ($title === '') $this->json(['error' => 'Title is required'], 400);
                $newId = $this->model->create(
                    $_POST,
                    $_FILES['image'] ?? null,
                    $_FILES['gallery_images'] ?? [],
                    $_FILES['additional_info_images'] ?? []
                );
                $this->json(['success' => true, 'id' => $newId], 201);
                break;

            case 'update':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->json(['error' => 'POST required'], 405);
                $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
                if (!$id) $this->json(['error' => 'ID required'], 400);
                $remove      = json_decode($_POST['remove_gallery'] ?? '[]', true) ?: [];
                $removeAddl  = json_decode($_POST['remove_additional_info_images'] ?? '[]', true) ?: [];
                $ok = $this->model->update(
                    $id, $_POST,
                    $_FILES['image'] ?? null,
                    $_FILES['gallery_images'] ?? [],
                    $remove,
                    $_FILES['additional_info_images'] ?? [],
                    $removeAddl
                );
                if (!$ok) $this->json(['error' => 'Not found'], 404);
                $this->json(['success' => true]);
                break;

            case 'delete':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->json(['error' => 'POST required'], 405);
                $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
                if (!$id) $this->json(['error' => 'ID required'], 400);
                if (!$this->model->delete($id)) $this->json(['error' => 'Not found'], 404);
                $this->json(['success' => true]);
                break;

            case 'get_reviews':
                $id = (int) ($_GET['id'] ?? 0);
                if (!$id) $this->json(['error' => 'ID required'], 400);
                $this->json([
                    'reviews'   => $this->model->getReviews($id),
                    'count'     => $this->model->getReviewCount($id),
                    'avgRating' => $this->model->getAverageRating($id),
                ]);
                break;

            case 'add_review':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->json(['error' => 'POST required'], 405);
                $pid    = (int) ($_POST['product_id'] ?? 0);
                $name   = trim($_POST['name']   ?? '');
                $email  = trim($_POST['email']  ?? '');
                $rating = (int) ($_POST['rating'] ?? 0);
                $text   = trim($_POST['review_text'] ?? '');
                if (!$pid)   $this->json(['error' => 'product_id required'], 400);
                if (!$name)  $this->json(['error' => 'Name is required'], 400);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $this->json(['error' => 'Valid email required'], 400);
                if ($rating < 1 || $rating > 5) $this->json(['error' => 'Rating 1-5 required'], 400);
                if (strlen($text) < 10) $this->json(['error' => 'Review must be at least 10 characters'], 400);
                $newId = $this->model->addReview($pid, $name, $email, $rating, $text);
                $this->json(['success' => true, 'id' => $newId], 201);
                break;

            default:
                $this->json(['error' => 'Unknown action'], 400);
        }
    }
}
