<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
   <a href="/produit/<?= $product->getId() ?>">Voir détail</a>
    <h1>Liste des Produits</h1>

    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <strong><?= htmlspecialchars($product->getName()) ?></strong> 
                - <?= $product->getPrice() ?> €
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>