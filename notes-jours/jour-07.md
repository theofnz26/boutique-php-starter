# 📝 Journal de Bord : Jour 7 — Base de Données (PDO) & Sessions

**Date :** 14 Janvier 2026
**Sujet :** Persistance des données, MySQL, Sécurité et Panier.

---

## 🚀 Résumé de la journée
Aujourd'hui, mes données sont devenues immortelles (ou presque). J'ai arrêté de perdre tout mon travail à chaque actualisation de page.
J'ai connecté PHP à une vraie base de données (**MySQL**) pour stocker les infos durablement, et j'ai utilisé les **Sessions** pour garder une mémoire temporaire (comme le panier) pendant la navigation.

---

## 1. Les Sessions : La mémoire courte
J'ai appris que le protocole HTTP est "sans mémoire". Pour se souvenir de l'utilisateur d'une page à l'autre, j'utilise les Sessions.
* **Le principe :** Stocker des infos côté serveur tant que le navigateur est ouvert.
* **La Règle d'Or :** `session_start()` doit être la **toute première ligne** du fichier.

```php
<?php
session_start(); // Toujours ligne 1 !

// Stocker une info
$_SESSION['user'] = "Alex";
$_SESSION['panier'] = [12, 4, 8]; // Je peux stocker des tableaux

// Lire une info
echo "Bonjour " . $_SESSION['user'];

2. PDO : Le pont vers la Base de Données

Pour que PHP parle à MySQL, j'utilise l'extension PDO. C'est un adaptateur universel et sécurisé.
Le Filet de Sécurité (Try / Catch)

Se connecter est risqué. J'enveloppe ma connexion pour attraper les erreurs (catch) et éviter d'afficher mes mots de passe sur une page d'erreur publique.
PHP

try {
    // DSN : Où est la base ? (Host, Nom, Encodage)
    $dsn = "mysql:host=localhost;dbname=boutique;charset=utf8mb4";
    
    // Création de la ligne téléphonique
    $pdo = new PDO($dsn, "dev", "dev", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Active les erreurs visibles
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

3. Lire les données (SELECT)

J'ai deux méthodes pour récupérer mes produits :

    query() : Pour les requêtes simples (sans variables).

    fetchAll() : Pour tout récupérer d'un coup.

PHP

// 1. J'envoie l'ordre
$stmt = $pdo->query("SELECT * FROM products");

// 2. Je récupère TOUT dans un tableau associatif
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. J'affiche
foreach ($produits as $p) {
    echo $p['name'] . " - " . $p['price'] . "€<br>";
}

4. La Sécurité : Requêtes Préparées

C'est le point crucial. Je ne dois JAMAIS concaténer une variable utilisateur directement dans le SQL (Risque d'Injection SQL).

    Mauvais : query("SELECT * FROM users WHERE id = $id") ❌

    Bon : Utiliser prepare et execute ✅

PHP

$id = $_GET['id'];

// 1. Préparer : Je mets un '?' à la place de la donnée
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");

// 2. Exécuter : J'envoie la vraie donnée séparément
$stmt->execute([$id]);

// 3. Récupérer le résultat unique
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

⚡ Aide-Mémoire Syntaxique
Syntaxe	Exemple	À quoi ça sert ?
Session Start	session_start();	Démarre la mémoire. Ligne 1 obligatoire.
Variable Session	$_SESSION['role'] = 'admin';	Stocke une info accessible sur toutes les pages.
Connexion PDO	$pdo = new PDO(...);	Crée l'objet qui permet de parler à MySQL.
Query	$pdo->query("SELECT...");	Envoie une requête SQL fixe (sans variables).
Prepare	$pdo->prepare("... id = ?");	Prépare une requête sécurisée avec un "trou" (?).
Execute	$stmt->execute([$id]);	Envoie la donnée pour boucher le "trou".
FetchAll	$tab = $stmt->fetchAll();	Récupère tous les résultats dans un tableau PHP.
Redirection	header("Location: index.php");	Renvoie l'utilisateur vers une autre page.
1. Le Concept du CRUD (Admin)

Pour mon interface d'administration, j'ai tout regroupé. Voici comment j'ai géré l'ajout (Create) et la suppression (Delete).

Pour supprimer (GET) :
PHP

if (isset($_GET['delete'])) {
    // Toujours préparé car l'ID vient de l'URL !
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    
    // Redirection pour nettoyer l'URL
    header("Location: admin.php");
    exit;
}

Pour ajouter (POST) :
PHP

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
    $stmt->execute([ $_POST['name'], $_POST['price'] ]);
}

2. La Logique du Panier (Hybride)

J'ai compris que le panier est un mélange de deux cerveaux :

    La Session : Elle ne retient que l'ID et la quantité.
    PHP

    $_SESSION['cart'] = [
        12 => 2, // ID 12, Qté 2
        4  => 1  // ID 4, Qté 1
    ];

    La BDD : Au moment d'afficher, je demande les détails (prix, nom) de ces IDs là via une requête WHERE id IN (...).

3. La Redirection "Nettoyage"

Après avoir soumis un formulaire ou cliqué sur un lien de suppression, j'utilise :
PHP

header("Location: ma-page.php");
exit;

    Pourquoi ? Si je ne le fais pas et que l'utilisateur fait "F5" (Actualiser), le navigateur va renvoyer le formulaire ou tenter de supprimer à nouveau le produit.

    Le exit : Indispensable pour que le script s'arrête net et ne charge pas le reste de la page pour rien.

🧠 Bilan Personnel

    Difficulté : Les erreurs SQL (Access denied) et comprendre la différence entre query (fixe) et prepare (variable).

    Victoire : Avoir créé un moteur de recherche qui ne plante pas si je mets des guillemets, et voir mon panier "survivre" quand je change de page.