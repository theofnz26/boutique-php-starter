<?php

require_once 'Category.php';
require_once 'Product.php';
require_once 'CartItem.php';
require_once 'Cart.php';

// --- MISE EN PLACE ---
$cat = new Category(1, "Fruits");
$pomme  = new Product(10, "Pomme", 1.00, $cat);  // ID 10
$banane = new Product(20, "Banane", 2.00, $cat); // ID 20
$fraise = new Product(30, "Fraise", 5.00, $cat); // ID 30

$cart = new Cart();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jour 9 - Exo 3</title>
    <style>body{font-family:sans-serif; padding:20px;} .step{background:#eee; padding:10px; margin-bottom:10px; border-radius:5px;} strong{color:blue;}</style>
</head>
<body>
    <h1>🛒 Test complet du Panier</h1>

    <div class="step">
        <h3>1. Remplissage initial</h3>
        <?php
        $cart->add($pomme, 2);   // 2€
        $cart->add($banane, 1);  // 2€
        $cart->add($fraise, 1);  // 5€
        echo "J'ai ajouté 2 Pommes, 1 Banane, 1 Fraise.<br>";
        ?>
        Total attendu (9€) : <strong><?= $cart->getTotal() ?> €</strong>
    </div>

    <div class="step">
        <h3>2. Modification (Update)</h3>
        <?php
        // On change la quantité des Pommes (ID 10) à 10
        $cart->update(10, 10);
        echo "Je change d'avis : je veux 10 Pommes !<br>";
        ?>
        Nouveau total (10€ + 2€ + 5€ = 17€) : <strong><?= $cart->getTotal() ?> €</strong>
    </div>

    <div class="step">
        <h3>3. Suppression (Remove)</h3>
        <?php
        // On supprime les fraises (ID 30)
        $cart->remove(30);
        echo "Je retire les Fraises (trop chères).<br>";
        ?>
        Nombre d'articles (devrait être 2) : <strong><?= $cart->count() ?></strong><br>
        Nouveau total (12€) : <strong><?= $cart->getTotal() ?> €</strong>
    </div>

    <div class="step">
        <h3>4. Vidage (Clear)</h3>
        <?php
        $cart->clear();
        echo "Je vide tout le panier.<br>";
        ?>
        Nombre d'articles : <strong><?= $cart->count() ?></strong>
    </div>

</body>
</html>