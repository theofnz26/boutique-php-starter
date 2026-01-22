<?php

// Créer une fonction qui convertit des euros en dollars
function convertEuroToDollar(float $amountInEuro): float
{
    $conversionRate = 1.1; // Taux de conversion fixe
    return $amountInEuro * $conversionRate;
}