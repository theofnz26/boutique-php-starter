<?php
// 1. IMPORTATION DES DONNÉES (Vers le nouveau fichier)
require __DIR__ . '/../app/produits-final.php';

// 2. CALCUL DES STATISTIQUES
$countStock = 0;
$countPromo = 0;
$countRupture = 0;

foreach ($products as $p) {
    if ($p['stock'] === 0) {
        $countRupture++;
    } else {
        $countStock++;
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
    <title>Mon Catalogue Final</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background-color: #f4f4f4; color: #333; }
        h1 { text-align: center; margin-bottom: 40px; }

        /* BARRE DE STATS */
        .stats-bar { display: flex; justify-content: center; gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 15px 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .stat-val { display: block; font-size: 1.8rem; font-weight: bold; }
        
        /* GRILLE PRODUITS */
        .grille { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        
        /* CARTE PRODUIT */
        .carte { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: transform 0.2s; position: relative; display: flex; flex-direction: column; }
        .carte:hover { transform: translateY(-5px); }
        
        .image-wrapper { position: relative; height: 200px; }
        .carte img { width: 100%; height: 100%; object-fit: cover; }
        
        /* BADGES */
        .badge { position: absolute; top: 10px; padding: 5px 12px; color: white; font-weight: bold; font-size: 0.8rem; border-radius: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        .badge-new { background: #3498db; left: 10px; }
        .badge-promo { background: #e74c3c; right: 10px; }

        .info { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .nom { font-size: 1.1rem; margin: 0 0 10px 0; }
        .categorie { font-size: 0.8rem; color: #7f8c8d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }

        /* PRIX */
        .prix-container { margin-bottom: 15px; }
        .old-price { text-decoration: line-through; color: #bdc3c7; font-size: 0.9rem; margin-right: 8px; }
        .price { font-size: 1.3rem; font-weight: bold; color: #2ecc71; }
        
        /* STOCK & ACTIONS */
        .stock-msg { font-size: 0.85rem; margin-bottom: 15px; font-weight: 600; }
        .txt-rupture { color: #e74c3c; }
        .txt-last { color: #f39c12; }
        .txt-ok { color: #27ae60; }

        button { width: 100%; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: background 0.3s; }
        .btn-add { background: #2c3e50; color: white; }
        .btn-add:hover { background: #1a252f; }
        .btn-disabled { background: #ecf0f1; color: #bdc3c7; cursor: not-allowed; }
    </style>
</head>
<body>

    <h1>🛍️ La Boutique PHP (Version Finale)</h1>

    <div class="stats-bar">
        <div class="stat-card">
            <span class="stat-val" style="color: #27ae60"><?= $countStock ?></span>
            En stock
        </div>
        <div class="stat-card">
            <span class="stat-val" style="color: #e74c3c"><?= $countPromo ?></span>
            Promos
        </div>
        <div class="stat-card">
            <span class="stat-val" style="color: #95a5a6"><?= $countRupture ?></span>
            Ruptures
        </div>
    </div>

    <div class="grille">
        <?php foreach ($products as $p): ?>
            <article class="carte">
                
                <div class="image-wrapper">
                    <img src="<?= $p['image'] ?>" alt="<?= $p['nom'] ?>">
                    
                    <?php if ($p['new']): ?>
                        <span class="badge badge-new">NOUVEAU</span>
                    <?php endif; ?>
                    
                    <?php if ($p['discount'] > 0): ?>
                        <span class="badge badge-promo">-<?= $p['discount'] ?>%</span>
                    <?php endif; ?>
                </div>

                <div class="info">
                    <div>
                        <div class="categorie"><?= $p['categorie'] ?></div>
                        <h3 class="nom"><?= $p['nom'] ?></h3>
                        
                        <div class="prix-container">
                            <?php if ($p['discount'] > 0): ?>
                                <?php $prixFinal = $p['prix'] * (1 - $p['discount']/100); ?>
                                <span class="old-price"><?= $p['prix'] ?> €</span>
                                <span class="price"><?= number_format($prixFinal, 2) ?> €</span>
                            <?php else: ?>
                                <span class="price"><?= $p['prix'] ?> €</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <div class="stock-msg">
                            <?php if ($p['stock'] === 0): ?>
                                <span class="txt-rupture">⚠ Rupture de stock</span>
                            <?php elseif ($p['stock'] < 5): ?>
                                <span class="txt-last">⚡ Dernières pièces !</span>
                            <?php else: ?>
                                <span class="txt-ok">✅ En stock</span>
                            <?php endif; ?>
                        </div>

                        <button class="<?= ($p['stock'] === 0) ? 'btn-disabled' : 'btn-add' ?>" 
                                <?= ($p['stock'] === 0) ? 'disabled' : '' ?>>
                            <?= ($p['stock'] === 0) ? 'Indisponible' : 'Ajouter au panier' ?>
                        </button>
                    </div>
                </div>

            </article>
        <?php endforeach; ?>
    </div>

</body>
</html>