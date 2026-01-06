<?php
// 1. Notre base de données (Tableau simple)
$categories = ["Vêtements", "Chaussures", "Accessoires", "Sport"];

?>

<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>Résultats de la recherche</h1>

    <?php
    // --- TEST 1 : Est-ce que "Chaussures" existe ? ---
    $recherche1 = "Chaussures";
    
    // in_array(ce_qu'on_cherche, le_tableau)
    if (in_array($recherche1, $categories)) {
        echo "<p>[TROUVÉ] La catégorie <strong>$recherche1</strong> existe.</p>";
    } else {
        echo "<p>[ERREUR] La catégorie <strong>$recherche1</strong> est introuvable.</p>";
    }


    // --- TEST 2 : Est-ce que "Électronique" existe ? ---
    $recherche2 = "Électronique";

    if (in_array($recherche2, $categories)) {
        echo "<p>[TROUVÉ] La catégorie <strong>$recherche2</strong> existe.</p>";
    } else {
        echo "<p>[ERREUR] La catégorie <strong>$recherche2</strong> est introuvable.</p>";
    }


    // --- TEST 3 : À quelle position est "Sport" ? ---
    // array_search renvoie l'index (le numéro du casier)
    $position = array_search("Sport", $categories);

    echo "<hr>";
    echo "<p>La catégorie <strong>Sport</strong> se trouve dans le casier n° : <strong>$position</strong></p>";
    ?>

</body>
</html>