<?php
// Les données de base
$prixHT = 100;
$TVA = 20;
$remise = 10;

// 1. Calculer le montant de la taxe
function calculeTVA($prixHT, $TVA) {
    $montantTVA = $prixHT * ($TVA / 100);
    return $montantTVA;
}

// 2. Calculer le prix TTC
// On ajoute le montant de la TVA au prix HT
function prixTTC($prixHT, $TVA) {
    
    $montantTVA = calculeTVA($prixHT, $TVA); 
    
    $prixTTC = $prixHT + $montantTVA;
    return $prixTTC;
}

// 3. Calculer le prix après remise 
function calculeRemise($prixTTC, $remise) {
    // Étape A : On calcule combien on enlève (ex: 10% de 120€)
    $montantDeLaRemise = $prixTTC * ($remise / 100);
    
    // Étape B : On soustrait ça du prix
    $prixFinal = $prixTTC - $montantDeLaRemise;
    
    return $prixFinal;
}

// --- ZÔNE DE TEST (Affichage) ---

// On lance les calculs
$monPrixTTC = prixTTC($prixHT, $TVA); // Donne 120
$monPrixFinal = calculeRemise($monPrixTTC, $remise); // Donne 108

echo "Prix de base : $prixHT € <br>";
echo "Prix avec TVA : $monPrixTTC € <br>";
echo "<b>Prix final avec promo : $monPrixFinal €</b>";

?>