<?php

namespace App\Controller;

use App\Repository\ProductRepository;

class ProductController
{
    private ProductRepository $repository;

    public function __construct()
    {
        $pdo = require __DIR__ . '/../../config/database.php';
        $this->repository = new ProductRepository($pdo);
    }

    public function index(): void
    {
        $products = $this->repository->findAll();
        $title = 'Liste des Produits';
        require __DIR__ . '/../../views/products/index.php';
    }

    public function show(int $id): void
    {
        $product = $this->repository->find($id);

        if (!$product) {
            header('HTTP/1.0 404 Not Found');
            echo '<h1>Produit introuvable</h1>';
            return;
        }

        $title = $product->getName();
        require __DIR__ . '/../../views/products/show.php';
    }
}
