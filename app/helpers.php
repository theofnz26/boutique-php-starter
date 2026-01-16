<?php
// app/helpers.php

// 1. CALCULS (TTC)
function calculateTTC($priceHT, $tva = 20) {
    return $priceHT * (1 + $tva / 100);
}

// 2. FORMATAGE (12.5 => 12,50 €)
function formatPrice(int | float $price): mixed {
    return number_format($price, 2, ",", " ") . " €";
}

// 3. AFFICHAGE PRIX (Gère la promo)
// Le catalogue appelle cette fonction : displayPrice
function displayPrice($price, $discount) {
    $ttc = calculateTTC($price);
    
    if ($discount > 0) {
        $montantRemise = $ttc * ($discount / 100);
        $prixFinal = $ttc - $montantRemise;
        // Retourne le code HTML du prix
        return '<del style="color:#999">' . formatPrice($ttc) . '</del> ' . 
               '<strong style="color:red">' . formatPrice($prixFinal) . '</strong>';
    }
    
    return '<strong>' . formatPrice($ttc) . '</strong>';
}

// 4. AFFICHAGE STOCK (Gère les couleurs)
// Le catalogue appelle cette fonction : displayStock
function displayStock($stock) {
    if ($stock === 0) {
        return '<span style="color:red; font-weight:bold">⚠ RUPTURE</span>';
    } elseif ($stock < 5) {
        return '<span style="color:orange; font-weight:bold">⚡ Vite ! Plus que ' . $stock . '</span>';
    } else {
        return '<span style="color:green; font-weight:bold">✅ En stock</span>';
    }
}
// 5. DEBUG (L'outil de détective)
// Affiche le contenu d'une variable et ARRÊTE le script immédiatement.
function dump_and_die($variable) {
    echo '<pre style="background: black; color: #00ff00; padding: 20px; font-weight: bold; z-index: 9999; position: relative;">';
    var_dump($variable);
    echo '</pre>';
    die(); // C'est ici qu'on tue le script. Plus rien ne s'exécute après.
}
?>