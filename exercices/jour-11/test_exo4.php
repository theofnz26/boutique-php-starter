<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'CategoryRepository.php';

$pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
$repo = new CategoryRepository($pdo);

echo "<h1>📂 Test CategoryRepository (Exercice 4)</h1>";

// TEST 1 : Création d'une catégorie Test
echo "<h3>1. Création</h3>";
$newCat = new Category(null, "Gaming");
$repo->save($newCat);

// TEST 2 : findWithProducts
echo "<h3>2. Affichage des rayons et de leur contenu</h3>";
$categories = $repo->findWithProducts();

echo "<ul>";
foreach ($categories as $cat) {
    echo "<li><strong>📂 " . $cat->getNom() . "</strong>";
    
    // On récupère les produits rangés dans la catégorie
    $produits = $cat->getProducts();
    
    if (empty($produits)) {
        echo " <em>(Vide)</em>";
    } else {
        echo "<ul>";
        foreach ($produits as $p) {
            echo "<li>🎮 " . $p->getName() . " - " . $p->getPrice() . "€</li>";
        }
        echo "</ul>";
    }
    echo "</li>";
}
echo "</ul>";