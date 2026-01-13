<?php
// Initialisation des variables
$errors = [];
$success = false;

// Variables pour pré-remplir le formulaire (vides au départ)
$username = '';
$email = '';

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Récupération (On stocke dans les variables pour pouvoir les réafficher)
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    // 2. Validations
    
    // Username : Alpha-numérique, 3 à 20 caractères
    // preg_match vérifie si ça correspond au "motif" (regex)
    // ^ = début, [a-zA-Z0-9] = lettres/chiffres, {3,20} = taille, $ = fin
    if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username)) {
        $errors['username'] = "Le pseudo doit contenir 3 à 20 lettres ou chiffres.";
    }

    // Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email n'est pas valide.";
    }

    // Mot de passe (Min 8 caractères)
    if (strlen($password) < 8) {
        $errors['password'] = "Le mot de passe doit faire au moins 8 caractères.";
    }

    // Confirmation du mot de passe
    if ($password !== $confirm) {
        $errors['confirm'] = "Les mots de passe ne correspondent pas.";
    }

    // 3. Succès ?
    if (empty($errors)) {
        $success = true;
        // Ici, on enregistrerait en base de données...
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 500px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        /* Style pour les erreurs */
        .error-msg { color: #dc3545; font-size: 0.85rem; margin-top: 4px; }
        .is-invalid { border-color: #dc3545; }
        
        .success-box { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; text-align: center; }
        button { background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; width: 100%; }
        button:hover { background: #218838; }
    </style>
</head>
<body>

    <h1>Créer un compte</h1>

    <?php if ($success): ?>
        <div class="success-box">
            <h2>🎉 Félicitations !</h2>
            <p>Votre compte a bien été créé avec le pseudo <strong><?= htmlspecialchars($username) ?></strong>.</p>
        </div>
    <?php else: ?>

        <form action="inscription.php" method="POST">
            
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" 
                       name="username" 
                       id="username" 
                       value="<?= htmlspecialchars($username) ?>"
                       class="<?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                >
                <?php if (isset($errors['username'])): ?>
                    <div class="error-msg"><?= $errors['username'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" 
                       name="email" 
                       id="email" 
                       value="<?= htmlspecialchars($email) ?>"
                       class="<?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                >
                <?php if (isset($errors['email'])): ?>
                    <div class="error-msg"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="<?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['password'])): ?>
                    <div class="error-msg"><?= $errors['password'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confirm">Confirmer le mot de passe</label>
                <input type="password" name="confirm" id="confirm" class="<?= isset($errors['confirm']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['confirm'])): ?>
                    <div class="error-msg"><?= $errors['confirm'] ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">S'inscrire</button>
        </form>

    <?php endif; ?>

</body>
</html>