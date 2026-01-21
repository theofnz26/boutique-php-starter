<?php
// On instancie le routeur
$router = new Router();

// --- LISTE DES ROUTES ---
$router->get('/', [HomeController::class, 'index']);

// On retourne l'objet router pour l'utiliser dans index.php
return $router;