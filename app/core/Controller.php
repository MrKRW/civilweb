<?php
/**
 * CivilLanka MVC – Base Controller
 */
require_once __DIR__ . '/View.php';
require_once __DIR__ . '/../../config/db.php';

abstract class Controller
{
    /**
     * Render a view with an optional layout.
     *
     * @param string       $view     Path relative to app/views/ e.g. 'home/index'
     * @param array        $data     Variables passed to the view
     * @param string|null  $layout   Layout name under app/views/layouts/ (null = no layout)
     */
    protected function render(string $view, array $data = [], ?string $layout = 'main'): void
    {
        View::render($view, $data, $layout);
    }

    /**
     * Send a JSON response and exit.
     */
    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Redirect to a URL.
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Require admin authentication. Redirects to login if not authenticated.
     */
    protected function requireAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['admin_id'])) {
            $this->redirect('/civilweb/admin/login');
        }
    }
}
