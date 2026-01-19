<?php

require_once 'ProductRepository.php';

// 1. Configuration de la connexion
$host = "localhost";
$dbname = "boutique";
$user = "dev";      // Ton utilisateur
$pass = "dev";      // Ton mot de passe

try {
    // Connexion à MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Activation des erreurs pour voir les problèmes SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie à la BDD (User: $user).<br><hr>";
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}

// 2. Initialisation du Repository
$repo = new ProductRepository($pdo);

//TEST 1 : Afficher tout le monde (findAll)
echo "<h3>📦 Liste de tous les produits</h3>";
$produits = $repo->findAll();

if (empty($produits)) {
    echo "Aucun produit trouvé.";
} else {
    echo "<ul>";
    foreach ($produits as $p) {
        
        echo "<li>";
        echo "<strong>" . htmlspecialchars($p['name']) . "</strong> ";
        echo "(" . $p['price'] . " €)";
        echo "</li>";
    }
    echo "</ul>";
}

// --- TEST 2 : Afficher juste le T-shirt (ID 1) ---
echo "<h3>🔍 Recherche du produit n°1 (find)</h3>";
$produit = $repo->find(1);

if ($produit) {
    
    echo "Nom : <strong>" . htmlspecialchars($produit['name']) . "</strong><br>";
    echo "Description : " . htmlspecialchars($produit['description']) . "<br>";
    echo "Prix : " . $produit['price'] . " €";
} else {
    echo "Produit introuvable (Vérifie l'ID).";
}