<?php
// 1. Nos données (Simulation de BDD)
$products = [
    ["name" => "T-shirt Rouge", "price" => 15],
    ["name" => "Jean Slim", "price" => 55],
    ["name" => "Casquette", "price" => 12],
    ["name" => "Baskets Nike", "price" => 80],
    ["name" => "Chaussettes", "price" => 5],
    ["name" => "Sac à dos", "price" => 45],
    ["name" => "Ceinture Cuir", "price" => 20],
    ["name" => "Bonnet Laine", "price" => 18],
    ["name" => "Écharpe", "price" => 25],
    ["name" => "Gants", "price" => 15],
];

// 2. Récupération du mot-clé
// (q est le standard pour "query" / recherche)
$search = $_GET['q'] ?? '';

// 3. Filtrage
$results = [];

// Si une recherche est lancée (pas vide)
if (!empty($search)) {
    foreach ($products as $p) {
        // Est-ce que le Nom du produit contient le mot recherché ?
        // stripos renvoie la position (0, 1, 2...) ou FALSE si pas trouvé
        if (stripos($p['name'], $search) !== false) {
            $results[] = $p; // On ajoute le produit aux résultats
        }
    }
} else {
    // Optionnel : Si pas de recherche, on peut afficher tout, ou rien.
    // Ici, affichons tout par défaut pour que la page ne soit pas vide.
    $results = $products;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        .search-bar { display: flex; gap: 10px; margin-bottom: 30px; }
        input { flex-grow: 1; padding: 10px; font-size: 1rem; }
        button { padding: 10px 20px; cursor: pointer; background: #333; color: white; border: none; }
        
        .item { border-bottom: 1px solid #eee; padding: 10px 0; display: flex; justify-content: space-between; }
        .price { font-weight: bold; color: green; }
        .count { color: #666; font-size: 0.9rem; margin-bottom: 10px; }
    </style>
</head>
<body>

    <h1>🔍 Recherche de produits</h1>

    <form action="" method="GET" class="search-bar">
        <input type="text" 
               name="q" 
               placeholder="Que cherchez-vous ?" 
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Rechercher</button>
    </form>

    <div class="count">
        <?= count($results) ?> produit(s) trouvé(s)
    </div>

    <div class="list">
        <?php if (count($results) > 0): ?>
            
            <?php foreach ($results as $product): ?>
                <div class="item">
                    <span><?= $product['name'] ?></span>
                    <span class="price"><?= $product['price'] ?> €</span>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <p>Aucun résultat pour "<strong><?= htmlspecialchars($search) ?></strong>".</p>
        <?php endif; ?>
    </div>

</body>
</html>