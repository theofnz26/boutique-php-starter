<?php

//STOCK ?
function isInStock($stock) {
    //VRAI si le stock est strictement supérieur à 0
    return $stock > 0;
}

//EN PROMO ?
function isOnSale($discount) {
    //VRAI si la remise est supérieure à 0
    return $discount > 0;
}

//C'EST NOUVEAU ? (< 30 jours)
function isNew($dateAdded) {
    // A. On récupère l'heure actuelle en secondes
    $now = time();
    
    // B. On transforme la date du produit en secondes
    $productDate = strtotime($dateAdded);
    
    // C. On calcule la différence
    $secondsDiff = $now - $productDate;
    
    // D. On convertit en jours (1 jour = 86400 secondes)
    $daysDiff = $secondsDiff / 86400;
    
    //VRAI si c'est inférieur à 30 jours
    return $daysDiff < 30;
}

//PEUT-ON COMMANDER ? (Stock suffisant)
function canOrder($stock, $quantity) {
    // VRAI si le stock est plus grand ou égal à la quantité demandée
    return $stock >= $quantity;
}

// --- TESTS ---
echo "<h1>Tests de validation</h1>";

// Test Stock
echo "Stock vide (0) ? " . (isInStock(0) ? "✅ Oui" : "❌ Non") . "<br>"; // Doit dire Non
echo "Stock plein (5) ? " . (isInStock(5) ? "✅ Oui" : "❌ Non") . "<br>"; // Doit dire Oui

// Test Commande
echo "Peut-on commander 3 produits si stock 2 ? " . (canOrder(2, 3) ? "Oui" : "Non") . "<br>"; // Non

// Test Nouveauté
// Change la date ici pour tester (mets une date d'il y a 2 jours, puis d'il y a 2 mois)
$dateProduit = "2026-01-12"; 
echo "Le produit du $dateProduit est nouveau ? ";
var_dump(isNew($dateProduit)); // Affiche bool(true) ou bool(false)

?>