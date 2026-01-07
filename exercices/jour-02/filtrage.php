<?php
// 1. Notre liste de prix en vrac
$prices = [12.50, 200.00, 45.00, 800.00, 9.99, 60.00];

// 2. Le FILTRAGE
// On stocke le résultat dans une NOUVELLE variable ($smallBudget)
// On utilise le mot-clé OBLIGATOIRE "function"

$smallBudget = array_filter($prices, function($price) {
    
    // --- ICI, C'EST TA RÈGLE DU JEU ---
    // On garde seulement si le prix est strictement inférieur à 50
    return $price < 50;

});

?>

<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>Filtre "Petit Budget" (< 50€)</h1>

    <h3>Liste complète (Avant) :</h3>
    <pre><?php print_r($prices); ?></pre>

    <hr>

    <h3 style="color: green;">Liste filtrée (Après) :</h3>
    <pre><?php print_r($smallBudget); ?></pre>

</body>
</html>