<?php

// 1. Création du tableau indexé (0, 1, 2...)
$groceries = ["Pommes", "Pâtes", "Shampoing", "Avocats", "Poulet"];

echo "--- DEBUT ---\n";

// Affiche le premier (Index 0)
echo "Premier article : " . $groceries[0] . "\n";

// Affiche le dernier (Méthode dynamique)
// Si count = 5, le dernier index est 4. Donc count - 1.
$nbArticles = count($groceries);
echo "Dernier article : " . $groceries[$nbArticles - 1] . "\n";

echo "Total articles : $nbArticles \n";


// 2. Modifications

// Ajouter à la fin (les crochets vides [])
$groceries[] = "Dentifrice";
$groceries[] = "Riz";

// Supprimer le 3ème article (Index 2 : Shampoing)
unset($groceries[2]);


// 3. Résultat final
echo "\n--- FIN ---\n";
var_dump($groceries);