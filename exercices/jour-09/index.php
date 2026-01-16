<?php

require_once 'Address.php';
require_once 'User.php';

// 1. Création de l'utilisateur
// "new DateTime()" sans argument crée la date et l'heure de l'instant présent
$user = new User("Yugi Muto", "yugi@duel-monsters.com", new DateTime());

// 2. Création des Adresses
$addrMaison = new Address("12 Rue du Domino", "75000", "Paris", "France");
$addrTravail = new Address("Tour Kaiba Corp", "92000", "La Défense", "France");

// 3. Ajout des adresses au User
$user->addAddress($addrMaison);
$user->addAddress($addrTravail);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jour 9 - Exo 4</title>
</head>
<body>
    <h1>Profil Utilisateur</h1>
    
    <p>
        <strong>Nom :</strong> <?= $user->nom ?><br>
        <strong>Email :</strong> <?= $user->email ?><br>
        <strong>Inscrit le :</strong> <?= $user->dateInscription->format('d/m/Y') ?>
    </p>

    <hr>

    <h3>📍 Adresse de livraison par défaut</h3>
    <?php 
    // On récupère l'adresse par défaut
    $default = $user->getDefaultAddress(); 
    
    if ($default) {
        echo "<p style='color:green'>" . $default->getFullAddress() . "</p>";
    } else {
        echo "<p style='color:red'>Aucune adresse renseignée.</p>";
    }
    ?>

    <hr>

    <h3>📚 Carnet d'adresses complet</h3>
    <ul>
        <?php foreach ($user->getAddresses() as $addr): ?>
            <li><?= $addr->getFullAddress() ?></li>
        <?php endforeach; ?>
    </ul>

</body>
</html>