<?php

namespace App;

class Router
{
    /**
     * @var array<string, array<string, array<int, string>>>
     */
    private array $routes = [];

    /**
     * @param array<int, string> $action
     */
    public function get(string $path, array $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    /**
     * @param array<int, string> $action
     */
    public function post(string $path, array $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$method][$path])) {
            [$controller, $action] = $this->routes[$method][$path];
            (new $controller())->$action();
            return;
        }

        // Gestion des routes dynamiques et 404...
        // (Laisse ton code existant ici pour le dispatch dynamique si tu l'as gardé)

        foreach ($this->routes[$method] ?? [] as $routePath => $action) {
            if (strpos($routePath, '{') === false) {
                continue;
            }
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $routePath);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                [$controllerName, $methodName] = $action;
                $controller = new $controllerName();
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }

        http_response_code(404);
        echo '<h1>404 - Page Introuvable</h1>';
    }
}
