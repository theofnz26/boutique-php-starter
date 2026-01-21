<?php
$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/produits', [ProductController::class, 'index']);

// AVANT : $router->get('/produit', ...);
// MAINTENANT : On utilise le paramètre dynamique {id}
$router->get('/produit/{id}', [ProductController::class, 'show']);

return $router;