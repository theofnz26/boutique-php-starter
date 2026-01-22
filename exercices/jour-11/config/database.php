<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=boutique;charset=utf8', 'dev', 'dev');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
