<?php

require_once 'Category.php';
require_once 'Product.php';
require_once 'CartItem.php';

// 3 catégories
$catInformatique = new Category(1, "Informatique");
$catCuisine      = new Category(2, "Cuisine");
$catJardin       = new Category(3, "Jardinage");


$p1 = new Product(1, "PC Portable", 1200, $catInformatique);
$p2 = new Product(2, "Souris sans fil", 20, $catInformatique);
$p3 = new Product(3, "Mixeur 3000", 50, $catCuisine);
$p4 = new Product(4, "Pelle en fer", 15, $catJardin);
$p5 = new Product(5, "Tablier de Chef", 25, $catCuisine);


$products = [$p1, $p2, $p3, $p4, $p5];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jour 9 - Exercice 1</title>
</head>
<body>
    <h1>Liste des Produits et Catégories</h1>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <strong><?= $product->name ?></strong> 
                (<?= $product->price ?> €)
                <br>
                Catégorie : <span style="color: blue;"><?= $product->category->name ?></span>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
</body>
</html>