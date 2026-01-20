# 📝 Jour 10 : Architecture Complète (POO, CRUD & Sécurité)

Aujourd'hui, j'ai transformé mes scripts PHP basiques en une **application professionnelle**. J'ai appris à structurer mon code, à sécuriser mes données et à utiliser la puissance des Objets PHP.

---

## 🏗️ 1. L'Architecture MVC (Les bases)

Au lieu de tout mélanger, j'ai séparé les responsabilités en 3 rôles distincts. C'est ce qu'on appelle la "Séparation des préoccupations".

| Fichier / Rôle | Concept | "En Français" |
| --- | --- | --- |
| **`Product.php`** | **L'Entité** | C'est le **conteneur**. Il ne fait rien d'autre que porter les données (`$name`, `$price`...) de manière structurée. |
| **`ProductRepository.php`** | **Le Service** | C'est le **magasinier**. C'est le seul qui a le droit de parler SQL. Il charge et sauvegarde les Entités. |
| **`index.php` / `edit.php**` | **Le Contrôleur** | C'est le **chef d'orchestre**. Il reçoit la demande du visiteur, appelle le Repository, et affiche le résultat (HTML). |

---

## 💧 2. Le Concept d'Hydratation

C'est le pont entre le monde SQL (tableaux) et le monde PHP (Objets).

* **Problème :** `PDO` me renvoie un tableau bête `['name' => 'Table', 'price' => 50]`. Je ne peux pas garantir que le prix est positif ou que le nom est bien une chaîne.
* **Solution :** Je convertis ce tableau en un Objet `Product` propre.

```php
// Ma méthode hydrate (dans le Repository)
private function hydrate(array $data): Product
{
    // Utilisation des "Named Arguments" de PHP 8 (très lisible !)
    return new Product(
        id: (int)$data['id'],      // Casting (Forçage de type)
        name: $data['name'],
        price: (float)$data['price']
    );
}

```

> **Avantage :** Si je fais une erreur dans mon code HTML (ex: afficher le prix), mon éditeur (VS Code) me proposera `$product->getPrice()` automatiquement. Avec un tableau, je n'aurais aucune aide.

---

## 🛡️ 3. Sécurité & Bonnes Pratiques

J'ai appris que la sécurité n'est pas une option. Voici les 3 boucliers que j'ai mis en place :

### A. Contre les Injections SQL (Le `prepare`)

Je n'écris **JAMAIS** de variables PHP directement dans une chaîne SQL.

* ❌ **Interdit :** `query("SELECT * FROM products WHERE name = '$nom'")` (Un pirate peut tout casser).
* ✅ **Obligatoire :** J'utilise des **marqueurs** (`:name`) et `execute()`.

```php
$stmt = $this->pdo->prepare("INSERT INTO products (name) VALUES (:name)");
$stmt->execute(['name' => $nom]); // PDO nettoie la variable automatiquement.

```

### B. Contre les Failles XSS (`htmlspecialchars`)

Quand j'affiche un texte qui vient de la base de données (et donc qu'un utilisateur a pu écrire), je dois le nettoyer pour empêcher l'exécution de JavaScript malveillant.

* ✅ **Code :** `<?= htmlspecialchars($product->getName()) ?>`

### C. Le Casting (Forçage de type)

Pour éviter les bugs, je force les types quand je reçois des données.

* `(int)$_POST['stock']` : Je suis sûr que c'est un nombre entier, même si le formulaire envoie une chaîne "10".
* `(float)$_POST['price']` : Je suis sûr d'avoir un nombre à virgule.

---

## ⚡ 4. Syntaxe Moderne (PHP 8+)

J'ai utilisé des fonctionnalités récentes de PHP qui rendent le code plus court et plus robuste.

### A. Constructor Promotion (Dans `Product.php`)

Au lieu d'écrire 3 fois la même chose (propriété, paramètre, assignation), je fais tout dans le constructeur.

```php
// AVANT (Vieux PHP)
class Product {
    private $name;
    public function __construct($name) { $this->name = $name; }
}

// MAINTENANT (PHP 8)
class Product {
    public function __construct(
        private string $name // Déclare + Assigne en même temps !
    ) {}
}

```

### B. Nullable Types (`?`)

Parfois, une donnée peut ne pas exister (ex: l'ID avant la sauvegarde, ou la description vide). J'utilise le `?` devant le type.

* `private ?int $id = null` : L'ID est un entier OU null.

### C. L'Opérateur de Coalescence Nulle (`??`)

C'est une super astuce pour dire "Si ça n'existe pas, mets une valeur par défaut".

* `$data['description'] ?? null` : Si la colonne description n'existe pas dans le tableau, mets `null` (évite les erreurs).

---

## 🧠 5. Logique Algorithmique

### A. Le Routing (Dans `index.php`)

J'ai créé une page intelligente qui change son contenu selon l'URL (les paramètres `$_GET`).

```php
if (!empty($_GET['search'])) {
    // Mode Recherche
} elseif (!empty($_GET['cat_id'])) {
    // Mode Filtre Catégorie
} else {
    // Mode Défaut (Tout afficher)
}

```

### B. Le "Post-Redirect-Get" (PRG)

Après avoir soumis un formulaire (Create, Update, Delete), je ne reste pas sur la page de traitement. Je redirige l'utilisateur.

* **Pourquoi ?** Pour éviter que le formulaire soit renvoyé si l'utilisateur actualise la page (F5).
* **Code :** `header('Location: index.php'); exit;`

### C. Array Map

Pour transformer une liste de 100 lignes SQL en 100 Objets, j'ai utilisé une fonction puissante plutôt qu'une boucle `foreach` manuelle.

* `array_map([$this, 'hydrate'], $data)` : "Applique la méthode hydrate sur chaque ligne du tableau $data".

---

## 📚 Dictionnaire des Commandes

| Commande PHP | Traduction / Utilité |
| --- | --- |
| `require_once 'Fichier.php'` | "Copie-colle le contenu de ce fichier ici (si pas déjà fait)." Indispensable pour charger mes classes. |
| `PDO::FETCH_ASSOC` | "Quand tu lis la BDD, donne-moi un tableau propre avec le nom des colonnes" (ex: `['nom' => 'X']`). |
| `lastInsertId()` | "Quel est l'ID du dernier truc que tu viens d'ajouter ?" (Utile après un INSERT). |
| `public` vs `private` | **Encapsulation**. `private` = "Touche pas à mes données directement, passe par mes méthodes (Getters/Setters)". |
| `$_SERVER['REQUEST_METHOD'] === 'POST'` | "Est-ce qu'on a cliqué sur le bouton Envoyer ?" |
| `return void` | "Cette fonction fait un travail mais ne renvoie aucun résultat (pas de return)." |

---

## 🎯 Conclusion Personnelle

J'ai compris que **coder proprement prend plus de temps au début** (créer les fichiers, les classes...), mais **fait gagner énormément de temps ensuite**.

* Ajouter une colonne ? Je modifie juste l'Entité.
* Changer la BDD ? Je modifie juste le Repository.
* Le reste de mon site ne bouge pas. C'est ça, la robustesse.