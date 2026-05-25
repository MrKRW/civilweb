<?php
/**
 * CivilLanka MVC – Router
 * Parses the request URI and dispatches to the matching controller + method.
 */
class Router
{
    /** @var array<string, array{controller:string, method:string}> */
    private array $routes = [];

    /** @var array<string, array{pattern:string, controller:string, method:string, paramName:string}> */
    private array $paramRoutes = [];

    /** @var string Base path of the app (e.g. /civilweb) */
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Register a static route.
     * @param string $path      e.g. '/about'
     * @param string $controller e.g. 'AboutController'
     * @param string $method     e.g. 'index'
     */
    public function add(string $path, string $controller, string $method = 'index'): void
    {
        $this->routes[$path] = ['controller' => $controller, 'method' => $method];
    }

    /**
     * Register a parameterised route with one {param}.
     * e.g. /projects/{id} → ProjectsController::detail($id)
     */
    public function addParam(string $path, string $controller, string $method, string $paramName): void
    {
        // Convert /projects/{id} → regex ^/projects/([^/]+)$
        $pattern = '#^' . preg_replace('/\{[^}]+\}/', '([^/]+)', $path) . '$#';
        $this->paramRoutes[] = [
            'pattern'    => $pattern,
            'controller' => $controller,
            'method'     => $method,
            'paramName'  => $paramName,
        ];
    }

    /**
     * Dispatch the current HTTP request.
     */
    public function dispatch(): void
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // Strip query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        // Strip base path prefix
        if ($this->basePath !== '' && str_starts_with($uri, $this->basePath)) {
            $uri = substr($uri, strlen($this->basePath));
        }

        $uri = '/' . ltrim($uri, '/');
        if ($uri !== '/' ) {
            $uri = rtrim($uri, '/');
        }

        // 1. Match static routes
        if (isset($this->routes[$uri])) {
            $this->invoke($this->routes[$uri]['controller'], $this->routes[$uri]['method']);
            return;
        }

        // 2. Match parameterised routes
        foreach ($this->paramRoutes as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                $this->invoke($route['controller'], $route['method'], [$matches[1]]);
                return;
            }
        }

        // 3. 404
        http_response_code(404);
        echo '<!DOCTYPE html><html><body><h1>404 – Page Not Found</h1><p><a href="/">Back to home</a></p></body></html>';
    }

    /**
     * Instantiate controller and call method.
     * @param list<mixed> $params
     */
    private function invoke(string $controllerName, string $method, array $params = []): void
    {
        $file = __DIR__ . '/../controllers/' . $controllerName . '.php';
        if (!file_exists($file)) {
            http_response_code(500);
            echo "Controller file not found: {$controllerName}";
            return;
        }
        require_once $file;

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo "Controller class not found: {$controllerName}";
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            http_response_code(500);
            echo "Method {$method} not found on {$controllerName}";
            return;
        }

        call_user_func_array([$controller, $method], $params);
    }
}
