<?php
// public/produit.php
require_once __DIR__ . '/../app/produits.php'; // On charge les données
require_once __DIR__ . '/../app/helpers.php';  // On charge les outils

// Récupération de l'ID
$id = $_GET['id'] ?? null;
$product = $products[$id] ?? null; // On cherche dans le tableau avec la clé
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $product ? $product['name'] : 'Introuvable' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <a href="catalogue.php">← Retour au catalogue</a>

    <?php if ($product): ?>
        <div style="display:flex; gap:40px; margin-top:20px;">
            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" style="max-width:400px; border-radius:10px;">
            
            <div>
                <h1><?= $product['name'] ?></h1>
                <p><?= $product['desc'] ?></p>
                <hr>
                <h3><?= displayPrice($product['price'], $product['discount']) ?></h3>
                <p><?= displayStock($product['stock']) ?></p>
                
                <button>Ajouter au panier</button>
            </div>
        </div>
    <?php else: ?>
        <h1>🚫 Produit introuvable</h1>
        <p>Ce produit n'existe pas.</p>
    <?php endif; ?>

</body>
</html>