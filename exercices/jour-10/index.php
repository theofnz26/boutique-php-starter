<?php

require_once 'ProductRepository.php';
// On charge Product.php pour être sûr que PHP connaît la classe
require_once 'Product.php';

// 1. Configuration de la connexion
$host = "localhost";
$dbname = "boutique";
$user = "dev";
$pass = "dev";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie à la BDD (User: $user).<br><hr>";
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}

// 2. Initialisation du Repository
$repo = new ProductRepository($pdo);

// ==========================================
// 🔄 TEST DU CRUD (Cycle de vie)
// ==========================================
echo "<h2>🔄 Test du Cycle de Vie (CRUD Objet)</h2>";

// 1. CREATE : On crée un produit temporaire
echo "Step 1 : Création... ";
// ⚠️ ATTENTION : On met '1' pour l'ID catégorie (Vêtements), et non plus le texte
$repo->create("Produit Fantôme", "Va disparaitre", 10.0, 5, 1);

// On récupère l'ID généré
$lastId = $pdo->lastInsertId();
echo "<strong>ID généré : $lastId</strong><br>";

// 2. READ : On vérifie qu'il est là
$p = $repo->find($lastId);

if ($p) {
    // 👇 ICI LE CHANGEMENT MAJEUR : On utilise les méthodes de l'objet (->)
    echo "Step 2 : Vérification -> Nom actuel : " . $p->getName() . " (" . $p->getPrice() . "€)<br>";
}

// 3. UPDATE : On le modifie
echo "Step 3 : Modification... ";
$repo->update($lastId, "Fantôme MODIFIÉ", 999.99);

// On revérifie
$p = $repo->find($lastId);
if ($p) {
    echo "-> Nouveau nom : " . $p->getName() . " (" . $p->getPrice() . "€)<br>";
}

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

// ==========================================
// 🕵️ TESTS DES RECHERCHES AVANCÉES (EXO 3)
// ==========================================
echo "<h2>🕵️ Tests des Recherches (Mode Objet)</h2>";

// TEST 1 : Par catégorie (ID 1 = Vêtements)
echo "<h3>👕 Produits de la catégorie 1 (Vêtements)</h3>";
$vetements = $repo->findByCategory(1);

if (empty($vetements)) {
    echo "Aucun vêtement trouvé.<br>";
} else {
    foreach ($vetements as $product) {
        // On utilise les Getters de l'objet Product
        echo "📦 " . $product->getName() . " (" . $product->getPrice() . " €)<br>";
    }
}

// TEST 2 : Produits en stock
echo "<h3>✅ Produits en stock (> 0)</h3>";
$stock = $repo->findInStock();
foreach ($stock as $product) {
    echo "- " . $product->getName() . " (Stock: " . $product->getStock() . ")<br>";
}

// TEST 3 : Recherche texte
echo "<h3>🔍 Recherche du mot 'Sport'</h3>";
$results = $repo->search("Sport");

if (empty($results)) {
    echo "Aucun résultat pour 'Sport'.<br>";
} else {
    foreach ($results as $product) {
        echo "🔎 Trouvé : " . $product->getName() . " (" . $product->getDescription() . ")<br>";
    }
}

echo "<br><br><br>"; // Juste pour faire de la place en bas de page