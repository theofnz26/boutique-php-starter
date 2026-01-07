<?php

// LES DONNÉES


// Je déclare une variable $catalogue qui est un grand tableau ([]).
// Ce tableau va contenir la liste de tous mes produits.
$catalogue = [

    // PRODUIT 0 
    // J'ouvre un sous-tableau pour mon premier produit (Index 0)
    [
        "nom" => "T-Shirt Geek",
        "prix" => 19.99,
        "stock" => 50,
        "image" => "/var/www/boutique/assets/images/pull.png"
    ], // Je ferme le sous-tableau du produit 0 et je mets une virgule pour passer au suivant

    // PRODUIT 1
    // J'ouvre un sous-tableau pour mon deuxième produit (Index 1)
    [
        "nom" => "Tasse Café",
        "prix" => 9.50,
        "stock" => 120,
        "image" => "/var/www/boutique/assets/images/mug.png"
    ], // Fin du produit 1

    // PRODUIT 2
    // J'ouvre le produit à l'Index 2
    [
        "nom" => "Clavier Mécanique",
        "prix" => 89.90,
        "stock" => 10,
        "image" => "/var/www/boutique/assets/images/clavier.png"
    ], 

    // PRODUIT 3
    // J'ouvre le produit à l'Index 3
    [
        "nom" => "Souris Gaming",
        "prix" => 45.00,
        "stock" => 25,
        "image" => "/var/www/boutique/assets/images/souris gaming.png"
    ],

    // PRODUIT 4
    // J'ouvre le produit à l'Index 4
    [
        "nom" => "Écran 4K",
        "prix" => 299.99,
        "stock" => 5,
        "image" => "/var/www/boutique/assets/images/ecran.png"
    ],

    // PRODUIT 5
    // J'ouvre le dernier produit à l'Index 5
    [
        "nom" => "Casque Audio",
        "prix" => 59.00,
        "stock" => 0, // Stock épuisé pour tester
        "image" => "/var/www/boutique/assets/images/casque gaming.png"
    ]

]; // Je ferme ici le grand tableau $catalogue avec un point-virgule final

// Je ferme la balise PHP car je vais passer au HTML
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Catalogue</title>
    <style>
        /* Je dis que le body doit utiliser une police sans empattement */
        body { font-family: sans-serif; padding: 20px; }
        /* Je crée une grille pour afficher les produits côte à côte (Optionnel mais joli) */
        .container { display: flex; flex-wrap: wrap; gap: 20px; }
        /* Je donne un style de "carte" à chaque produit (bordure, padding, largeur) */
        .produit { border: 1px solid #ddd; padding: 15px; width: 200px; border-radius: 8px; text-align: center; }
        /* Je définis la taille de l'image pour qu'elle ne dépasse pas */
        .produit img { max-width: 100%; border-radius: 5px; }
        /* Je mets le prix en vert et en gras */
        .prix { color: green; font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>

    <h1>Bienvenue sur le dropshipping de Theo !</h1>

    <div class="container">

        <div class="produit">
            <img src="<?= $catalogue[0]["image"] ?>" alt="Image produit">
            
            <h2><?= $catalogue[0]["nom"] ?></h2>
            
            <p class="prix"><?= number_format($catalogue[0]["prix"], 2, ',', ' ') ?> €</p>
            
            <p>Stock : <?= $catalogue[0]["stock"] ?></p>
        </div>


        <div class="produit">
            <img src="<?= $catalogue[1]["image"] ?>" alt="Image produit">
            <h2><?= $catalogue[1]["nom"] ?></h2>
            <p class="prix"><?= number_format($catalogue[1]["prix"], 2, ',', ' ') ?> €</p>
            <p>Stock : <?= $catalogue[1]["stock"] ?></p>
        </div>


        <div class="produit">
            <img src="<?= $catalogue[2]["image"] ?>" alt="Image produit">
            <h2><?= $catalogue[2]["nom"] ?></h2>
            <p class="prix"><?= number_format($catalogue[2]["prix"], 2, ',', ' ') ?> €</p>
            <p>Stock : <?= $catalogue[2]["stock"] ?></p>
        </div>


        <div class="produit">
            <img src="<?= $catalogue[3]["image"] ?>" alt="Image produit">
            <h2><?= $catalogue[3]["nom"] ?></h2>
            <p class="prix"><?= number_format($catalogue[3]["prix"], 2, ',', ' ') ?> €</p>
            <p>Stock : <?= $catalogue[3]["stock"] ?></p>
        </div>


        <div class="produit">
            <img src="<?= $catalogue[4]["image"] ?>" alt="Image produit">
            <h2><?= $catalogue[4]["nom"] ?></h2>
            <p class="prix"><?= number_format($catalogue[4]["prix"], 2, ',', ' ') ?> €</p>
            <p>Stock : <?= $catalogue[4]["stock"] ?></p>
        </div>


        <div class="produit">
            <img src="<?= $catalogue[5]["image"] ?>" alt="Image produit">
            <h2><?= $catalogue[5]["nom"] ?></h2>
            <p class="prix"><?= number_format($catalogue[5]["prix"], 2, ',', ' ') ?> €</p>
            <p>Stock : <?= $catalogue[5]["stock"] ?></p>
        </div>

    </div> </body>
</html>