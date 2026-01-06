<?php

$nom = "MacBook Air M2";

$description = "Puce Apple M2, écran Liquid Retina 13,6 pouces, 8 Go de RAM, 256 Go SSD.";

$prixHT = 999;

$tva = 20;

$stock = 5;

//Calcule

// Calcul 1 : Combien d'argent représente la taxe ?
// (999 * 20 / 100 = 199.8)
$montantTva = $prixHT * $tva / 100;

// Calcul 2 : Quel est le prix final que le client paie ?
// (999 + 199.8 = 1198.8)
$prixTTC = $prixHT + $montantTva;


// Problème : PHP va calculer 1198.8
// Solution : La fonction "number_format" transforme ça en "1 198,80"
// Paramètres : (le nombre, combien de décimales, le séparateur virgule, le séparateur millier)
$prixJoli = number_format($prixTTC, 2, ',', ' '); 

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $nom ?></title>

    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; padding: 20px; }
        .card { background: white; border-radius: 10px; padding: 20px; max-width: 400px; margin: 0 auto; }
        h1 { color: #333; }
        .prix-box { background: #eef; color: #2a2a72; padding: 10px; font-weight: bold; text-align: center; }
        .stock { color: green; }
    </style>
</head>
<body>

    <div class="card">
        
        <h1><?= $nom ?></h1>
        
        <p><?= $description ?></p>
        
        <div class="prix-box">
            Prix TTC : <?= $prixJoli ?> €
            <br>
            <small>(Dont TVA : <?= $montantTva ?> €)</small>
        </div>

        <p class="stock">
            En stock : <?= $stock ?> unités
        </p>
    </div>

</body>
</html>