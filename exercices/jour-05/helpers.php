<?php
// helpers.php : Ma bibliothèque de fonctions réutilisables

/**
 * Formate un prix (ex: 12.5 => "12,50 €")
 */
function formatPrice($price, $symbol = "€") {
    return number_format($price, 2, ",", " ") . " " . $symbol;
}

/**
 * Calcule un prix TTC
 */
function calculateTTC($priceHT, $tva = 20) {
    return $priceHT * (1 + $tva / 100);
}

/**
 * Affiche un badge HTML coloré
 */
function badge($label, $color) {
    return "<span style='background-color:$color; color:white; padding:3px 8px; border-radius:4px;'>$label</span>";
}
?>