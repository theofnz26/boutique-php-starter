<?php

// 1. CONNEXION BDD
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=boutique;charset=utf8mb4",
        "dev", "dev", // Tes identifiants
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// 2. TRAITEMENT : SUPPRESSION (DELETE)
// Si l'URL contient ?delete=42
if (isset($_GET['delete'])) {
    // On prépare la requête pour éviter les injections
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);

    // Redirection pour "nettoyer" l'URL
    header("Location: admin-produits.php");
    exit;
}

// 3. TRAITEMENT : AJOUT (CREATE)
// Si le formulaire a été soumis en POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "add") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Requête préparée
    $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
    $stmt->execute([$name, $price, $stock]);

    // Redirection
    header("Location: admin-produits.php");
    exit;
}

// 4. RÉCUPÉRATION DE LA LISTE (READ)
// Pour afficher le tableau en bas de page
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC"); // Les plus récents en premier
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration Produits</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn-delete { color: red; text-decoration: none; font-weight: bold; }
        .form-box { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        input { padding: 5px; margin: 5px 0; }
    </style>
</head>
<body>

    <h1>🛠️ Gestion des produits</h1>
    <a href="liste-produits.php">Voir le catalogue public</a>

    <h2>Liste actuelle</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['price']) ?> €</td>
                    <td><?= $p['stock'] ?></td>
                    <td>
                        <a href="?delete=<?= $p['id'] ?>" 
                           class="btn-delete"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                           Supprimer 🗑️
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-box">
        <h2>➕ Ajouter un produit</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="add">
            
            <label>Nom :</label><br>
            <input type="text" name="name" required placeholder="Ex: Chaussettes"><br>
            
            <label>Prix (€) :</label><br>
            <input type="number" step="0.01" name="price" required placeholder="10.00"><br>
            
            <label>Stock :</label><br>
            <input type="number" name="stock" required placeholder="50"><br>
            
            <button type="submit" style="margin-top:10px;">Ajouter le produit</button>
        </form>
    </div>

</body>
</html>