<?php

// Partie 1 : Les 3 méthodes d'assemblage
$brand = "Nike";
$model = "Air Max";

// 1. Avec concaténation (le point .)
// On ferme la chaine, on met un point, on met la variable, on remet un point...
echo 'Chaussures ' . $brand . ' ' . $model . "\n";
echo "\n---\n";
// 2. Avec interpolation (les guillemets doubles "")
// On met tout dedans, PHP remplace les variables.
echo "Chaussures $brand $model\n";
echo "\n---\n";
// 3. Avec sprintf()
// %s est un "placeholder" (une place réservée) pour une string.
echo sprintf("Chaussures %s %s", $brand, $model) . "\n";


echo "\n--- TEST DIFFERENCE ---\n";

// Partie 2 : Le test des guillemets
$price = 99.99;

// Cas A : Guillemets doubles
echo "Prix : $price €\n";

// Cas B : Guillemets simples
echo 'Prix : $price €';