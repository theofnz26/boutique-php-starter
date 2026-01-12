<?php
// Notre "Base de données" (Tableau associatif)
// La clé (1, 2, 3...) sert d'Identifiant (ID)
$products = [
    1 => ["name" => "T-shirt Rouge", "price" => 15.00, "desc" => "Un t-shirt en coton bio."],
    2 => ["name" => "Jean Slim",      "price" => 55.00, "desc" => "Le jean qui passe partout."],
    3 => ["name" => "Casquette",      "price" => 12.00, "desc" => "Pour se protéger du soleil avec style."],
    4 => ["name" => "Baskets",        "price" => 80.00, "desc" => "Confortables pour le sport."],
];

// 1. On récupère l'ID depuis l'URL (ex: ?id=2)
// Si pas d'id, on met null
$id = $_GET['id'] ?? null;

// 2. On cherche le produit correspondant
$produitAffiche = null;

// On vérifie si l'ID existe dans notre tableau $products
if ($id && isset($products[$id])) {
    $produitAffiche = $products[$id];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Produit</title>
    <style>
        body { font-family: sans-serif; padding: 20px; text-align: center; }
        .card { border: 1px solid #ddd; padding: 20px; max-width: 400px; margin: 0 auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .price { color: green; font-weight: bold; font-size: 1.5rem; }
        .error { color: red; }
    </style>
</head>
<body>

    <h1>Détail du produit</h1>

    <?php if ($produitAffiche): ?>
        <div class="card">
            <h2><?= $produitAffiche['name'] ?></h2>
            <p><?= $produitAffiche['desc'] ?></p>
            <p class="price"><?= $produitAffiche['price'] ?> €</p>
            <p><small>Référence produit : #<?= $id ?></small></p>
        </div>
    <?php else: ?>
        <div class="error">
            <h3>🚫 Oups ! Produit introuvable.</h3>
            <p>L'identifiant "<?= $id ?>" n'existe pas dans notre catalogue.</p>
        </div>
    <?php endif; ?>

    <hr>
    
    <p>Voir les autres produits :</p>
    <a href="produit.php?id=1">T-shirt</a> | 
    <a href="produit.php?id=2">Jean</a> | 
    <a href="produit.php?id=3">Casquette</a> |
    <a href="produit.php?id=99">Produit Inconnu</a>

</body>
</html>