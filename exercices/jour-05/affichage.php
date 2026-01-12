<?php

// 1. Fonction pour afficher un BADGE
function displayBadge($text, $color) {
    // On retourne une chaîne de caractères qui contient des balises HTML
    // Attention aux guillemets ! J'utilise des doubles " pour encadrer le tout,
    // et des simples ' pour les attributs HTML (style='...') pour ne pas mélanger.
    return "<span style='background-color: $color; color: white; padding: 5px; border-radius: 4px;'>$text</span>";
}

// 2. Fonction pour afficher le STOCK (avec couleur automatique)
function displayStock($quantity) {
    if ($quantity === 0) {
        return "<span style='color: red; font-weight: bold;'>Rupture de stock</span>";
    } elseif ($quantity < 5) {
        return "<span style='color: orange;'>Derniers articles ($quantity)</span>";
    } else {
        return "<span style='color: green;'>En stock</span>";
    }
}

// 3. Fonction pour afficher le PRIX (Barré si promo)
function displayPrice($price, $discount = 0) {
    // Si pas de remise, on affiche juste le prix
    if ($discount === 0) {
        return number_format($price, 2) . " €";
    }
    
    // Sinon, on calcule le nouveau prix
    $newPrice = $price - ($price * $discount / 100);
    
    // Et on retourne : Le vieux prix barré (<del>) + Le nouveau prix
    // <del>100.00 €</del> 80.00 €
    return "<del>" . number_format($price, 2) . " €</del> <b>" . number_format($newPrice, 2) . " €</b>";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice 5 : Affichage</title>
    <style>body { font-family: sans-serif; padding: 20px; line-height: 2; }</style>
</head>
<body>

    <h1>Tests d'affichage</h1>

    <h3>1. Badges :</h3>
    <?= displayBadge("NOUVEAU", "blue") ?>
    <?= displayBadge("PROMO", "red") ?>
    <?= displayBadge("VEGAN", "green") ?>

    <hr>

    <h3>2. Stocks :</h3>
    Produit A : <?= displayStock(0) ?> <br>
    Produit B : <?= displayStock(3) ?> <br>
    Produit C : <?= displayStock(50) ?> <br>

    <hr>

    <h3>3. Prix :</h3>
    Prix normal (100€) : <?= displayPrice(100) ?> <br>
    Prix Soldé (100€ - 20%) : <?= displayPrice(100, 20) ?> <br>

</body>
</html>