<?php
require_once 'ProductRepository.php';

// 1. Vérification : A-t-on reçu un ID ?
if (isset($_GET['id'])) {
    
    // 2. Connexion
    $pdo = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8", "dev", "dev");
    $repo = new ProductRepository($pdo);

    // 3. Suppression
    $id = (int)$_GET['id'];
    $repo->delete($id);
}

// 4. Redirection automatique vers la liste (index.php)
// Comme ça, l'utilisateur a l'impression d'être resté sur la même page
header('Location: index.php');
exit;