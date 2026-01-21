<?php
class Router
{
    private array $routes = [];

    public function get(string $path, array $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, array $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch(string $uri, string $method): void
    {
        // Nettoyage de l'URI (ex: /produits?id=1 devient /produits)
        $path = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$method][$path])) {
            [$controllerName, $methodName] = $this->routes[$method][$path];
            
            // On instancie le contrôleur et on lance la méthode
            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            http_response_code(404);
            echo "<h1>404 - Page Introuvable</h1>";
            echo "<p>Le routeur n'a pas trouvé de correspondance pour : $path</p>";
        }
    }
}