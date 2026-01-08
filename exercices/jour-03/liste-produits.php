<?php
// 1. D'ABORD, on définit les données (Le Cerveau)
$products = [
    [
        "nom" => "T-Shirt PHP",
        "prix" => 19.99,
        "stock" => 50
    ],
    [
        "nom" => "Mug React",
        "prix" => 12.50,
        "stock" => 10
    ],
    [
        "nom" => "Sticker Laptop",
        "prix" => 2.00,
        "stock" => 0 
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boutique</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f9f9f9; }
        .container { display: flex; gap: 20px; }
        article { 
            background: white; 
            border: 1px solid #ddd; 
            padding: 20px; 
            border-radius: 8px; 
            width: 200px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h3 { margin-top: 0; color: #333; }
        .prix { font-size: 1.2em; color: #27ae60; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Nos Produits</h1>
    
    <div class="container">

        <?php 
        // 2. ENSUITE, à l'intérieur du HTML, on lance la boucle
        foreach ($products as $product): 
        ?>
            
            <article>
                <h3> <?= $product['nom'] ?> </h3>
                <p class="prix"> <?= $product['prix'] ?> €</p>
                <p> Stock : <?= $product['stock'] ?> </p>
            </article>

        <?php endforeach; ?>

    </div>
</body>
</html>