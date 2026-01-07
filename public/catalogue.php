<?php
// FICHIER : public/catalogue.php

// On inclut les données (ça ne change pas)
require_once __DIR__ . '/../app/data.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Catalogue Automatisé</title>
    <style>
        /* (J'ai gardé le même CSS pour que tu voies la différence juste sur le code) */
        body { font-family: sans-serif; padding: 20px; background-color: #f4f4f9; }
        h1 { text-align: center; color: #333; }
        .container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; padding-top: 20px; }
        .produit { background: white; border: 1px solid #ddd; padding: 15px; width: 200px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .produit:hover { transform: translateY(-5px); }
        .produit img { max-width: 100%; height: auto; border-radius: 5px; }
        .produit h2 { font-size: 1.1em; margin: 10px 0; color: #444; }
        .prix { color: #27ae60; font-weight: bold; font-size: 1.2em; }
        .stock { color: #7f8c8d; font-size: 0.9em; }
    </style>
</head>
<body>

    <h1>Bienvenue sur le dropshipping de Theo ! (Version Boucle)</h1>

    <div class="container">

        <?php 
        // --- DÉBUT DE LA BOUCLE ---
        // On dit : Pour chaque élément du tableau $catalogue,
        // on le met temporairement dans une variable appelée $product.
        foreach ($catalogue as $product): 
        ?>

            <div class="produit">
                <img src="<?= $product['image'] ?>" alt="<?= $product['nom'] ?>">
                
                <h2><?= $product['nom'] ?></h2>
                
                <p class="prix"><?= number_format($product['prix'], 2, ',', ' ') ?> €</p>
                
                <?php if ($product['stock'] > 0): ?>
                    <p class="stock" style="color: green;">En stock : <?= $product['stock'] ?></p>
                <?php else: ?>
                    <p class="stock" style="color: red; font-weight: bold;">Rupture de stock !</p>
                <?php endif; ?>

            </div>

        <?php 
        // --- FIN DE LA BOUCLE ---
        // PHP remonte au début du "foreach" pour le produit suivant.
        endforeach; 
        ?>

    </div> 
</body>
</html>