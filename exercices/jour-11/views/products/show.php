<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <a href="/produits">⬅️ Retour au catalogue</a>
    
    <h1><?= htmlspecialchars($product->getName()) ?></h1>
    
    <div style="background: #f4f4f4; padding: 20px; border-radius: 8px;">
        <p><strong>Prix :</strong> <?= $product->getPrice() ?> €</p>
        <p><strong>Stock :</strong> <?= $product->getStock() ?> unités</p>
        <hr>
        <p><strong>Description :</strong></p>
        <p><?= nl2br(htmlspecialchars($product->getDescription() ?? 'Aucune description')) ?></p>
    </div>
</body>
</html>