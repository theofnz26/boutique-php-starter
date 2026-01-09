<?php
//produit
$stock = 5;          
$active = true;      
$promoEndDate = "2026-01-09"; 

echo "<h1>Détails du produit</h1>";

//PARTIE 1 : EST-CE DISPONIBLE ?
// La condition combinée : Il faut du stock ET (&&) qu'il soit actif
if ($stock > 0 && $active === true) {
    echo "<p style='color: green; font-weight: bold;'>✅ Product Available</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>❌ Product Unavailable</p>";
}

//PARTIE 2 : EST-CE EN PROMO ?
// On compare les "timestamps" (le temps en secondes)
$today = time();                  
$promoLimit = strtotime($promoEndDate); 

echo "<p><i>Date du jour : " . date('Y-m-d') . "</i></p>";

// Si "maintenant" est plus petit (avant) que la "limite"
if ($today < $promoLimit) {
    echo "<p style='color: orange; font-weight: bold;'>🔥 ON SALE !</p>";
    echo "Promo ends on : $promoEndDate";
} else {
    echo "<p>💸 Regular Price (Promo expired)</p>";
}
?>