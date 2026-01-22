<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-red { color: red; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <a href="/produits">⬅️ Continuer mes achats</a>
    <h1>🛒 Mon Panier</h1>

    <?php if (empty($cartWithData)): ?>
        <p>Votre panier est vide. 😢</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartWithData as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product']->getName()) ?></td>
                        <td><?= $item['product']->getPrice() ?> €</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= $item['subtotal'] ?> €</td>
                        <td>
                            <form action="/panier/supprimer" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $item['product']->getId() ?>">
                                <button type="submit">❌</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Total :</strong></td>
                    <td><strong><?= $total ?> €</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        
        <br>
        <form action="/panier/vider" method="POST">
             <button type="submit" style="background:red; color:white;">🗑️ Vider le panier</button>
        </form>
    <?php endif; ?>
</body>
</html>