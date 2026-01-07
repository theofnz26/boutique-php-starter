<?php
$personne = [
    "nom" => "Theo",
    "age" => 27,
    "ville" => "Valence",
    "metier" => "Développeur Web"
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice 2</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        ul { list-style-type: none; padding: 0; }
        li { background: #f0f0f0; margin: 5px 0; padding: 10px; border-radius: 5px; }
        strong { color: #2c3e50; text-transform: capitalize; } /* capitalize met la 1ère lettre en majuscule */
    </style>
</head>
<body>
    <h1>Fiche d'identité</h1>
    
    <ul>
    <?php
    foreach ($personne as $key => $value) {

        echo "<li> <strong>" . $key . "</strong> : " . $value . "</li>";

    }
    ?>
        </ul>
    
</body>
</html>