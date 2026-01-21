<?php
// On affiche les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'ProductRepository.php';

// Connexion
$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new ProductRepository($pdo);

echo "<h1>🔍 Test des Recherches Avancées (Exercice 3)</h1>";

// 1. Test par Catégorie (Vêtements = ID 1 normalement)
echo "<h3>1. Produits de la catégorie 'Vêtements' (ID 1)</h3>";
$vetements = $repo->findByCategory(1);

if (empty($vetements)) {
    echo "⚠️ Aucun vêtement trouvé (As-tu bien des produits avec category_id = 1 ?)<br>";
} else {
    foreach ($vetements as $p) {
        echo "✅ " . $p->getName() . "<br>";
    }
}

// 2. Test du Stock
echo "<h3>2. Produits en stock</h3>";
$stock = $repo->findInStock();
foreach ($stock as $p) {
    echo "📦 " . $p->getName() . " (Stock: " . $p->getStock() . ")<br>";
}

// 3. Test Prix
echo "<h3>3. Produits entre 0€ et 1000€</h3>";
$prix = $repo->findByPriceRange(0, 1000);
foreach ($prix as $p) {
    echo "💰 " . $p->getName() . " (" . $p->getPrice() . "€)<br>";
}

// 4. Test Recherche Texte
echo "<h3>4. Recherche du mot 'Test' (ou un mot de tes produits)</h3>";
// Change "Test" par un mot qui existe dans tes produits si besoin
$results = $repo->search("sac"); 
foreach ($results as $p) {
    echo "🔍 Trouvé : " . $p->getName() . "<br>";
}