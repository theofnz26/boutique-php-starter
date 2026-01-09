<?php
$products = [
    ["nom" => "T-shirt Rouge",  "prix" => 15.00,  "stock" => 10, "categorie" => "Vêtement", "image" => "https://picsum.photos/id/1/200/200", "new" => true, "discount" => 20],
    ["nom" => "Jean Slim",      "prix" => 55.00,  "stock" => 5,  "categorie" => "Vêtement", "image" => "https://picsum.photos/id/2/200/200", "new" => false, "discount" => 15], // Trop cher (>50)
    ["nom" => "Casquette",      "prix" => 12.00,  "stock" => 0,  "categorie" => "Accessoire", "image" => "https://picsum.photos/id/3/200/200", "new" => true, "discount" => 0], // Rupture
    ["nom" => "Montre Luxe",    "prix" => 150.00, "stock" => 2,  "categorie" => "Accessoire", "image" => "https://picsum.photos/id/4/200/200", "new" => false, "discount" => 15], // Trop cher
    ["nom" => "Chaussettes",    "prix" => 5.00,   "stock" => 50, "categorie" => "Vêtement", "image" => "https://picsum.photos/id/5/200/200", "new" => false, "discount" => 50],
    ["nom" => "Sac à dos",      "prix" => 45.00,  "stock" => 0,  "categorie" => "Accessoire", "image" => "https://picsum.photos/id/6/200/200", "new" => false, "discount" => 15], // Rupture
    ["nom" => "Ceinture",       "prix" => 20.00,  "stock" => 8,  "categorie" => "Accessoire", "image" => "https://picsum.photos/id/7/200/200", "new" => true, "discount" => 30],
    ["nom" => "Baskets",        "prix" => 80.00,  "stock" => 12, "categorie" => "Chaussures", "image" => "https://picsum.photos/id/8/200/200", "new" => false, "discount" => 15], // Trop cher
    ["nom" => "Lacets",         "prix" => 3.50,   "stock" => 100,"categorie" => "Chaussures", "image" => "https://picsum.photos/id/9/200/200", "new" => false, "discount" => 15],
    ["nom" => "Bonnet",         "prix" => 18.00,  "stock" => 0,  "categorie" => "Vêtement", "image" => "https://picsum.photos/id/10/200/200", "new" => false, "discount" => 30], // Rupture
];


// 2. LA LOGIQUE DES STATISTIQUES
// On prépare les compteurs à 0
$countStock = 0;
$countPromo = 0;
$countRupture = 0;

// On parcourt le tableau une première fois juste pour compter (Cerveau)
foreach ($products as $p) {
    if ($p['stock'] === 0) {
        $countRupture++;
    } else {
        $countStock++; // Si pas 0, c'est en stock
    }

    if ($p['discount'] > 0) {
        $countPromo++;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue Intelligent Jour 4</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background-color: #f9f9f9; }
        
        /* Stats Dashboard */
        .stats-bar {
            display: flex; gap: 20px; justify-content: center; margin-bottom: 30px;
        }
        .stat-box {
            background: white; padding: 15px 25px; border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center;
        }
        .stat-number { font-size: 1.5rem; font-weight: bold; display: block; }
        
        /* Grille */
        .grille { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
            gap: 25px; 
        }
        
        /* Carte Produit */
        .produit { 
            background: white; border-radius: 10px; overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: relative; /* Pour les badges absolus */
            display: flex; flex-direction: column;
        }
        
        .img-container { position: relative; }
        .produit img { width: 100%; height: 200px; object-fit: cover; }
        
        .info { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
        
        /* Badges */
        .badge {
            position: absolute; top: 10px; padding: 5px 10px; 
            color: white; font-weight: bold; font-size: 0.8rem; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .badge-new { background-color: #3498db; left: 10px; }
        .badge-promo { background-color: #e74c3c; right: 10px; }
        .badge-last { background-color: #f39c12; bottom: 10px; right: 10px; } /* Attention à la position */

        /* Prix */
        .prix-box { margin: 10px 0; font-size: 1.1rem; }
        .old-price { text-decoration: line-through; color: #999; font-size: 0.9rem; margin-right: 5px; }
        .final-price { color: #2ecc71; font-weight: bold; }
        
        /* Actions */
        .stock-status { margin-bottom: 15px; font-size: 0.9rem; }
        .rupture { color: #e74c3c; font-weight: bold; }
        .last-items { color: #e67e22; font-weight: bold; }
        .en-stock { color: #2ecc71; }

        button {
            width: 100%; padding: 10px; border: none; border-radius: 5px;
            font-weight: bold; cursor: pointer; transition: 0.3s;
        }
        .btn-add { background-color: #2c3e50; color: white; }
        .btn-add:hover { background-color: #1a252f; }
        .btn-disabled { background-color: #bdc3c7; color: #7f8c8d; cursor: not-allowed; }

    </style>
</head>
<body>

    <h1 style="text-align: center">🛍️ Catalogue Intelligent</h1>

    <div class="stats-bar">
        <div class="stat-box">
            <span class="stat-number" style="color: green"><?= $countStock ?></span>
            En stock
        </div>
        <div class="stat-box">
            <span class="stat-number" style="color: red"><?= $countPromo ?></span>
            En promo
        </div>
        <div class="stat-box">
            <span class="stat-number" style="color: grey"><?= $countRupture ?></span>
            Ruptures
        </div>
    </div>

    <div class="grille">
        <?php foreach ($products as $product): ?>
            
            <div class="produit">
                <div class="img-container">
                    <img src="<?= $product['image'] ?>" alt="Image produit">
                    
                    <?php if ($product['new'] === true): ?>
                        <span class="badge badge-new">NOUVEAU</span>
                    <?php endif; ?>

                    <?php if ($product['discount'] > 0): ?>
                        <span class="badge badge-promo">-<?= $product['discount'] ?>%</span>
                    <?php endif; ?>
                </div>
                
                <div class="info">
                    <h3><?= $product['nom'] ?></h3>
                    
                    <div class="prix-box">
                        <?php if ($product['discount'] > 0): ?>
                            <?php $newPrice = $product['prix'] * (1 - $product['discount'] / 100); ?>
                            <span class="old-price"><?= $product['prix'] ?> €</span>
                            <span class="final-price"><?= number_format($newPrice, 2) ?> €</span>
                        <?php else: ?>
                            <span class="final-price"><?= $product['prix'] ?> €</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="stock-status">
                        <?php if ($product['stock'] === 0): ?>
                            <span class="rupture">⚠ RUPTURE DE STOCK</span>
                        <?php elseif ($product['stock'] < 5): ?>
                            <span class="last-items">⚡ Vite ! Plus que <?= $product['stock'] ?> en stock</span>
                        <?php else: ?>
                            <span class="en-stock">✅ En stock</span>
                        <?php endif; ?>
                    </div>

                    <button 
                        class="<?= ($product['stock'] === 0) ? 'btn-disabled' : 'btn-add' ?>"
                        <?= ($product['stock'] === 0) ? 'disabled' : '' ?>
                    >
                        <?= ($product['stock'] === 0) ? 'Indisponible' : 'Ajouter au panier' ?>
                    </button>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

</body>
</html>