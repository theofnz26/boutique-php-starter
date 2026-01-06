<?php

//ETAPE 1 : INFOS DE DEPART 

$prixHT = 100;      
$tva = 20;          // Taxe 20%
$quantite = 3;      // Le client en veut 3

//ETAPE 2 : LES CALCULS

// D'abord, je dois trouver combien ça fait d'argent, ces 20% de taxe.
// Calcul : 100 * 20 / 100
$montantTva = $prixHT * $tva / 100;

// Maintenant, je connais le vrai prix d'un seul article (Prix de base + la taxe)
$prixUnitaireTTC = $prixHT + $montantTva;

//je multiplie par le nombre d'articles pour avoir la note finale
$totalAPayer = $prixUnitaireTTC * $quantite;


// ETAPE 3 : LE RESULTAT 
// "\n" pour passer à la ligne dans l'affichage.

echo "Prix d'un article (TTC) : $prixUnitaireTTC € \n";
echo "J'en ai pris : $quantite \n";
echo "TOTAL COMMANDE : $totalAPayer €";