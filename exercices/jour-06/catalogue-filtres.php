<?php

$products = [
    ["name" => "T-shirt Blanc", "price" => 20, "category" => "Vêtement", "stock" => true],
    ["name" => "Jean Bleu",     "price" => 60, "category" => "Vêtement", "stock" => true],
    ["name" => "Casquette",     "price" => 15, "category" => "Accessoire", "stock" => false],
    ["name" => "Baskets",       "price" => 90, "category" => "Chaussures", "stock" => true],
    ["name" => "Chaussettes",   "price" => 5,  "category" => "Vêtement", "stock" => true],
    ["name" => "Sac à dos",     "price" => 40, "category" => "Accessoire", "stock" => false],
    ["name" => "Montre",        "price" => 150,"category" => "Accessoire", "stock" => true],
    ["name" => "Sandales",      "price" => 30, "category" => "Chaussures", "stock" => false],
];

// 2. Récupération des filtres (avec valeurs par défaut)
$search   = $_GET['search'] ?? '';
$category = $_GET['category'] ?? ''; // '' signifie "Toutes les catégories"
$maxPrice = $_GET['price'] ?? '';    // '' signifie "Pas de limite"
$inStock  = isset($_GET['stock']);   // Vrai si la case est cochée

//Le Moteur de Filtrage
$results = [];

foreach ($products as $p) {
    
    //FILTRE 1 : Recherche texte
    if ($search !== '' && stripos($p['name'], $search) === false) {
        continue; // Pas le bon mot ? Au suivant !
    }

    //FILTRE 2 : Catégorie
    if ($category !== '' && $p['category'] !== $category) {
        continue; // Pas la bonne catégorie ? Au suivant !
    }

    // FILTRE 3 : Prix Max
    if ($maxPrice !== '' && $p['price'] > $maxPrice) {
        continue; // Trop cher ? Au suivant !
    }

    //FILTRE 4 : Stock uniquement
    if ($inStock && $p['stock'] === false) {
        continue; // On veut du stock et il n'y en a pas ? Au suivant !
    }

    // S'il a survécu à tout ça, on le garde !
    $results[] = $p;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Filtres Avancés</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 800px; margin: auto; }
        .filters { background: #f4f4f4; padding: 20px; border-radius: 8px; display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap; }
        .group { display: flex; flex-direction: column; }
        .group label { font-weight: bold; font-size: 0.8rem; margin-bottom: 5px; }
        .card { border: 1px solid #ddd; padding: 15px; margin-top: 10px; border-radius: 5px; display: flex; justify-content: space-between; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 0.8rem; color: white; background: #999; }
        .bg-green { background: #28a745; }
        .bg-red { background: #dc3545; }
    </style>
</head>
<body>

    <h1>🛍️ Catalogue Multi-Filtres</h1>

    <form class="filters" method="GET">
        
        <div class="group">
            <label>Recherche</label>
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Nom...">
        </div>

        <div class="group">
            <label>Catégorie</label>
            <select name="category">
                <option value="">Toutes</option>
                <option value="Vêtement" <?= $category === 'Vêtement' ? 'selected' : '' ?>>Vêtements</option>
                <option value="Accessoire" <?= $category === 'Accessoire' ? 'selected' : '' ?>>Accessoires</option>
                <option value="Chaussures" <?= $category === 'Chaussures' ? 'selected' : '' ?>>Chaussures</option>
            </select>
        </div>

        <div class="group">
            <label>Prix max (€)</label>
            <input type="number" name="price" value="<?= htmlspecialchars($maxPrice) ?>" style="width: 80px;">
        </div>

        <div class="group" style="flex-direction: row; gap: 5px; align-items: center; padding-bottom: 8px;">
            <input type="checkbox" name="stock" id="stock" <?= $inStock ? 'checked' : '' ?>>
            <label for="stock" style="margin:0; cursor:pointer">En stock</label>
        </div>

        <button type="submit">Filtrer</button>
        <a href="catalogue-filtres.php" style="margin-left:auto; text-decoration:none; color:red;">× Réinitialiser</a>
    </form>

    <hr>

    <h3><?= count($results) ?> résultat(s)</h3>

    <div class="results">
        <?php foreach ($results as $p): ?>
            <div class="card">
                <div>
                    <strong><?= $p['name'] ?></strong> 
                    <span style="color: #666; font-size: 0.9rem;">(<?= $p['category'] ?>)</span>
                </div>
                <div>
                    <span style="font-weight: bold; color: green; margin-right: 15px;"><?= $p['price'] ?> €</span>
                    <?php if ($p['stock']): ?>
                        <span class="badge bg-green">En stock</span>
                    <?php else: ?>
                        <span class="badge bg-red">Rupture</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (count($results) === 0): ?>
            <p style="text-align:center; color: #777;">Aucun produit ne correspond à vos critères.</p>
        <?php endif; ?>
    </div>

</body>
</html>