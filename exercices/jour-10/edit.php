<?php
// 1. Chargement des outils
require_once 'ProductRepository.php';
require_once 'Product.php';

// 2. Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new ProductRepository($pdo);

// 3. VÉRIFICATION DE SÉCURITÉ
// On regarde si l'ID est bien présent dans l'URL (ex: edit.php?id=42)
if (!isset($_GET['id'])) {
    die("❌ Erreur : Aucun produit sélectionné (Il manque l'ID dans l'URL).");
}

$id = (int)$_GET['id'];
$produit = $repo->find($id);

// Si l'ID ne correspond à rien en base de données
if (!$produit) {
    die("❌ Erreur : Ce produit n'existe pas.");
}

$message = "";

// 4. TRAITEMENT DU FORMULAIRE (Quand on clique sur "Enregistrer")
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom   = $_POST['name'];
    $desc  = $_POST['description'];
    $prix  = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $catId = (int)$_POST['category_id'];

    // On appelle la méthode UPDATE du Repository
    $repo->update($id, $nom, $desc, $prix, $stock, $catId);

    // ⚡ IMPORTANT : On recharge les données du produit depuis la BDD
    // pour être sûr d'afficher les nouvelles valeurs dans le formulaire juste en dessous
    $produit = $repo->find($id);
    
    $message = "<div class='success'>✅ Modifications enregistrées avec succès ! <a href='index.php'>Retour à la liste</a></div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier : <?= htmlspecialchars($produit->getName()) ?></title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; background-color: #f9f9f9; }
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; color: #333; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        input, textarea, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 25px; padding: 12px 20px; background: #ffc107; color: black; border: none; cursor: pointer; font-weight: bold; font-size: 16px; width: 100%; border-radius: 4px; }
        button:hover { background: #e0a800; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #666; }
        .back-link:hover { color: #000; }
    </style>
</head>
<body>

    <a href="index.php" class="back-link">⬅️ Annuler et retour à la liste</a>

    <div class="form-container">
        <h1>✏️ Modifier le produit</h1>
        
        <?= $message ?>

        <form method="POST">
            
            <label>Nom du produit :</label>
            <input type="text" name="name" value="<?= htmlspecialchars($produit->getName()) ?>" required>

            <label>Description :</label>
            <textarea name="description" rows="4"><?= htmlspecialchars($produit->getDescription()) ?></textarea>

            <label>Prix (€) :</label>
            <input type="number" name="price" step="0.01" value="<?= $produit->getPrice() ?>" required>

            <label>Stock :</label>
            <input type="number" name="stock" value="<?= $produit->getStock() ?>" required>

            <label>Catégorie :</label>
            <select name="category_id">
                <option value="1" <?= $produit->getCategoryId() == 1 ? 'selected' : '' ?>>Vêtements</option>
                <option value="2" <?= $produit->getCategoryId() == 2 ? 'selected' : '' ?>>Accessoires</option>
                <option value="3" <?= $produit->getCategoryId() == 3 ? 'selected' : '' ?>>Chaussures</option>
            </select>

            <button type="submit">Enregistrer les modifications</button>
        </form>
    </div>

</body>
</html>