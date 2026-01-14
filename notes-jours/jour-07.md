

**Pour que l'affichage soit parfait sur GitHub**, tu dois copier **le contenu du bloc ci-dessous** (le code brut) et le coller dans ton fichier `jour-07.md`.

J'ai corrigé la syntaxe des tableaux et des blocs de code pour que GitHub les interprète correctement.

```markdown
# Jour 7 : Base de Données (PDO) & Sessions

Aujourd'hui, j'ai franchi une étape majeure : mes données ne sont plus volatiles. J'ai appris à connecter PHP à une base de données MySQL pour sauvegarder des informations (produits, utilisateurs) et à utiliser les Sessions pour garder une mémoire temporaire (panier, connexion) pendant la navigation.

---

## 1. Les Sessions (Mémoire temporaire)

Les sessions permettent de stocker des informations sur l'utilisateur tant qu'il navigue sur le site (ex: est-il connecté ? que contient son panier ?).

* **Stockage :** Côté serveur (sécurisé).
* **Durée :** Jusqu'à la fermeture du navigateur (ou déconnexion).
* **Règle d'or :** Toujours écrire `session_start();` tout en haut du fichier, avant le moindre code HTML.

```php
session_start();
$_SESSION['user'] = "Alex"; // Stockage
echo $_SESSION['user'];     // Lecture

```

---

## 2. La Connexion PDO (Le pont vers MySQL)

Pour que PHP parle à MySQL, on utilise l'extension **PDO** (PHP Data Objects). C'est un "adaptateur universel".

### Le bloc Try / Catch

Se connecter est une opération risquée (serveur éteint, mauvais mot de passe). Si ça plante, je dois "attraper" l'erreur pour ne pas afficher mes identifiants aux visiteurs.

```php
try {
    // Tentative de connexion
    $pdo = new PDO(
        "mysql:host=localhost;dbname=boutique;charset=utf8mb4",
        "dev",
        "dev",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // Si échec, on gère l'erreur proprement
    die("Erreur : " . $e->getMessage());
}

```

---

## 3. Récupérer des données (SELECT)

J'ai deux façons d'envoyer des ordres SQL :

1. **`query()`** : Pour les requêtes **fixes** (sans variables externes).
* *Exemple :* "Donne-moi tous les produits".


2. **`prepare()`** : Pour les requêtes **dynamiques** (avec des variables utilisateur).
* *Exemple :* "Donne-moi le produit dont l'ID est X".
* ⚠️ **Obligatoire pour la sécurité** (voir point 4).



### Fetch vs FetchAll

Une fois la requête envoyée, il faut récupérer les "colis" (les données).

* **`fetch()`** : Récupère **une seule ligne** (la suivante). Utile pour un profil utilisateur ou un détail produit.
* **`fetchAll()`** : Récupère **toutes les lignes** restantes dans un grand tableau. Utile pour les listes de produits.
* **`PDO::FETCH_ASSOC`** : Option cruciale pour avoir un tableau propre avec les noms des colonnes (ex: `$p['name']`) au lieu de numéros illisibles (ex: `$p[0]`).

---

## 4. Sécurité : Les Requêtes Préparées

Si je mets directement une variable utilisateur dans du SQL (ex: `WHERE nom = '$nom'`), je crée une faille **Injection SQL**. Un pirate peut détruire ma base de données.

**La solution :** Je sépare le code SQL de la donnée.

1. **Préparer (`prepare`)** : J'envoie le modèle de requête avec un trou (`?`).
2. **Exécuter (`execute`)** : J'envoie la valeur séparément pour combler le trou.

---

## 5. Tableau des nouvelles fonctions

| Fonction / Syntaxe | À quoi ça sert ? | Exemple |
| --- | --- | --- |
| `session_start()` | Démarre ou reprend une session. **Obligatoire** en ligne 1. | `session_start();` |
| `$_SESSION['cle']` | Tableau superglobal pour stocker/lire des infos de session. | `$_SESSION['role'] = 'admin';` |
| `new PDO(...)` | Crée la connexion à la base de données. | `$pdo = new PDO(...);` |
| `$pdo->query("SQL")` | Exécute une requête SQL simple (sans paramètres). | `$stmt = $pdo->query("SELECT * ...");` |
| `$pdo->prepare("SQL")` | Prépare une requête sécurisée avec des placeholders (`?`). | `$stmt = $pdo->prepare("... ID = ?");` |
| `$stmt->execute([...])` | Exécute la requête préparée en injectant les vraies valeurs. | `$stmt->execute([$id]);` |
| `$stmt->fetch()` | Récupère la ligne suivante du résultat. | `$user = $stmt->fetch();` |
| `$stmt->fetchAll()` | Récupère TOUS les résultats dans un tableau. | `$liste = $stmt->fetchAll();` |
| `htmlspecialchars($var)` | Convertit les caractères spéciaux en HTML (Sécurité XSS). | `echo htmlspecialchars($nom);` |
| `header("Location: ...")` | Redirige l'utilisateur vers une autre page. | `header("Location: index.php"); exit;` |

---

## 6. Analyse des codes clés du jour

### A. La connexion (Le Socle)

```php
$pdo = new PDO(
    "mysql:host=localhost;dbname=boutique;charset=utf8mb4", // Où ? (DSN)
    "dev", // Qui ? (User)
    "dev", // Mot de passe ?
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // Options : Active les erreurs visibles
);

```

* **Utilité :** Ouvre la ligne téléphonique avec MySQL.
* **Détail :** `utf8mb4` est important pour gérer les accents et émojis. L'option `ERRMODE_EXCEPTION` permet de voir les erreurs SQL s'afficher (sinon c'est page blanche en cas de bug).

### B. Affichage d'une liste (Le READ)

```php
// 1. On envoie l'ordre
$stmt = $pdo->query("SELECT * FROM products"); 
// 2. On récupère tout sous forme de tableau associatif
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC); 

// 3. On boucle pour afficher
foreach ($produits as $p) { 
    echo htmlspecialchars($p['name']); // Sécurité XSS à l'affichage
}

```

* **Utilité :** Afficher un catalogue complet.
* **Détail :** On utilise `query` car il n'y a pas de filtre utilisateur. `fetchAll` nous donne un tableau qu'on peut parcourir avec `foreach`.

### C. Recherche sécurisée (Le WHERE avec paramètre)

```php
// 1. Le '?' attend une valeur (Sécurité)
$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ?"); 
// 2. On envoie la valeur (avec les jokers %)
$stmt->execute(['%' . $_GET['search'] . '%']); 
$resultats = $stmt->fetchAll();

```

* **Utilité :** Chercher un produit sans risquer de se faire pirater (Injection SQL).
* **Détail :** Le `?` remplace la variable. MySQL traite le contenu de `execute` comme du pur texte, jamais comme du code.

### D. Suppression et Redirection (Le DELETE)

```php
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    
    header("Location: admin.php"); // Hop, on recharge la page proprement
    exit; // On arrête tout le script immédiatement après
}

```

* **Utilité :** Supprimer un élément quand on clique sur un lien (ex: `admin.php?delete=12`).
* **Détail :** La redirection est essentielle pour "nettoyer" l'URL. Sinon, si l'utilisateur rafraîchit la page, le script essaierait de supprimer à nouveau un produit qui n'existe plus.

```

```