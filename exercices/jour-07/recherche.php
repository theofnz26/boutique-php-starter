<?php
// exercices/jour-07/recherche.php

// 1. Connexion BDD
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=boutique;charset=utf8mb4",
        "dev", "dev", // Tes identifiants validés
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Initialisation
$produits = [];
$motCle = "";

// 2. On vérifie si une recherche est lancée (paramètre 'q' dans l'URL)
if (isset($_GET['q'])) {
    $motCle = $_GET['q'];

    // 3. REQUÊTE PRÉPARÉE (Sécurité)
    // Le '?' est un placeholder (une place réservée)
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ?");

    // 4. Exécution
    // On ajoute les jokers '%' ici.
    // '%jean%' signifie : tout ce qui contient 'jean' (avant ou après)
    $stmt->execute(['%' . $motCle . '%']);

    // 5. Récupération
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche Produit</title>
</head>
<body>
    <h1>🔍 Moteur de recherche</h1>

    <form method="GET" action="">
        <input type="text" name="q" placeholder="Chercher un produit..." value="<?= htmlspecialchars($motCle) ?>">
        <button type="submit">Rechercher</button>
    </form>
    
    <a href="liste-produits.php">Retour à la liste complète</a>

    <hr>

    <?php if ($motCle): ?>
        <h3>Résultats pour "<?= htmlspecialchars($motCle) ?>" :</h3>

        <?php if (count($produits) > 0): ?>
            <ul>
                <?php foreach ($produits as $p): ?>
                    <li>
                        <strong><?= htmlspecialchars($p['name']) ?></strong> 
                        — <?= htmlspecialchars($p['price']) ?> €
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="color: red;">❌ Aucun produit trouvé.</p>
        <?php endif; ?>

    <?php endif; ?>

</body>
</html>