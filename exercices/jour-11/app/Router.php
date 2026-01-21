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
        $path = parse_url($uri, PHP_URL_PATH);

        // 1. D'abord, on vérifie les routes exactes (comme avant)
        if (isset($this->routes[$method][$path])) {
            [$controller, $action] = $this->routes[$method][$path];
            (new $controller())->$action();
            return;
        }

        // 2. Ensuite, on cherche les routes dynamiques (Regex)
        foreach ($this->routes[$method] ?? [] as $routePath => $action) {
            // On vérifie si la route contient des paramètres {quelquechose}
            if (strpos($routePath, '{') === false) {
                continue;
            }

            // On transforme la route en Regex (Formule magique)
            // Ex: "/produit/{id}" devient "#^/produit/(?P<id>[^/]+)$#"
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $routePath);
            $pattern = "#^" . $pattern . "$#";

            // Si l'URL actuelle correspond au pattern
            if (preg_match($pattern, $path, $matches)) {
                
                // On nettoie $matches pour ne garder que les clés texte (id, slug...)
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                [$controllerName, $methodName] = $action;
                $controller = new $controllerName();
                
                // On appelle la méthode en lui passant les paramètres (ex: $id)
                // C'est ici que la magie opère : call_user_func_array
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }

        // 3. Si rien n'est trouvé
        http_response_code(404);
        echo "<h1>404 - Page Introuvable</h1>";
    }
}