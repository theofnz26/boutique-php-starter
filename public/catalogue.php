<?php
// 1. IMPORTATIONS
require_once __DIR__ . '/../app/produits.php'; // Les données ($products)
require_once __DIR__ . '/../app/helpers.php';  // Les fonctions (displayPrice...)

// 2. LOGIQUE DE FILTRAGE
// Récupération des paramètres URL
$search   = $_GET['search'] ?? '';
$category = $_GET['cat'] ?? '';
$priceMax = $_GET['price'] ?? '';

// On filtre le tableau $products
$results = [];

foreach ($products as $id => $p) {
    // Filtre Recherche (Nom)
    if ($search && stripos($p['name'], $search) === false) {
        continue;
    }
    // Filtre Catégorie
    if ($category && $p['category'] !== $category) {
        continue;
    }
    // Filtre Prix Max
    // On calcule le vrai prix (avec promo) pour être juste
    $realPrice = $p['price'] * (1 - $p['discount']/100);
    if ($priceMax && $realPrice > $priceMax) {
        continue;
    }

    // Si tout est bon, on garde le produit (et son ID !)
    // On stocke l'ID dans le produit pour pouvoir faire le lien plus tard
    $p['id'] = $id; 
    $results[] = $p;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma Boutique PHP</title>
    <style>
        /* CSS Simple pour la mise en page */
        body { font-family: system-ui, sans-serif; margin: 0; padding: 0; display: flex; height: 100vh; }
        
        /* Sidebar (Gauche) */
        aside { width: 250px; background: #f4f4f4; padding: 20px; border-right: 1px solid #ddd; height: 100%; overflow-y: auto; box-sizing: border-box; }
        aside h2 { font-size: 1.2rem; margin-top: 0; }
        .filter-group { margin-bottom: 20px; }
        .filter-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .filter-group input, .filter-group select { width: 100%; padding: 5px; box-sizing: border-box; }
        button.btn-filter { width: 100%; padding: 10px; background: #333; color: white; border: none; cursor: pointer; }

        /* Contenu Principal (Droite) */
        main { flex-grow: 1; padding: 20px; overflow-y: auto; }
        
        /* Grille Produits */
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
        .card { border: 1px solid #eee; border-radius: 8px; overflow: hidden; transition: transform 0.2s; background: white; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .card img { width: 100%; height: 180px; object-fit: cover; }
        .card-body { padding: 15px; }
        .card h3 { margin: 0 0 10px 0; font-size: 1rem; }
        a { text-decoration: none; color: inherit; }
    </style>
</head>
<body>

    <aside>
        <h2>🔍 Filtrer</h2>
        <form action="" method="GET">
            
            <div class="filter-group">
                <label>Recherche</label>
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="T-shirt...">
            </div>

            <div class="filter-group">
                <label>Catégorie</label>
                <select name="cat">
                    <option value="">Toutes</option>
                    <option value="Vêtement" <?= $category === 'Vêtement' ? 'selected' : '' ?>>Vêtements</option>
                    <option value="Accessoire" <?= $category === 'Accessoire' ? 'selected' : '' ?>>Accessoires</option>
                    <option value="Chaussures" <?= $category === 'Chaussures' ? 'selected' : '' ?>>Chaussures</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Budget Max (€)</label>
                <input type="number" name="price" value="<?= htmlspecialchars($priceMax) ?>" placeholder="Ex: 50">
            </div>

            <button type="submit" class="btn-filter">Appliquer</button>
            <div style="text-align: center; margin-top: 10px;">
                <a href="catalogue.php" style="color: #666; font-size: 0.9rem;">Réinitialiser</a>
            </div>
        </form>
    </aside>

    <main>
        <h1>🛍️ Catalogue (<?= count($results) ?> produits)</h1>

        <?php if (empty($results)): ?>
            <p>Aucun produit ne correspond à vos critères.</p>
        <?php else: ?>
            <div class="grid">
                <?php foreach ($results as $p): ?>
                    
                    <a href="produit.php?id=<?= $p['id'] ?>" class="card">
                        <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>">
                        <div class="card-body">
                            <h3><?= $p['name'] ?></h3>
                            <div><?= displayPrice($p['price'], $p['discount']) ?></div>
                            <div style="margin-top:10px"><?= displayStock($p['stock']) ?></div>
                        </div>
                    </a>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>