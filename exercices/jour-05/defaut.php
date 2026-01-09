<?php

// Fonction pour formater un prix
// $decimals = 2 : Si on ne précise pas, on veut 2 chiffres après la virgule
// $symbol = "€" : Si on ne précise pas, c'est en Euros
function formatPrice($price, $decimals = 2, $symbol = "€") {
    // number_format est une fonction native de PHP qui arrondit et met les virgules
    $prixFormate = number_format($price, $decimals, ",", " ");
    
    return $prixFormate . " " . $symbol;
}

echo "<h1>Tests Valeurs par défaut</h1>";

// Test 1 : Je ne donne QUE le prix
// Il va prendre les valeurs par défaut (2 décimales, €)
echo formatPrice(12.55555) . "<br>"; 

// Test 2 : Je change le symbole ($)
// Je suis obligé de remettre '2' pour les décimales car c'est le 2ème paramètre
echo formatPrice(12.55555, 2, "$") . "<br>";

// Test 3 : Je ne veux pas de virgule (0 décimale)
echo formatPrice(12.55555, 0) . "<br>";

?>