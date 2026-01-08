<?php
$a = 0;       // Le chiffre zéro
$b = "";      // Une chaîne de texte vide
$c = null;    // La valeur "rien" (néant)
$d = false;   // Le booléen Faux
$e = "0";     // Le texte "0"

if ($a == $a) {
    $statut = "$a == $a est vrai <br>";
    echo "<br>$statut";
} else {
    $statut = "$a == $a est faux <br>";
    echo "<br>$statut";
}
if ($a == $b) {
    $statut = "$a == '' est vrai <br>";
    echo "<br>$statut";
} else {
    $statut = "$a == '' est faux <br>";
    echo "<br>$statut";
}
if ($a == $c) {
    $statut = "$a == null est vrai <br>";
    echo "<br>$statut";
} else {
    $statut = "$a == null est faux <br>";
    echo "<br>$statut";
}
if ($a == $d) {
    $statut = "$a == false est vrais <br>";
    echo "<br> $statut";
} else {
    $statut = "$a == false est faux <br>";
    echo "<br>$statut";
}
if ($a == $e) {
    $statut = "$a == $e est vrais <br>";
    echo "<br> $statut";
} else {
    $statut = "$a == $e est faux <br>";
    echo "<br>$statut";
}

//-----------------------------

if ($a === $a) {
    $statut = "$a === $a est vrai <br>";
    echo "<br>$statut";
} else {
    $statut = "$a === $a est faux <br>";
    echo "<br>$statut";
}
if ($a === $b) {
    $statut = "$a === '' est vrai <br>";
    echo "<br>$statut";
} else {
    $statut = "$a === '' est faux <br>";
    echo "<br>$statut";
}
if ($a === $c) {
    $statut = "$a === null est vrai <br>";
    echo "<br>$statut";
} else {
    $statut = "$a === null est faux <br>";
    echo "<br>$statut";
}
if ($a === $d) {
    $statut = "$a === false est vrais <br>";
    echo "<br> $statut";
} else {
    $statut = "$a === false est faux <br>";
    echo "<br>$statut";
}
if ($a === $e) {
    $statut = "$a === $e est vrais <br>";
    echo "<br> $statut";
} else {
    $statut = "$a === $e est faux <br>";
    echo "<br>$statut";
}

?>