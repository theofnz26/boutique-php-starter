<?php
// 1. Chargement des outils
require_once 'ProductRepository.php';
require_once 'Product.php';

// 2. Connexion
$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new ProductRepository($pdo);

// 3. Récupération de l'objet à modifier
if (!isset($_GET['id'])) {
    die("❌ Erreur : ID manquant.");
}

$id = (int)$_GET['id'];
$produit = $repo->find($id);

if (!$produit) {
    die("❌ Erreur : Produit introuvable.");
}

$message = "";

// 4. TRAITEMENT (Mode Strict : On modifie l'objet, puis on le sauvegarde)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // A. On utilise les SETTERS pour changer les valeurs de l'objet
    $produit->setName($_POST['name']);
    $produit->setDescription($_POST['description']);
    $produit->setPrice((float)$_POST['price']);
    $produit->setStock((int)$_POST['stock']);
    $produit->setCategoryId((int)$_POST['category_id']);

    // B. On envoie l'OBJET complet au Repository
    $repo->update($produit);

    // C. On recharge le produit pour être sûr d'afficher les données à jour
    $produit = $repo->find($id);
    
    $message = "<div class='success'>✅ Produit modifié via l'Objet ! <a href='index.php'>Retour liste</a></div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le produit</title>
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

    <a href="index.php" class="back-link">⬅️ Annuler</a>

    <div class="form-container">
        <h1>✏️ Modifier (Mode Objet)</h1>
        
        <?= $message ?>

        <form method="POST">
            <label>Nom :</label>
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