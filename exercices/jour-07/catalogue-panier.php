<?php
// exercices/jour-07/catalogue-panier.php
session_start(); // 1. On démarre toujours la session en premier !

// Connexion BDD
try {
    $pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8mb4", "dev", "dev", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) { die("Erreur : " . $e->getMessage()); }

// --- LOGIQUE D'AJOUT AU PANIER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $id = (int)$_POST['product_id'];

    // Si le panier n'existe pas encore, on le crée (tableau vide)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Si le produit est déjà dedans, on augmente la quantité
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        // Sinon, on l'ajoute avec quantité 1
        $_SESSION['cart'][$id] = 1;
    }
    
    // Petit message de succès (optionnel)
    $message = "Produit ajouté au panier !";
}

// --- RÉCUPÉRATION DES PRODUITS ---
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcul du nombre d'articles total (pour le badge)
$totalArticles = 0;
if (isset($_SESSION['cart'])) {
    $totalArticles = array_sum($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue</title>
</head>
<body>
    <h1>🛍️ Catalogue</h1>
    
    <a href="panier.php" style="font-size: 20px; font-weight: bold;">
        Voir mon Panier (<?= $totalArticles ?> articles)
    </a>

    <?php if (isset($message)) echo "<p style='color:green; font-weight:bold;'>$message</p>"; ?>

    <hr>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <?php foreach ($products as $p): ?>
            <div style="border: 1px solid #ddd; padding: 10px; width: 200px;">
                <h3><?= htmlspecialchars($p['name']) ?></h3>
                <p>Prix : <?= $p['price'] ?> €</p>
                
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                    <button type="submit">Ajouter au panier 🛒</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>