<?php
// exercices/jour-07/panier.php
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8mb4", "dev", "dev", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) { die("Erreur : " . $e->getMessage()); }

// Gestion du bouton "Vider le panier"
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']); // On détruit la variable de session
    header("Location: panier.php"); // On recharge la page
    exit;
}

$cartProducts = [];
$totalGeneral = 0;

// On ne fait la requête que si le panier n'est pas vide !
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    
    // 1. Récupérer tous les IDs du panier (les clés du tableau session)
    $ids = array_keys($_SESSION['cart']); // Ex: [1, 5, 8]
    
    // 2. Créer une chaîne de points d'interrogation pour la requête SQL
    // Si on a 3 produits, ça fait "?,?,?"
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    // 3. Requête SQL avec "WHERE id IN (...)"
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $productsDb = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. On associe les infos de la BDD avec la quantité de la Session
    foreach ($productsDb as $product) {
        $id = $product['id'];
        $quantity = $_SESSION['cart'][$id];
        $subtotal = $product['price'] * $quantity;

        // On stocke tout ça proprement pour l'affichage
        $cartProducts[] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
        
        $totalGeneral += $subtotal;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h1>🛒 Votre Panier</h1>
    <a href="catalogue-panier.php">⬅️ Retour au catalogue</a>

    <?php if (empty($cartProducts)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix U.</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartProducts as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['price'] ?> €</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['subtotal'], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right; font-weight:bold;">TOTAL :</td>
                    <td style="font-weight:bold;"><?= number_format($totalGeneral, 2) ?> €</td>
                </tr>
            </tfoot>
        </table>

        <br>
        <a href="?action=clear" style="color:red;">🗑️ Vider le panier</a>

    <?php endif; ?>
</body>
</html>