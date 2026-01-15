<?php


require_once 'Product.php';

$products = [
    ["id" => 1, 
    "name" => "Display Yu-gi-oh !", 
    "price" => 80, 
    "category" => "carte", 
    "stock" => 20, 
    "description" => "Boite de 24 booster"],


    ["id" => 2, 
    "name" => "Deck de structure",  
    "price" => 13, 
    "category" => "Deck", 
    "stock" => 30, 
    "description" => "Deck fait pour jouer directement"],


    ["id" => 3, 
    "name" => "Triple Deck",        
    "price" => 25, 
    "category" => "Deck", 
    "stock" => 10, 
    "description" => "Ensemble de 3 deck de structure"], 

    ["id" => 4, 
    "name" => "Tapis de jeu",       
    "price" => 20, 
    "category" => "Accessoire", 
    "stock" => 0, 
    "description" => "Tapis de jeu officiel"],


    ["id" => 5, 
    "name" => "protection de carte",
    "price" => 4,  
    "category" => "Accessoire", 
    "stock" => 20, 
    "description" => "Sleeve en plastique pour proteger vos cartes"],


    ["id" => 6, 
    "name" => "deck box",           
    "price" => 10, 
    "category" => "Accessoire", 
    "stock" => 8, 
    "description" => "Boite de rangement pour vos decks"],

    ["id" => 7, 
    "name" => "booster Yu-gi-oh !", 
    "price" => 4,
    "category" => "carte", 
    "stock" => 50,
    "description" => "Contient 9 cartes jouables"],


    ["id" => 8, 
    "name" => "Tin Box Yu-gi-oh ! 2025",
    "price" => 20, 
    "category" => "carte", 
    "stock" => 20, 
    "description" => "Boite de 3 booster"],
];
// --- INITIALISATION DES COMPTEURS (Accumulateurs) ---
$totalStock = 0;
$totalValue = 0; // Valeur totale (Prix * Quantité pour chaque produit)

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boutique Yu-Gi-Oh!</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f0f0f0; }
        h1 { text-align: center; color: #333; }
        .stats { background: #333; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .card { background: white; padding: 20px; border-radius: 10px; width: 250px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .out-of-stock { opacity: 0.6; background: #ffe6e6; }
        .price { font-weight: bold; color: green; font-size: 1.2em; }
        .stock-ok { color: blue; font-size: 0.9em; }
        .stock-ko { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>🔥 Catalogue Yu-Gi-Oh!</h1>

    <div class="container">

    <?php
   
    foreach ($products as $data) {

        // Création de l'objet
        $product = new Product(
            $data['id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['category']
        );

        // CALCULS (Mise à jour des accumulateurs)
        $totalStock += $product->stock; // On ajoute le stock de ce produit au total
        $totalValue += ($product->price * $product->stock); // Valeur = Prix x Quantité

        // LOGIQUE D'AFFICHAGE
        $cssClass = $product->isInStock() ? 'card' : 'card out-of-stock';
        ?>

        <div class="<?= $cssClass ?>">
            <h3><?= $product->name ?></h3>
            <p style="color: gray; font-style: italic;"><?= $product->category ?></p>
            <p><?= $product->description ?></p>
            
            <p class="price">
                <?= $product->getPriceIncludingTax() ?> € TTC
                <small style="color: #666; font-size: 0.8em;">(<?= $product->price ?> € HT)</small>
            </p>

            <p>
                <?php if ($product->isInStock()): ?>
                    <span class="stock-ok">✅ En stock (<?= $product->stock ?>)</span>
                <?php else: ?>
                    <span class="stock-ko">❌ Rupture de stock</span>
                <?php endif; ?>
            </p>
        </div>

    <?php 
    } // Fin du foreach
    ?>
    
    </div>

    <hr>
    <div class="stats">
        <h2>📊 Statistiques de l'inventaire</h2>
        <p>Nombre total d'articles en stock : <strong><?= $totalStock ?></strong></p>
        <p>Valeur totale du stock (HT) : <strong><?= number_format($totalValue, 2, ',', ' ') ?> €</strong></p>
    </div>

</body>
</html>