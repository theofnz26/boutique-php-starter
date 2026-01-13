<?php
session_start();

$error = null;

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérification (En vrai, on vérifierait dans une BDD)
    if ($username === 'admin' && $password === '1234') {
        
        // SUCCÈS : On enregistre l'utilisateur en session
        $_SESSION['user'] = $username;
        
        // Redirection vers l'espace membre
        header('Location: dashboard.php');
        exit; // Toujours mettre exit après une redirection !
        
    } else {
        $error = "Identifiants incorrects ! (Essaie admin / 1234)";
    }
}
?>
<!DOCTYPE html>
<body>
    <h1>Connexion</h1>
    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Pseudo" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
</body>