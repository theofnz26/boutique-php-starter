<?php

namespace App\Controller;

use App\Repository\ProductRepository;

class CartController
{
    public function index(): void
    {
        $cart = $_SESSION['cart'] ?? [];
        $cartWithData = [];
        $total = 0;

        if (!empty($cart)) {
            $pdo = require __DIR__ . '/../../config/database.php';
            $repo = new ProductRepository($pdo);

            foreach ($cart as $id => $quantity) {
                $product = $repo->find($id);
                if ($product) {
                    $cartWithData[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $product->getPrice() * $quantity
                    ];
                    $total += $product->getPrice() * $quantity;
                }
            }
        }

        $title = 'Mon Panier';
        require __DIR__ . '/../../views/cart/index.php';
    }

    public function add(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        }
        header('Location: /panier');
        exit;
    }

    public function remove(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /panier');
        exit;
    }

    public function clear(): void
    {
        $_SESSION['cart'] = [];
        header('Location: /panier');
        exit;
    }
}
