<?php
// Déclaration des variables (nom de la variable = la valeur)
$name = "Deck Yugioh"; // String 
$price = 19.99;         // Float
$stock = 42;            // Int
$onSale = true;         // Bool

// Inspection technique (var_dump)
// Cela permet de voir le TYPE de la variable
echo "--- DEBUG (Vision technique) ---\n";
var_dump($name);
var_dump($price);
var_dump($stock);
var_dump($onSale);

// Affichage client (echo)

echo "\n--- AFFICHAGE CLIENT ---\n";
echo "Le produit $name coûte $price €";