<?php
// Liste 1 : Produits Tech
$techProducts = ["Ordinateur", "Souris", "Clavier"];

// Liste 2 : Produits Meubles
$furnitureProducts = ["Bureau", "Chaise"];

echo "--- AVANT LA FUSION ---\n";
echo "Liste Tech : \n";
print_r($techProducts);
// Tu verras : Array ( [0] => Ordinateur [1] => Souris [2] => Clavier )

echo "\nListe Meubles : \n";
print_r($furnitureProducts);
// Tu verras : Array ( [0] => Bureau [1] => Chaise )


// --- LA FUSION ---
// On crée un nouveau tableau qui est la somme des deux
$fullCatalog = array_merge($techProducts, $furnitureProducts);


echo "\n-----------------------\n";
echo "--- APRÈS LA FUSION ---\n";
// Regarde bien les index (les numéros) !
print_r($fullCatalog);

// Si tout va bien, "Bureau" ne sera plus [0] mais [3]
?>
