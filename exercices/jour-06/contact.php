<?php
// On initialise les variables pour éviter les erreurs d'affichage
$errors = [];
$success = false;

// On vérifie si le formulaire a été soumis (Méthode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Récupération des données (On utilise $_POST et pas $_GET)
    // trim() sert à enlever les espaces inutiles au début et à la fin
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // 2. Validation (Le "Videur")
    
    // Vérif Nom vide
    if (empty($name)) {
        $errors[] = "Le nom est obligatoire.";
    }

    // Vérif Email valide (PHP a une fonction toute prête pour ça !)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }

    // Vérif Message court
    if (strlen($message) < 10) {
        $errors[] = "Le message doit faire au moins 10 caractères.";
    }

    // 3. Si aucune erreur, c'est gagné !
    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 15px; padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

    <h1>Contactez-nous</h1>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <h3>✅ Message envoyé !</h3>
            <p>Merci <strong><?= htmlspecialchars($name) ?></strong>.</p>
            <p>Nous avons bien reçu : "<?= htmlspecialchars($message) ?>"</p>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="contact.php" method="POST">
        
        <label for="name">Votre Nom :</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Votre Email :</label>
        <input type="email" name="email" id="email" required>

        <label for="message">Votre Message :</label>
        <textarea name="message" id="message" rows="5"></textarea>

        <button type="submit">Envoyer</button>
    </form>

</body>
</html>