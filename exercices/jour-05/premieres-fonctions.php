<?php

// 1. DÉFINITION : On crée une fonction simple (sans ingrédient)
// Elle sert juste à afficher un message fixe.
function greet() {
    echo "Bienvenue sur la boutique !<br>";
}

// 2. DÉFINITION : On crée une fonction avec un PARAMÈTRE
// $name est une variable "fantôme" qui prendra la valeur qu'on lui donne lors de l'appel.
function greetClient($name) {
    echo "Bonjour " . $name . " !<br>";
}

echo "<h1>Tests des fonctions</h1>";

// 3. APPEL : On utilise nos fonctions
greet(); // Affiche : Bienvenue sur la boutique !

greetClient("Alice"); 
greetClient("Bob"); 
greetClient("Zorro"); 

?>