<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'ProductRepository.php';

// Connexion
$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new ProductRepository($pdo);

echo "<h1>⚙️ Test CRUD Complet (Exercice 2)</h1>";


// 1. CREATE : On crée un produit "Fantôme" pour tester

echo "<h3>1. Création...</h3>";

$nouveau = new Product(
    id: null, // Pas d'ID avant la sauvegarde
    name: "Produit Test " . rand(1, 1000), // Nom aléatoire pour repérer
    description: "Ceci est un test automatique",
    price: 99.99,
    stock: 10,
    categoryId: 1 // Assure-toi que la catégorie 1 existe !
);

$repo->save($nouveau);


// ASTUCE : Récupérer l'ID du produit qu'on vient de créer
// (Comme save() est void, on va chercher le dernier produit inséré via PDO)

$lastId = $pdo->lastInsertId();
echo "👉 ID du nouveau produit : <strong>$lastId</strong><br>";



// 2. UPDATE : On modifie ce produit

echo "<h3>2. Modification...</h3>";

// On récupère l'objet complet depuis la BDD pour être sûr
$produitAModifier = $repo->find($lastId);

if ($produitAModifier) {
    // On change ses valeurs via les Setters
    $produitAModifier->setName("Produit MODIFIÉ");
    $produitAModifier->setPrice(5.00);

    // On sauvegarde les changements
    $repo->update($produitAModifier);
    
    // Vérification visuelle
    $verif = $repo->find($lastId);
    echo "Nom actuel en BDD : " . $verif->getName() . " (Prix : " . $verif->getPrice() . "€)<br>";
}



// 3. DELETE : On supprime ce produit

echo "<h3>3. Suppression...</h3>";

$repo->delete($lastId);

// Vérification finale
$verifFinal = $repo->find($lastId);
if ($verifFinal === null) {
    echo "✅ Le produit n'existe plus. Test réussi !";
} else {
    echo "❌ Aïe, le produit est toujours là...";
}
