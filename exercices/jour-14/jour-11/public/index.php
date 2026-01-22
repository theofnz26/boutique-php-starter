<?php

session_start();

// ON UTILISE L'AUTOLOADER DE COMPOSER !
require_once __DIR__ . '/../vendor/autoload.php';

$router = require_once __DIR__ . '/../config/routes.php';
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
header('Content-Type: text/html; charset=utf-8');

// 2. Autoloader
spl_autoload_register(function ($class) {
    $folders = [
        '../app/',
        '../app/Controller/',
        '../app/Repository/',
        '../app/Entity/'
    ];

    foreach ($folders as $folder) {
        $file = __DIR__ . '/' . $folder . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// 3. Routage
// On ne fait AUCUN echo ici. On laisse le routeur décider.
$router = require_once __DIR__ . '/../config/routes.php';
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
