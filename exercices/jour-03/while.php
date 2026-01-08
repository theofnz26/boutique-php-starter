<?php
// 1. On prépare la variable à 0 pour être sûr d'entrer dans la boucle
$dice = null;

echo "<h2>Jeu du Dé : On veut un 6 !</h2>";

// 2. TANT QUE le dé n'est PAS égal (!=) à 6
while ($dice != 6) {

  
    
    
    $dice = rand(1, 6);
    
    
    echo "J'ai fait un " . $dice . "<br>";
    
    
}

echo "<strong>Bravo ! Tu as fait un 6 !</strong>";

$cagnotte = 0; // On commence à 0 euros
$objectif = 500; // Le prix de la console

echo "<h3>Je commence à économiser pour la ps5!</h3>";

// TANT QUE la cagnotte est INFÉRIEURE (<) à l'objectif...
while ($cagnotte < $objectif) {
    
    // 1. On gagne un montant au hasard (entre 10 et 50)
    $economie = rand(10, 60) ; 

    // 2. On ajoute ce montant à la cagnotte
    // (La nouvelle cagnotte = l'ancienne + l'économie)
    $cagnotte = $cagnotte + $economie ;

    // 3. On affiche où on en est
    echo "J'ai ajouté " . $economie . "€. J'ai maintenant : " . $cagnotte . "€ <br>";

}

echo "<strong>J'ai atteint " . $cagnotte . "€ ! Je peux acheter la console !</strong>";


?>