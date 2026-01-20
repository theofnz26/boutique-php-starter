<?php
// On affiche les erreurs pour être sûr que tout marche
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'ProductRepository.php';

// Connexion BDD
$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new ProductRepository($pdo);

echo "<h1>🔍 Test Jour 11 - Exercice 1</h1>";

// 1. Test findAll()
echo "<h3>📦 Liste de tous les produits :</h3>";
$produits = $repo->findAll();

foreach ($produits as $p) {
    echo "Product ID " . $p->getId() . " : " . $p->getName() . "<br>";
}

// 2. Test find(1) (Ou un autre ID qui existe)
echo "<h3>🔎 Recherche du produit ID 1 :</h3>";
$p1 = $repo->find(1);

if ($p1) {
    echo "Trouvé : " . $p1->getName() . " (" . $p1->getPrice() . " €)";
} else {
    echo "❌ Produit ID 1 introuvable.";
}