Jour 7 : Base de Données (PDO) & Sessions

Aujourd'hui, j'ai franchi une étape majeure : mes données ne sont plus volatiles. J'ai appris à connecter PHP à une base de données MySQL pour sauvegarder des informations (produits, utilisateurs) et à utiliser les Sessions pour garder une mémoire temporaire (panier, connexion) pendant la navigation.
1. Les Sessions (Mémoire temporaire)

Les sessions servent à stocker des informations sur l'utilisateur tant qu'il navigue sur le site (ex: est-il connecté ? que contient son panier ?).

    Stockage : Côté serveur (sécurisé).

    Durée : Jusqu'à la fermeture du navigateur (ou déconnexion).

    Règle d'or : Toujours écrire session_start(); tout en haut du fichier, avant le moindre HTML.

2. La Connexion PDO (Le pont vers MySQL)

Pour que PHP parle à MySQL, on utilise l'extension PDO (PHP Data Objects). C'est un "adaptateur universel".
Le bloc Try / Catch

Se connecter est risqué (serveur éteint, mauvais mot de passe). Si ça plante, je dois attraper l'erreur pour ne pas afficher mes mots de passe aux visiteurs.
PHP

try {
    // Tentative de connexion
    $pdo = new PDO(...);
} catch (PDOException $e) {
    // Si échec, on gère l'erreur proprement
    die("Erreur : " . $e->getMessage());
}

3. Récupérer des données (SELECT)

J'ai deux façons d'envoyer des ordres SQL :

    query() : Pour les requêtes fixes (sans variables).

        Exemple : "Donne-moi tous les produits".

    prepare() : Pour les requêtes dynamiques (avec des variables utilisateur).

        Exemple : "Donne-moi le produit dont l'ID est X".

        ⚠️ Obligatoire pour la sécurité (voir point 4).

Fetch vs FetchAll

Une fois la requête envoyée, il faut récupérer les colis (les données).

    fetch() : Récupère une seule ligne (la suivante). Utile pour un profil ou un détail produit.

    fetchAll() : Récupère toutes les lignes restantes dans un grand tableau. Utile pour les listes.

    PDO::FETCH_ASSOC : Option cruciale pour avoir un tableau propre avec les noms des colonnes ($p['name']) au lieu de numéros ($p[0]).

4. Sécurité : Les Requêtes Préparées

Si je mets directement une variable utilisateur dans du SQL (WHERE nom = '$nom'), je crée une faille Injection SQL. Un pirate peut détruire ma base.

La solution : Je sépare le code SQL de la donnée.

    Préparer (prepare) : J'envoie le moule avec un trou (?).

    Exécuter (execute) : J'envoie la valeur qui va combler le trou.

5. Tableau des nouvelles fonctions
Fonction / Syntaxe	À quoi ça sert ?	Exemple
session_start()	Démarre ou reprend une session. Obligatoire au début du fichier.	session_start();
$_SESSION['cle']	Variable superglobale pour stocker/lire des infos de session.	$_SESSION['user'] = 'Alex';
new PDO(...)	Crée la connexion à la base de données.	$pdo = new PDO("mysql:host=...", "user", "pass");
$pdo->query("SQL")	Exécute une requête SQL simple (sans paramètres externes).	$stmt = $pdo->query("SELECT * FROM produits");
$pdo->prepare("SQL")	Prépare une requête sécurisée avec des placeholders (?).	$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([...])	Exécute la requête préparée en injectant les vraies valeurs.	$stmt->execute([$id]);
$stmt->fetch()	Récupère la ligne suivante du résultat.	$user = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->fetchAll()	Récupère TOUS les résultats dans un tableau multidimensionnel.	$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
htmlspecialchars($var)	Convertit les caractères spéciaux en HTML. Protège contre les failles XSS à l'affichage.	echo htmlspecialchars($produit['nom']);
header("Location: ...")	Redirige l'utilisateur vers une autre page.	header("Location: index.php"); exit;
6. Analyse des codes clés du jour
A. La connexion (Le Socle)
PHP

$pdo = new PDO(
    "mysql:host=localhost;dbname=boutique;charset=utf8mb4", // Où ? (DSN)
    "dev", // Qui ? (User)
    "dev", // Mot de passe ?
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // Options : Active les erreurs visibles
);

    Utilité : Ouvre la ligne téléphonique avec MySQL.

    Détail : utf8mb4 est important pour gérer les accents et émojis. L'option ERRMODE_EXCEPTION permet de voir les erreurs SQL s'afficher (sinon c'est page blanche en cas de bug).

B. Affichage d'une liste (Le READ)
PHP

$stmt = $pdo->query("SELECT * FROM products"); // 1. On envoie l'ordre
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC); // 2. On récupère tout sous forme de tableau associatif

foreach ($produits as $p) { // 3. On boucle pour afficher
    echo htmlspecialchars($p['name']); // Sécurité XSS à l'affichage
}

    Utilité : Afficher un catalogue.

    Détail : On utilise query car il n'y a pas de filtre utilisateur. fetchAll nous donne un tableau qu'on peut parcourir avec foreach.

C. Recherche sécurisée (Le WHERE avec paramètre)
PHP

$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ?"); // 1. Le '?' attend une valeur
$stmt->execute(['%' . $_GET['search'] . '%']); // 2. On envoie la valeur (avec les jokers %)
$resultats = $stmt->fetchAll();

    Utilité : Chercher un produit sans risquer de se faire pirater.

    Détail : Le ? remplace la variable. MySQL traite le contenu de execute comme du pur texte. Impossible d'injecter du code malveillant.

D. Suppression et Redirection (Le DELETE)
PHP

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    
    header("Location: admin.php"); // Hop, on recharge la page propre
    exit; // On arrête tout le script immédiatement après
}

    Utilité : Supprimer un élément quand on clique sur un lien (ex: admin.php?delete=12).

    Détail : La redirection est essentielle pour "nettoyer" l'URL. Sinon, si l'utilisateur rafraîchit la page, le script essaie de resupprimer le produit qui n'existe plus.