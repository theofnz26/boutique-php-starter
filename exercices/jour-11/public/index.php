<?php
// public/index.php
session_start();

// --- AUTOLOADER ---
// Charge automatiquement les classes (Router, Controller, etc.)
spl_autoload_register(function ($class) {
    // Liste des dossiers où chercher les classes
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

// --- DEBUG ---
// Affiche l'URL demandée pour vérifier que ça marche
echo "<div style='background:#eee; padding:5px; border-bottom:1px solid #ccc'>";
echo "🔍 <strong>DEBUG:</strong> URI=" . htmlspecialchars($_SERVER['REQUEST_URI']);
echo " | Method=" . $_SERVER['REQUEST_METHOD'];
echo "</div>";

// --- ROUTAGE ---
// On charge les routes et on lance l'application
$router = require_once __DIR__ . '/../config/routes.php';
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);