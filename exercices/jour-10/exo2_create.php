<?php

require_once 'ProductRepository.php';
// Product.php est chargé automatiquement par le Repository, mais on peut le mettre par sécurité
require_once 'Product.php'; 

// Connexion à la BDD
$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new ProductRepository($pdo);

// Variable pour afficher un message à l'utilisateur
$message = "";


// 2. TRAITEMENT DU FORMULAIRE (PHP)
// On vérifie : Est-ce que l'utilisateur a cliqué sur le bouton "Envoyer" ?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // A. On récupère les données saisies (c'est le nom des <input>)
    // On sécurise un minimum et on force les types (int, float)
    $nom         = $_POST['name'];
    $description = $_POST['description'];
    $prix        = (float) $_POST['price']; // On force en nombre à virgule
    $stock       = (int) $_POST['stock'];   // On force en entier
    $categorieId = (int) $_POST['category_id']; 

    // B. On vérifie que les champs obligatoires sont là
    if (!empty($nom) && $prix > 0) {
        // C. On appelle ton Repository pour insérer en base
        $repo->create($nom, $description, $prix, $stock, $categorieId);
        
        $message = "<div class='success'>✅ Le produit <strong>$nom</strong> a été ajouté !</div>";
    } else {
        $message = "<div class='error'>❌ Attention : Le nom et le prix sont obligatoires.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice 2 : Ajouter un produit</title>
    <style>
        /* Un peu de style pour que ce soit lisible */
        body { font-family: sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, textarea, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #218838; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        a { display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>

    <a href="index.php">⬅️ Retour à la liste des produits</a>

    <h1>Ajouter un nouveau produit</h1>

    <?= $message ?>

    <form method="POST">
        
        <div class="form-group">
            <label>Nom du produit :</label>
            <input type="text" name="name" placeholder="Ex: Chaise de bureau" required>
        </div>

        <div class="form-group">
            <label>Description :</label>
            <textarea name="description" rows="3" placeholder="Description courte..."></textarea>
        </div>

        <div class="form-group">
            <label>Prix (€) :</label>
            <input type="number" name="price" step="0.01" placeholder="0.00" required>
        </div>

        <div class="form-group">
            <label>Stock :</label>
            <input type="number" name="stock" value="10" required>
        </div>

        <div class="form-group">
            <label>Catégorie :</label>
            <select name="category_id">
                <option value="1">Vêtements</option>
                <option value="2">Accessoires</option>
                <option value="3">Chaussures</option>
            </select>
        </div>

        <button type="submit">Enregistrer le produit</button>

    </form>

</body>
</html>