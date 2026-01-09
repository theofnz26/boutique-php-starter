<?php
// 1. LA BASE DE DONNÉES (10 produits variés)
$products = [
    ["nom" => "T-shirt Rouge",  "prix" => 15.00,  "stock" => 10, "categorie" => "Vêtement"],
    ["nom" => "Jean Slim",      "prix" => 55.00,  "stock" => 5,  "categorie" => "Vêtement"], // Trop cher (>50)
    ["nom" => "Casquette",      "prix" => 12.00,  "stock" => 0,  "categorie" => "Accessoire"], // Rupture
    ["nom" => "Montre Luxe",    "prix" => 150.00, "stock" => 2,  "categorie" => "Accessoire"], // Trop cher
    ["nom" => "Chaussettes",    "prix" => 5.00,   "stock" => 50, "categorie" => "Vêtement"],
    ["nom" => "Sac à dos",      "prix" => 45.00,  "stock" => 0,  "categorie" => "Accessoire"], // Rupture
    ["nom" => "Ceinture",       "prix" => 20.00,  "stock" => 8,  "categorie" => "Accessoire"],
    ["nom" => "Baskets",        "prix" => 80.00,  "stock" => 12, "categorie" => "Chaussures"], // Trop cher
    ["nom" => "Lacets",         "prix" => 3.50,   "stock" => 100,"categorie" => "Chaussures"],
    ["nom" => "Bonnet",         "prix" => 18.00,  "stock" => 0,  "categorie" => "Vêtement"], // Rupture
];

// Préparation des compteurs
$totalProduits = count($products);
$produitsTrouves = 0; // On part de 0
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Filtrer le catalogue</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .produit { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
        .success { color: green; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Résultats de la recherche</h1>
    <p>Critères : En stock + Moins de 50€</p>

    <div class="liste">
        
        <?php foreach ($products as $product): ?>

            <?php 
            // --- LOGIQUE DE FILTRAGE (Le Tamis) ---
            
            // 1. Si le stock est vide... on zappe !
            if ($product['stock'] <= 0) {
                continue; 
            }

            // 2. Si le prix est trop élevé... on zappe !
            if ($product['price'] >= 50) {
                continue;
            }

            // Si on arrive ici, c'est que le produit est VALIDE !
            $produitsTrouves++; // On ajoute 1 au compteur
            ?>

            <div class="produit">
                <h3><?= $product['nom'] ?></h3>
                <p>Prix : <?= $product['prix'] ?> €</p>
                <p>Stock : <?= $product['stock'] ?></p>
            </div>

        <?php endforeach; ?>

    </div>

    <hr>
    <h2 class="success">
        <?= $produitsTrouves ?> produits trouvés sur <?= $totalProduits ?> au total.
    </h2>

</body>
</html>