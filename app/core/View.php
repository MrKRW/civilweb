<?php
/**
 * CivilLanka MVC – View Renderer
 */
class View
{
    /**
     * Render a view, optionally wrapped in a layout.
     *
     * @param string      $view    e.g. 'home/index'  → app/views/home/index.php
     * @param array       $data    Variables passed to both layout and view
     * @param string|null $layout  e.g. 'main'        → app/views/layouts/main.php
     */
    public static function render(string $view, array $data = [], ?string $layout = 'main'): void
    {
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View not found: {$viewFile}";
            return;
        }

        // Extract data variables into local scope
        extract($data, EXTR_SKIP);

        // Capture view content
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout === null) {
            // No layout — output view directly
            echo $content;
            return;
        }

        $layoutFile = __DIR__ . '/../views/layouts/' . $layout . '.php';
        if (!file_exists($layoutFile)) {
            // Fallback: output content without layout
            echo $content;
            return;
        }

        // Render layout with $content available
        require $layoutFile;
    }
}
