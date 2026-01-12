<?php

// 1. Récupération des paramètres
// Si ?name=Alice existe dans l'URL, $nom vaut "Alice". Sinon, il vaut "Visiteur".
$nom = $_GET['name'] ?? 'Visiteur';

// Idem pour l'âge, mais on met null par défaut pour savoir s'il est absent
$age = $_GET['age'] ?? null;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice 1 : GET</title>
</head>
<body>

    <h1>Bonjour <?= $nom ?> !</h1>

    <?php if ($age): ?>
        <p>Vous avez <?= $age ?> ans.</p>
    <?php endif; ?>

    <hr>
    
    <h3>Testez ces liens :</h3>
    <ul>
        <li><a href="bonjour.php">Sans rien</a></li>
        <li><a href="bonjour.php?name=Marie">Avec un nom</a></li>
        <li><a href="bonjour.php?name=Pierre&age=30">Avec nom et âge</a></li>
    </ul>

</body>
</html>