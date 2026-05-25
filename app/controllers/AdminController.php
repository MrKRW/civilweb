<?php
/**
 * CivilLanka MVC – AdminController
 * Handles: admin dashboard page, and /api/settings JSON API.
 */
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/AdminUserModel.php';

class AdminController extends Controller
{
    private AdminUserModel $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new AdminUserModel();
    }

    /** GET /admin – dashboard (requires auth) */
    public function dashboard(): void
    {
        $this->requireAdmin();
        $adminName = $_SESSION['admin_name'] ?? 'Admin';
        $adminUser = $_SESSION['admin_user'] ?? 'admin';
        $this->render('admin/dashboard', [
            'adminName' => $adminName,
            'adminUser' => $adminUser,
        ], null); // null = no layout (dashboard has its own full page structure)
    }

    /** /api/settings – password change API (replaces api/settings.php) */
    public function apiSettings(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if (empty($_SESSION['admin_id'])) {
            $this->json(['error' => 'Unauthorized'], 401);
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'POST required'], 405);
        }

        $currentPw = $_POST['current_password'] ?? '';
        $newPw     = $_POST['new_password']     ?? '';
        $confirmPw = $_POST['confirm_password'] ?? '';

        if ($currentPw === '' || $newPw === '' || $confirmPw === '') {
            $this->json(['error' => 'All fields are required'], 400);
        }
        if ($newPw !== $confirmPw) {
            $this->json(['error' => 'Passwords do not match'], 400);
        }
        if (strlen($newPw) < 6) {
            $this->json(['error' => 'Password must be at least 6 characters'], 400);
        }

        $user = $this->model->findById((int) $_SESSION['admin_id']);
        if (!$user || !$this->model->verifyPassword($currentPw, $user['password'])) {
            $this->json(['error' => 'Current password is incorrect'], 403);
        }

        $this->model->updatePassword((int) $_SESSION['admin_id'], $newPw);
        $this->json(['success' => true]);
    }
}
