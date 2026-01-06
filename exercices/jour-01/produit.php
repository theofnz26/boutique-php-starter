<?php
// 1. Déclaration des variables (le nom de la variable = la valeur)
$name = "Deck Yugioh"; // String (Texte)
$price = 19.99;         // Float (Nombre à virgule)
$stock = 42;            // Int (Nombre entier)
$onSale = true;         // Bool (Vrai ou Faux)

// 2. Inspection technique (var_dump)
// Cela permet de voir le TYPE de la variable (utile pour le développeur)
echo "--- DEBUG (Vision technique) ---\n";
var_dump($name);
var_dump($price);
var_dump($stock);
var_dump($onSale);

// 3. Affichage client (echo)
// C'est ce que l'utilisateur final doit voir
echo "\n--- AFFICHAGE CLIENT ---\n";
echo "Le produit $name coûte $price €";