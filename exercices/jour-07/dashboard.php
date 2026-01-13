<?php
session_start();

// SÉCURITÉ : Est-ce que l'utilisateur est connecté ?
if (!isset($_SESSION['user'])) {
    // Non ? Alors redirection vers le login
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<body>
    <h1>🎉 Bienvenue dans la zone VIP, <?= htmlspecialchars($_SESSION['user']) ?> !</h1>
    <p>Seuls les gens connectés peuvent voir ça.</p>
    
    <a href="logout.php">Se déconnecter</a>
</body>