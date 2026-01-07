<?php
// FICHIER : app/data.php
// Rôle : Contenir uniquement les données brutes (le tableau).

$catalogue = [

    // PRODUIT 0
    [
        "nom" => "T-Shirt Geek",
        "prix" => 19.99,
        "stock" => 50,
        // CORRECTION ICI : Chemin web relatif (pas de /var/www/...)
        "image" => "/assets/images/pull.png"
    ],

    // PRODUIT 1
    [
        "nom" => "Tasse Café",
        "prix" => 9.50,
        "stock" => 120,
        "image" => "/assets/images/mug.png"
    ],

    // PRODUIT 2
    [
        "nom" => "Clavier Mécanique",
        "prix" => 89.90,
        "stock" => 10,
        "image" => "/assets/images/clavier.png"
    ], 

    // PRODUIT 3
    [
        "nom" => "Souris Gaming",
        "prix" => 45.00,
        "stock" => 25,
        "image" => "/assets/images/souris gaming.png"
    ],

    // PRODUIT 4
    [
        "nom" => "Écran 4K",
        "prix" => 299.99,
        "stock" => 5,
        "image" => "/assets/images/ecran.png"
    ],

    // PRODUIT 5
    [
        "nom" => "Casque Audio",
        "prix" => 59.00,
        "stock" => 0,
        "image" => "/assets/images/casque gaming.png"
    ]

];
// Fin des données. Pas besoin de balise fermante PHP ici.