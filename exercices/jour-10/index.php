<?php
require_once 'ProductRepository.php';
require_once 'Product.php';

// 1. Connexion BDD
$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new ProductRepository($pdo);

// 2. On récupère la liste complète
$produits = $repo->findAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration Boutique</title>
    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn { text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 14px; font-weight: bold; display: inline-block; }
        .btn-add { background-color: #28a745; color: white; margin-bottom: 20px; padding: 10px 20px; font-size: 16px; }
        .btn-edit { background-color: #ffc107; color: black; border: 1px solid #e0a800; }
        .btn-delete { background-color: #dc3545; color: white; border: 1px solid #c82333; margin-left: 5px; }
        .stock-ok { color: green; font-weight: bold; }
        .stock-low { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>📦 Gestion du Stock</h1>

    <a href="exo2_create.php" class="btn btn-add">➕ Ajouter un nouveau produit</a>

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
        </tbody>
    </table>

</body>
</html>