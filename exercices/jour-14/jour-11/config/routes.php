<?php

use App\Controller\CartController;
use App\Controller\HomeController;
use App\Controller\ProductController;
use App\Router;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/produits', [ProductController::class, 'index']);
$router->get('/produit/{id}', [ProductController::class, 'show']);
$router->get('/panier', [CartController::class, 'index']);
$router->post('/panier/ajouter', [CartController::class, 'add']);
$router->post('/panier/supprimer', [CartController::class, 'remove']);
$router->post('/panier/vider', [CartController::class, 'clear']);

return $router;
