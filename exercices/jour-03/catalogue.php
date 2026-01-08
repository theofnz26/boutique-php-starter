<?php

$products = [
    [
        "nom" => "Montre Connectée",
        "prix" => 49.99,
        "stock" => 10,
        "image" => "https://picsum.photos/id/1/200/200"
    ],
    [
        "nom" => "Sac à dos",
        "prix" => 29.50,
        "stock" => 0, // Stock à 0 pour tester la rupture
        "image" => "https://picsum.photos/id/10/200/200"
    ],
    [
        "nom" => "Casque Audio",
        "prix" => 89.00,
        "stock" => 5,
        "image" => "https://picsum.photos/id/3/200/200"
    ],
    [
        "nom" => "Appareil Photo",
        "prix" => 450.00,
        "stock" => 2,
        "image" => "https://picsum.photos/id/4/200/200"
    ],
    [
        "nom" => "Baskets",
        "prix" => 55.00,
        "stock" => 12,
        "image" => "https://picsum.photos/id/5/200/200"
    ],
    [
        "nom" => "Lunettes",
        "prix" => 15.00,
        "stock" => 0, // Rupture
        "image" => "https://picsum.photos/id/6/200/200"
    ],
    [
        "nom" => "Lampe",
        "prix" => 22.90,
        "stock" => 8,
        "image" => "https://picsum.photos/id/7/200/200"
    ],
    [
        "nom" => "Carnet",
        "prix" => 5.50,
        "stock" => 50,
        "image" => "https://picsum.photos/id/8/200/200"
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue Jour 3</title>
    <style>
        /* CSS suggéré par l'énoncé (+ un peu de mise en forme basique) */
        body { font-family: sans-serif; padding: 20px; }
        
        .grille { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); /* 4 colonnes comme suggéré */
            gap: 20px; 
        }
        
        .produit { 
            border: 1px solid #ddd; 
            padding: 15px; 
            text-align: center;
        }

        .produit img { width: 100%; height: 150px; object-fit: cover; margin-bottom: 10px; }
        
        /* Classes demandées pour le bonus */
        .rupture { color: red; font-weight: bold; }
        .en-stock { color: green; }
    </style>
</head>
<body>

    <h1>Mon Catalogue (<?= count($products) ?> produits)</h1>

    <div class="grille">
        <?php foreach ($products as $product): ?>
            
            <div class="produit">
                <img src="<?= $product['image'] ?>" alt="Image produit">
                
                <h3><?= $product['nom'] ?></h3>
                
                <p>Prix : <strong><?= number_format($product['prix'], 2) ?> €</strong></p>
                
                <?php if ($product['stock'] > 0): ?>
                    <p class="en-stock">En stock (<?= $product['stock'] ?>)</p>
                <?php else: ?>
                    <p class="rupture">Rupture</p>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>
    </div>

</body>
</html>