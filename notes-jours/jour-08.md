

# 📝 Jour 08 : Introduction à la Programmation Orientée Objet (POO)

## 1. Concepts Fondamentaux

### Classe vs Objet

C'est la base de la POO. On passe d'un code "procédural" (fonctions et variables séparées) à un code organisé.

* **Classe (`class`) :** C'est le **moule**, le plan de construction. Elle définit la structure (propriétés) et les comportements (méthodes). Elle n'existe pas en tant que donnée, c'est une définition.
* **Objet (Instance) :** C'est la **chose réelle** créée à partir du moule. On peut créer une infinité d'objets à partir d'une seule classe.

### Propriétés et Méthodes

* **Propriétés :** Ce sont les variables à l'intérieur d'une classe. Elles définissent l'état de l'objet (ex: couleur, prix, nom).
* **Méthodes :** Ce sont les fonctions à l'intérieur d'une classe. Elles définissent ce que l'objet sait faire (ex: calculer, afficher, modifier).

### La variable `$this`

C'est une pseudo-variable qui signifie **"Moi-même"**.
À l'intérieur d'une classe, pour accéder à ses propres propriétés ou méthodes, on ne peut pas utiliser le nom de la variable. On doit utiliser `$this->propriété`.

```php
class Car {
    public string $brand; // Propriété

    public function display() { // Méthode
        // $this->brand = La marque de CETTE voiture précise
        return "Je suis une " . $this->brand;
    }
}

```

---

## 2. Le Constructeur & Instanciation

### Le mot-clé `new`

Sert à créer un objet (une instance) à partir d'une classe.

```php
$maVoiture = new Car(); // Instanciation

```

### La méthode magique `__construct()`

C'est une méthode spéciale qui s'exécute **automatiquement** et immédiatement lors de la création de l'objet (`new`).
Elle sert à initialiser l'objet (lui donner ses valeurs de départ).

**Syntaxe moderne (PHP 8 - Constructor Promotion) :**
On peut déclarer et assigner les propriétés directement dans les parenthèses du constructeur. C'est plus rapide.

```php
class User {
    // PHP crée automatiquement les propriétés $name et $email
    public function __construct(
        public string $name,
        public string $email
    ) {}
}

// Utilisation
$user = new User("Alice", "alice@gmail.com");

```

---

## 3. Encapsulation (Visibilité)

C'est la protection des données. On empêche le code extérieur de modifier n'importe comment les données de l'objet.

* **`public` :** Accessible partout (depuis l'intérieur et l'extérieur de la classe).
* **`private` :** Accessible **uniquement** depuis l'intérieur de la classe (`$this`).

Pour interagir avec une propriété `private`, on crée des méthodes publiques (Getters/Setters) qui contiennent de la logique de vérification.

```php
class BankAccount {
    private float $balance; // Protégé

    public function deposit(float $amount): void {
        if ($amount > 0) { // Sécurité
            $this->balance += $amount;
        }
    }
}

```

---

## 4. Types de retour et `: void`

Il est important de préciser ce qu'une fonction renvoie pour éviter les bugs.

* **`: string`, `: int`, `: bool**` : La fonction renvoie une valeur que l'on peut stocker dans une variable.
* **`: void`** (Vide/Néant) : La fonction effectue une action (ex: modifier une propriété, afficher un texte) mais ne renvoie **rien**.

```php
// Renvoie un calcul (Question)
public function getPrice(): float {
    return $this->price * 1.2;
}

// Fait une action (Ordre)
public function setPrice(float $newPrice): void {
    $this->price = $newPrice;
    // Pas de return
}

```

---

## 5. L'Hydratation

C'est le processus de transformation d'un tableau de données brutes (Array) en Objets intelligents.
On utilise souvent une boucle `foreach` pour parcourir les données et créer des objets à la volée.

```php
$data = [
    ['nom' => 'Télé', 'prix' => 500],
    ['nom' => 'Radio', 'prix' => 50]
];

foreach ($data as $row) {
    // Transformation Array -> Object
    $produit = new Product($row['nom'], $row['prix']);
    echo $produit->calculerTVA();
}

```

---

## 6. Fonctions Natives et Classes découvertes

### Classe `DateTime`

L'objet natif de PHP pour gérer le temps. Bien plus puissant que de simples chaînes de caractères.

* `new DateTime()` : Date et heure de l'instant présent.
* `new DateTime("2024-01-01")` : Date spécifique.
* `$date->diff($autreDate)` : Renvoie un intervalle (différence) entre deux dates.
* `$date->format('d/m/Y')` : Affiche la date joliment.

### Manipulation de Strings (Exo 6)

* `strtolower($string)` : Met tout le texte en minuscules.
* `str_replace('cherche', 'remplace', $sujet)` : Remplace des morceaux de texte.

---

## 7. Tableau des nouvelles syntaxes 💡

| Syntaxe | Nom | Utilité | Exemple |
| --- | --- | --- | --- |
| **`class Name {}`** | Définition de Classe | Créer le moule (le plan). | `class User { ... }` |
| **`new Name()`** | Instanciation | Créer un objet réel à partir de la classe. | `$u = new User();` |
| **`$this`** | Pseudo-variable | Désigne l'objet courant (Moi-même) à l'intérieur de la classe. | `$this->name` |
| **`->`** | Opérateur Objet | Accéder à une propriété ou méthode d'un objet. | `$user->getName()` |
| **`__construct()`** | Constructeur | Méthode magique appelée automatiquement au `new`. | `public function __construct(...)` |
| **`private`** | Visibilité Privée | Interdit l'accès depuis l'extérieur (coffre-fort). | `private $password;` |
| **`public`** | Visibilité Publique | Autorise l'accès à tout le monde. | `public $name;` |
| **`: void`** | Type de retour | Indique qu'une méthode ne retourne rien (action pure). | `public function run(): void` |
| **`?string`** | Type Nullable | Accepte soit une String, soit `null`. | `public function set(?string $date)` |
| **`require_once`** | Importation | Charge le fichier contenant la définition de la classe. | `require_once 'User.php';` |