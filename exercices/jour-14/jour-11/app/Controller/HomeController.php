<?php

namespace App\Controller;

class HomeController
{
    public function index(): void
    {
        $title = 'Accueil Boutique';
        // On inclut la vue
        require __DIR__ . '/../../views/home/index.php';
    }
}
