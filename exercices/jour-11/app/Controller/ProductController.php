<?php
class ProductController
{
    private ProductRepository $repository;

    public function __construct()
    {
        // On récupère la connexion et on initialise le repository
        $pdo = require __DIR__ . '/../../config/database.php';
        $this->repository = new ProductRepository($pdo);
    }

    public function index(): void
    {
        // 1. Récupérer les produits
        $products = $this->repository->findAll();
        $title = "Nos Produits";

        // 2. Afficher la vue
        require __DIR__ . '/../../views/products/index.php';
    }

  


    public function show(int $id): void
    {
        // Plus besoin de $_GET['id'], la variable $id arrive toute seule !
        
        $product = $this->repository->find($id);

        if (!$product) {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>Produit introuvable</h1>";
            return;
        }

        $title = $product->getName();
        require __DIR__ . '/../../views/products/show.php';
    }
}
