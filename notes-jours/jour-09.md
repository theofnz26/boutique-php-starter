# 📝 Jour 09 : Les Relations entre Objets (Le Puzzle)

Aujourd'hui, nous avons franchi une étape majeure. Nous avons arrêté de créer des objets isolés pour créer un **système**. Nous avons appris à faire discuter les objets entre eux.

---

## 1. Le Typage Objet (La Sécurité) 🛡️
*Vu dans l'Exercice 1 (Product & Category)*

**Le Concept :**
Au lieu de dire qu'une propriété est du texte (`string`) ou un nombre (`int`), on dit qu'elle est **une instance d'une autre classe**. C'est une sécurité absolue.

**La Métaphore : Le Vigile à l'entrée**
Imagine un jeu de formes pour enfants.
* **Avant :** On pouvait forcer un rond dans un carré (mettre du texte n'importe où).
* **Maintenant :** Le code agit comme un vigile. Si tu veux créer un Produit, tu **DOIS** fournir une étiquette certifiée "Category". Sinon, ça ne rentre pas.

**Le Code :**
```php
class Product {
    // On exige un OBJET Category, pas juste du texte.
    public function __construct(
        public string $name,
        public Category $category 
    ) {}
}

2. La Classe Intermédiaire (Le Wrapper) 📦

Vu dans l'Exercice 2 (CartItem)

Le Concept : Parfois, on ne peut pas relier deux objets directement. On ne met pas un Product directement dans le Panier, car le produit ne sait pas "combien" il y en a.

La Métaphore : L'étiquette de prix Une pomme au supermarché sait qu'elle coûte 1€. Mais elle ne sait pas que tu en as pris 5. On crée donc une boite spéciale (CartItem) qui contient :

    La Pomme (L'objet Product).

    La Quantité (Le nombre).

Le Code :
PHP

class CartItem {
    public function __construct(
        public Product $product,
        public int $quantity
    ) {}
    
    // C'est lui qui calcule le prix total de la ligne
    public function getTotal() {
        return $this->product->price * $this->quantity;
    }
}

3. La Gestion de Collection (Le Chef d'équipe) 🛒

Vu dans l'Exercice 3 (Cart)

Le Concept : Le Panier est un objet qui contient une liste (un tableau) d'autres objets. Son travail n'est pas de faire les calculs lui-même, mais de déléguer le travail à ses éléments.

La Métaphore : Le Chef de Chantier Le chef (Panier) ne pose pas les briques.

    Il demande à l'ouvrier 1 (CartItem) : "Combien tu as fait ?"

    Il demande à l'ouvrier 2 (CartItem) : "Combien tu as fait ?"

    À la fin, il fait juste l'addition.

Le Code :
PHP

class Cart {
    private array $items = []; // La liste des ouvriers

    public function getTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal(); // Il demande à chaque item
        }
        return $total;
    }
}

4. Relation "Un-vers-Plusieurs" (1...N) 🏠

Vu dans l'Exercice 4 (User & Address)

Le Concept : Un objet peut en posséder plusieurs autres. Ici, 1 Utilisateur possède Plusieurs Adresses. Dans le code, l'Utilisateur a une "poche" (un tableau $addresses) pour ranger ses clés (les objets Address).

Le Code :
PHP

class User {
    private array $addresses = []; 

    public function addAddress(Address $address) {
        $this->addresses[] = $address; // Hop, dans la poche !
    }
}

5. La Photo Instantanée (Snapshot) 📸

Vu dans l'Exercice 5 (Order)

Le Concept : Une commande est un moment figé dans le temps. Quand on transforme un Panier en Commande, on copie les données.

La Métaphore : La Photo Souvenir Le Panier, c'est comme une vidéo en direct : ça bouge, on ajoute, on enlève. La Commande, c'est une photo prise au moment du paiement. Même si la vidéo change après, la photo, elle, ne bougera plus jamais.

Le Code :
PHP

class Order {
    public function __construct(Cart $cart) {
        // On copie les items pour figer le contenu
        $this->items = $cart->getItems(); 
        $this->date = new DateTime(); // On note l'heure exacte
    }
}

6. L'Interface Fluide (La Phrase Magique) 🌊

Vu dans l'Exercice 6 (Fluent Interface)

Le Concept : C'est une technique pour enchaîner les méthodes les unes après les autres sans répéter le nom de la variable.

La Métaphore : La Télécommande Au lieu de dire : "Prends la télécommande. Allume. Pose la télécommande." "Prends la télécommande. Monte le son. Pose la télécommande."

La méthode te rend la télécommande à la fin de chaque action (return $this), donc tu peux dire : "Allume, PUIS monte le son, PUIS change de chaîne."

Le Code :
PHP

// Dans la classe
public function add(): self {
    // ... action ...
    return $this; // 👈 Je me rends moi-même
}

// Utilisation
$cart->add($pomme)->add($poire)->remove($banane);

💡 Vocabulaire à retenir
Mot du jour	Définition simple
Typage Objet	Forcer une variable à être une instance précise d'une classe (ex: public Category $cat).
Composition	Quand un objet est composé d'autres objets (ex: Le Panier est composé d'Items).
Délégation	Quand un objet demande à un autre de faire le calcul à sa place.
DateTime	La classe super-intelligente de PHP pour gérer les dates et heures.
Hydratation	L'action de donner des valeurs à un objet vide.
Fluent Interface	Le style d'écriture en chaîne (->a()->b()->c()).



| Fonction / Méthode | Type | À quoi ça sert ? (Utilité) | Exemple tiré de notre code |
| :--- | :--- | :--- | :--- |
| **`__construct()`** | Magique | **La Naissance.** S'exécute automatiquement au moment du `new`. Sert à initialiser les propriétés de l'objet. | `public function __construct(public int $id, ...)` |
| **`require_once`** | Native | **L'Import.** Charge un fichier externe (une classe) pour qu'on puisse l'utiliser dans le fichier actuel. | `require_once 'Product.php';` |
| **`count()`** | Native | **Le Compteur.** Compte combien il y a d'éléments dans un tableau. | `return count($this->items);` |
| **`unset()`** | Native | **La Gomme.** Supprime une variable ou une case précise d'un tableau. Utilisé pour retirer un article du panier. | `unset($this->items[$key]);` |
| **`array_values()`** | Native | **Le Rangement.** Réorganise les index d'un tableau (0, 1, 2...) après avoir supprimé un élément au milieu. | `$this->items = array_values($this->items);` |
| **`format()`** | DateTime | **L'Affichage Date.** Transforme un objet `DateTime` complexe en un texte lisible (Jour/Mois/Année). | `$date->format('d/m/Y H:i');` |
| **`add()`** | Perso | **L'Ajout.** Méthode que nous avons créée pour ajouter un objet dans une liste (tableau). | `$this->items[] = $newItem;` |
| **`getTotal()`** | Perso | **La Délégation.** Calcule un total en demandant à chaque sous-objet son propre prix. | `$total += $item->getTotal();` |
| **`return $this;`** | Syntaxe | **Le Chaînage.** Renvoie l'objet lui-même à la fin d'une méthode pour pouvoir enchaîner les flèches `->`. | `return $this;` |