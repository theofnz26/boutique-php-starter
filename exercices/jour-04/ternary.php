<?php

$product = [
    "name"   => "Chaussures Sport",
    "price"  => 80,
    "stock"  => 0,    // Change à 10 pour voir la couleur changer
    "onSale" => true  // Change à false pour cacher la promo
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice Ternaire</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .product { padding: 20px; border-radius: 8px; width: 300px;}
        
        /* Les classes qui changent selon le ternaire */
        .rupture { border: 4px solid red; background-color: #ffe6e6; }
        .disponible { border: 4px solid green; background-color: #e6fffa; }
        
        del { color: #999; }
        .prix-promo { color: red; font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>

    <div class="product <?= ($product['stock'] > 0) ? 'disponible' : 'rupture' ?>">

        <h3>
            <?= $product['name'] ?>
            
            <?= ($product['onSale'] === true) ? '🔥 PROMO' : '' ?>
        </h3>

        <p>
            <?php 
            // Si en promo : Prix barré + Prix * 0.8
            // Sinon : Juste le prix
            echo ($product['onSale'] === true) 
                ? '<del>' . $product['price'] . '€</del> <span class="prix-promo">' . ($product['price'] * 0.8) . '€</span>' 
                : $product['price'] . '€';
            ?>
        </p>
        
        <p>Stock : <?= $product['stock'] ?></p>

    </div>

</body>
</html>