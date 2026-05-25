<?php
/**
 * CivilLanka MVC – AuthController
 * Handles: admin login page, logout, and /api/auth JSON API.
 */
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/AdminUserModel.php';

class AuthController extends Controller
{
    private AdminUserModel $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new AdminUserModel();
    }

    /** GET /admin/login – render the login page */
    public function loginPage(): void
    {
        if (!empty($_SESSION['admin_id'])) {
            $this->redirect('/admin');
        }
        $this->render('admin/login', [], null); // no layout (standalone page)
    }

    /** GET /admin/logout */
    public function logout(): void
    {
        session_destroy();
        $this->redirect('/admin/login');
    }

    /** /api/auth – JSON API (replaces api/auth.php) */
    public function api(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $action = $_GET['action'] ?? $_POST['action'] ?? '';

        switch ($action) {
            case 'login':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    $this->json(['error' => 'POST required'], 405);
                }
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';

                if ($username === '' || $password === '') {
                    $this->json(['error' => 'Username and password are required'], 400);
                }

                $user = $this->model->findByUsername($username);
                if (!$user || !$this->model->verifyPassword($password, $user['password'])) {
                    $this->json(['error' => 'Invalid credentials'], 401);
                }

                $_SESSION['admin_id']   = $user['id'];
                $_SESSION['admin_user'] = $user['username'];
                $_SESSION['admin_name'] = $user['full_name'];

                $this->json(['success' => true, 'user' => $user['username']]);
                break;

            case 'logout':
                session_destroy();
                $this->json(['success' => true]);
                break;

            case 'check':
                if (!empty($_SESSION['admin_id'])) {
                    $this->json(['authenticated' => true, 'user' => $_SESSION['admin_user']]);
                }
                $this->json(['authenticated' => false], 401);
                break;

            default:
                $this->json(['error' => 'Unknown action'], 400);
        }
    }
}
