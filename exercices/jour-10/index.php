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

// ... (Après la connexion $pdo et le new ProductRepository) ...

echo "<h2>🔄 Test du Cycle de Vie (CRUD Complet)</h2>";

// 1. CREATE : On crée un produit temporaire
echo "Step 1 : Création... ";
$repo->create("Produit Fantôme", "Va disparaitre", 10.0, 5, "Vêtements");

// 🪄 ASTUCE : On demande à PDO quel est l'ID du dernier truc créé
$lastId = $pdo->lastInsertId();
echo "<strong>ID généré : $lastId</strong><br>";

// 2. READ : On vérifie qu'il est là
$p = $repo->find($lastId);
echo "Step 2 : Vérification -> Nom actuel : " . $p['name'] . " (" . $p['price'] . "€)<br>";

// 3. UPDATE : On le modifie
echo "Step 3 : Modification... ";
$repo->update($lastId, "Fantôme MODIFIÉ", 999.99);

// On revérifie
$p = $repo->find($lastId);
echo "-> Nouveau nom : " . $p['name'] . " (" . $p['price'] . "€)<br>";

// 4. DELETE : On le supprime
echo "Step 4 : Suppression... ";
$repo->delete($lastId);

// 5. READ FINAL : On vérifie qu'il n'est plus là
$check = $repo->find($lastId);
if ($check === false) {
    echo "✅ Preuve : Le produit n'existe plus !";
} else {
    echo "❌ Aïe, il est encore là.";
}

echo "<hr>";

// --- AFFICHER LE RESTE DU STOCK ---
echo "<h3>📦 Stock Restant</h3>";
$list = $repo->findAll();
foreach($list as $item) {
    echo "ID " . $item['id'] . " : " . $item['name'] . "<br>";
}