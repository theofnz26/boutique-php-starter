<?php

// IMPORTATION DE TOUTES NOS CLASSES
require_once 'Category.php';
require_once 'Product.php';
require_once 'CartItem.php';
require_once 'Cart.php';
require_once 'Address.php';
require_once 'User.php';
require_once 'Order.php';

// --- ETAPE 1 : La Boutique (Catégories et Produits) ---
$cat = new Category(1, "Jeux Vidéo");
$jeu1 = new Product(1, "Elden Ring", 60.00, $cat);
$jeu2 = new Product(2, "Mario Kart", 45.00, $cat);

// --- ETAPE 2 : Le Client (User + Adresse) ---
$user = new User("Sacha du Bourg-Palette", "sacha@pkmn.com", new DateTime());
$user->addAddress(new Address("10 Route Victoire", "99000", "Kanto", "Japon"));

// --- ETAPE 3 : Le Shopping (Remplissage du Panier) ---
$cart = new Cart();
$cart->add($jeu1, 1); // 1 Elden Ring
$cart->add($jeu2, 2); // 2 Mario Kart
// Total attendu : 60 + (45*2) = 150€

// --- ETAPE 4 : La Commande (Validation du Panier) ---
// C'est ici que la magie opère : on transforme le Panier en Commande
$order = new Order(1001, $user, $cart);

// On simule que le paiement est passé
$order->setStatut("Payée ✅");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jour 9 - Exo 5 (Commande)</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        .invoice { border: 1px solid #ccc; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .total { text-align: right; font-size: 1.5em; color: green; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="invoice">
        <div class="header">
            <div>
                <h1>Commande #<?= $order->id ?></h1>
                <small>Date : <?= $order->date->format('d/m/Y H:i') ?></small><br>
                <small>Statut : <?= $order->statut ?></small>
            </div>
            <div style="text-align: right;">
                <strong>Client :</strong><br>
                <?= $order->user->nom ?><br>
                <?= $order->user->email ?>
            </div>
        </div>

        <h3>📦 Articles commandés (<?= $order->getItemCount() ?>)</h3>
        <ul>
            <?php foreach ($order->items as $item): ?>
                <li>
                    <strong><?= $item->product->name ?></strong> 
                    x <?= $item->quantity ?>
                    <span style="float: right;"><?= $item->getTotal() ?> €</span>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="total">
            Total à payer : <?= $order->getTotal() ?> €
        </div>
        
        <hr>
        <p><strong>📍 Livraison à :</strong><br>
        <?php 
            $addr = $order->user->getDefaultAddress();
            echo $addr ? $addr->getFullAddress() : "Pas d'adresse"; 
        ?>
        </p>
    </div>

</body>
</html>