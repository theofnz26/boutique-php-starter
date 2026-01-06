<?php
// 1. La Logique (PHP)
$nom = "Écran 4K";
$prix = 299;
$stock = 12;
?>

<!DOCTYPE html>
<html>
<body>

    <h1>Produit : <?= $nom ?></h1>

    <p>Prix : <?= $prix ?> €</p>
    
    <p>Il reste <?= $stock ?> articles en stock.</p>

</body>
</html>