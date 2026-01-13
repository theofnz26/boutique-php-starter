<?php
// 1. On démarre la mémoire (OBLIGATOIRE au début)
session_start();

// 2. Logique de réinitialisation
// Si on clique sur le lien ?reset=1, on remet le compteur à 0
if (isset($_GET['reset'])) {
    unset($_SESSION['visits']); // On détruit juste cette variable
    // ou session_destroy(); pour tout détruire
}

// 3. Gestion du compteur
if (!isset($_SESSION['visits'])) {
    // Si la variable n'existe pas, on l'initialise à 0
    $_SESSION['visits'] = 0;
}

// On ajoute 1 à chaque chargement de page
$_SESSION['visits']++;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compteur Session</title>
</head>
<body>

    <h1>Mouchard de visites 🕵️‍♂️</h1>

    <p>Vous avez vu cette page <strong><?= $_SESSION['visits'] ?></strong> fois.</p>

    <p>
        <a href="compteur.php">🔄 Recharger la page</a><br>
        <a href="compteur.php?reset=1" style="color:red">🗑️ Remettre à zéro</a>
    </p>

    <hr>
    <h3>❓ Teste ceci :</h3>
    <ul>
        <li>Actualise la page plusieurs fois (le nombre monte).</li>
        <li>Copie l'URL et ouvre-la dans une fenêtre "Navigation Privée". (Le compteur repart à 1 ! C'est une autre session).</li>
        <li>Ferme ton navigateur complètement et rouvre-le. (La session est généralement perdue).</li>
    </ul>

</body>
</html>