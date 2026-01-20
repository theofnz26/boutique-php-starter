<?php
require_once 'ProductRepository.php';
require_once 'Product.php';

// 1. Connexion BDD
$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new ProductRepository($pdo);

// 2. LOGIQUE DE RECHERCHE (Le Cerveau 🧠)
// On regarde l'URL pour savoir quoi afficher

$titre = "📦 Liste complète"; // Titre par défaut

if (!empty($_GET['search'])) {
    // CAS 1 : Recherche texte (ex: ?search=Rouge)
    $term = $_GET['search'];
    $produits = $repo->search($term);
    $titre = "🔍 Recherche : \"$term\"";

} elseif (!empty($_GET['cat_id'])) {
    // CAS 2 : Filtre par catégorie (ex: ?cat_id=1)
    $catId = (int)$_GET['cat_id'];
    $produits = $repo->findByCategory($catId);
    
    // Petite astuce pour afficher le nom de la catégorie
    $nomsCategories = [1 => 'Vêtements', 2 => 'Accessoires', 3 => 'Chaussures'];
    $nomCat = $nomsCategories[$catId] ?? 'Inconnue';
    $titre = "📂 Catégorie : $nomCat";

} elseif (isset($_GET['stock']) && $_GET['stock'] === 'yes') {
    // CAS 3 : Filtre "En Stock" (ex: ?stock=yes)
    $produits = $repo->findInStock();
    $titre = "✅ Produits en stock uniquement";

} else {
    // CAS 4 (Défaut) : On affiche tout
    $produits = $repo->findAll();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration Boutique</title>
    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; }
        h1 { text-align: center; color: #333; }
        
        /* Barre d'outils de recherche */
        .toolbar { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap; align-items: center; justify-content: space-between; border: 1px solid #ddd; }
        .search-form { display: flex; gap: 5px; }
        .filters a { text-decoration: none; color: #007bff; margin-right: 10px; font-weight: bold; }
        .filters a:hover { text-decoration: underline; }
        .reset-link { color: #dc3545 !important; }

        /* Tableaux */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        
        /* Boutons Actions */
        .btn { text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 14px; font-weight: bold; display: inline-block; }
        .btn-add { background-color: #28a745; color: white; margin-bottom: 20px; padding: 10px 20px; font-size: 16px; }
        .btn-edit { background-color: #ffc107; color: black; border: 1px solid #e0a800; }
        .btn-delete { background-color: #dc3545; color: white; border: 1px solid #c82333; margin-left: 5px; }
        
        .stock-ok { color: green; font-weight: bold; }
        .stock-low { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1><?= htmlspecialchars($titre) ?></h1>

    <div class="toolbar">
        <form class="search-form" method="GET">
            <input type="text" name="search" placeholder="Rechercher..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">🔍</button>
        </form>

        <div class="filters">
            Filtrer : 
            <a href="index.php?cat_id=1">👕 Vêtements</a>
            <a href="index.php?cat_id=2">💍 Accessoires</a>
            <a href="index.php?cat_id=3">👟 Chaussures</a>
            <span style="color:#ccc">|</span>
            <a href="index.php?stock=yes">📦 En Stock</a>
            <span style="color:#ccc">|</span>
            <a href="index.php" class="reset-link">❌ Tout voir</a>
        </div>
    </div>

    <a href="exo2_create.php" class="btn btn-add">➕ Ajouter un produit</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom & Description</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produits)): ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding: 20px;">
                        🚫 Aucun produit trouvé pour cette recherche.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($produits as $p): ?>
                    <tr>
                        <td><?= $p->getId() ?></td>
                        <td>
                            <strong><?= htmlspecialchars($p->getName()) ?></strong><br>
                            <small style="color:gray"><?= htmlspecialchars($p->getDescription()) ?></small>
                        </td>
                        <td><?= $p->getPrice() ?> €</td>
                        
                        <td>
                            <?php if ($p->getStock() < 5): ?>
                                <span class="stock-low">⚠️ <?= $p->getStock() ?></span>
                            <?php else: ?>
                                <span class="stock-ok"><?= $p->getStock() ?></span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="edit.php?id=<?= $p->getId() ?>" class="btn btn-edit">✏️ Modifier</a>
                            <a href="delete.php?id=<?= $p->getId() ?>" 
                               class="btn btn-delete"
                               onclick="return confirm('Es-tu sûr de vouloir supprimer ce produit ?');">
                               🗑️
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>