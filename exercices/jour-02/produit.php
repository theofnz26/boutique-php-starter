<?php
// 1. Création du tableau associatif (Clé => Valeur)
$product = [
    "name"        => "Nintendo Switch",
    "description" => "Console hybride pour jouer à la maison ou en déplacement.",
    "price"       => 299.00,
    "stock"       => 50,
    "category"    => "Jeux Vidéo",
    "brand"       => "Nintendo"
];

// 2. Manipulations (Logique)

// Ajout d'une nouvelle clé "dateAdded" avec la date d'aujourd'hui
$product["dateAdded"] = date("d/m/Y"); 

// Modification du prix (Remise de 10%)
// Nouveau prix = Ancien prix * 0.9
$product["price"] = $product["price"] * 0.9;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produit : <?= $product["name"] ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .card { border: 1px solid #ccc; padding: 20px; width: 300px; border-radius: 8px; }
        h1 { font-size: 20px; }
        .price { color: green; font-weight: bold; font-size: 1.2em; }
        small { color: #666; }
    </style>
</head>
<body>

    <div class="card">
        <h1><?= $product["name"] ?></h1>
        <p><strong>Marque :</strong> <?= $product["brand"] ?></p>
        
        <p class="price">
            <?= number_format($product["price"], 2, ',', ' ') ?> €
        </p>

        <p><?= $product["description"] ?></p>
        
        <hr>
        <small>Ajouté le : <?= $product["dateAdded"] ?></small>
        <br>
        <small>Stock : <?= $product["stock"] ?></small>
    </div>

</body>
</html>