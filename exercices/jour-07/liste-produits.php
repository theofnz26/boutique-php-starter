<?php
// --- 1. CONNEXION ---
try {
    // On se connecte à la base "boutique"
    $pdo = new PDO(
    "mysql:host=localhost;dbname=boutique;charset=utf8mb4",
    "dev",       // Utilisateur qui marche
    "dev",       // Mot de passe que tu as tapé tout à l'heure
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// --- 2. REQUÊTE ---
// On écrit le SQL : "Sélectionne TOUT (*) depuis la table 'products'"
$sql = "SELECT * FROM products";

// On envoie la requête à la base
$stmt = $pdo->query($sql);

// --- 3. RÉCUPÉRATION ---
// On récupère TOUS les résultats dans un tableau associatif
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Astuce de dev : décommente la ligne ci-dessous pour voir à quoi ressemble le tableau brut
// var_dump($produits); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Produits</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-family: sans-serif; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>📦 Catalogue des produits</h1>

    <?php if (count($produits) > 0): ?>
        
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['name']) ?></td>
                        <td><?= htmlspecialchars($produit['price']) ?> €</td>
                        <td><?= htmlspecialchars($produit['stock']) ?> unités</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p>Aucun produit disponible pour le moment.</p>
    <?php endif; ?>

</body>
</html>