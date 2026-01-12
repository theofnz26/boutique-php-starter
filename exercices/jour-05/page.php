<?php
// 👇 C'EST ICI QUE LA MAGIE OPÈRE 👇
// On va chercher nos outils. Sans cette ligne, les fonctions n'existent pas ici.
require_once "helpers.php";

$prixTelephone = 999;
$prixEcouteurs = 50;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exo 6 : Helpers</title>
</head>
<body>

    <h1>Mon Panier</h1>

    <p>
        Iphone 16 <?= badge("NOUVEAU", "blue") ?>
    </p>

    <ul>
        <li>
            Prix HT : <?= formatPrice($prixTelephone) ?> <br>
            Prix TTC : <strong><?= formatPrice(calculateTTC($prixTelephone)) ?></strong>
        </li>
    </ul>

</body>
</html>