<?php

require_once 'Category.php';
require_once 'Product.php';
require_once 'CartItem.php';
require_once 'Cart.php';


$cat = new Category(1, "Sports");
$ballon = new Product(1, "Ballon", 10, $cat);
$raquette = new Product(2, "Raquette", 50, $cat);
$filet = new Product(3, "Filet", 30, $cat);

$cart = new Cart();


$cart->add($ballon, 2)       // J'ajoute 2 ballons
     ->add($raquette, 1)     // PUIS j'ajoute 1 raquette
     ->add($filet, 1)        // PUIS j'ajoute 1 filet
     ->remove(1)             // PUIS je retire le ballon (ID 1) finalement
     ->update(2, 5);         // PUIS je change d'avis, je veux 5 raquettes !

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jour 9 - Fluent Interface</title>
</head>
<body>
    <h1>Test du "Fluent Interface"</h1>
    <p>Si le résultat ci-dessous s'affiche sans erreur PHP, c'est que le chaînage fonctionne !</p>
    
    <div style="background: #f0f0f0; padding: 20px; border-radius: 10px;">
        <h3>Contenu du panier :</h3>
        <ul>
            <?php foreach ($cart->getItems() as $item): ?>
                <li>
                    <?= $item->product->name ?> (x<?= $item->quantity ?>)
                </li>
            <?php endforeach; ?>
        </ul>
        
        <hr>
        <strong>Total : <?= $cart->getTotal() ?> €</strong>
    </div>
</body>
</html>