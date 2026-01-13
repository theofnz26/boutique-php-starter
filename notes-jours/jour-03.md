# 📝 Bilan Jour 03 : Boucles & Tableaux Complexes

Aujourd'hui, j'ai franchi une étape majeure : j'ai arrêté de copier-coller du code HTML répétitif. J'ai appris à rendre mes pages **dynamiques**.

---

## 🧠 Ce que j'ai compris

### 1. Les Tableaux "Intelligents" (Associatifs)
Avant, j'utilisais des numéros (0, 1, 2). Maintenant, je peux donner des **noms** aux cases de mes tableaux.
* C'est comme une fiche d'identité : `['nom' => 'Theo', 'age' => 27]`.
* Pour récupérer l'info, j'utilise la clé : `$user['nom']`.

### 2. Les Tableaux dans des Tableaux (Multidimensionnels)
J'ai compris que je peux stocker des tableaux à l'intérieur d'un tableau principal.
* C'est la base de tout site e-commerce : Une liste `$produits` qui contient plusieurs fiches produits.
* Pour accéder au prix du 1er produit : `$produits[0]['prix']`.

### 3. L'Architecture "Pro"
J'ai appris à ne pas tout mélanger.
* 📁 **Les Données (`app/produits.php`)** : Je range mon stock ici. C'est le "cerveau".
* 💻 **L'Affichage (`public/catalogue.php`)** : Je range mon HTML ici. C'est le "visage".
* J'utilise `require` pour importer les données dans la page d'affichage.

---

## 🔄 Mes 3 Outils de Boucles

J'ai vu trois façons de répéter des actions, chacune a son utilité :

1.  **`foreach` (Pour chaque...)** :
    * **C'est quoi ?** La boucle reine pour les listes.
    * **Quand l'utiliser ?** Dès que j'ai un tableau (`$produits`) et que je veux tout afficher. Je n'ai pas besoin de compter.

2.  **`for` (Pour i allant de...)** :
    * **C'est quoi ?** Une boucle mathématique avec un compteur.
    * **Quand l'utiliser ?** Quand je sais *exactement* combien de tours je veux faire (ex: "Compte de 1 à 10", "Affiche la table de 7").

3.  **`while` (Tant que...)** :
    * **C'est quoi ?** Une boucle basée sur une condition imprévisible.
    * **Quand l'utiliser ?** Quand je ne sais pas quand ça va s'arrêter (ex: "Jette le dé tant que je n'ai pas fait un 6", "Économise tant que je n'ai pas 500€").
    * ⚠️ **Danger :** Il faut toujours que la variable change à l'intérieur, sinon c'est une boucle infinie.

---

## 🛠️ Mon Tableau de Syntaxes (Cheat Sheet)

Voici toutes les commandes que j'ai utilisées aujourd'hui :

| Syntaxe | À quoi ça sert ? | Exemple concret |
| :--- | :--- | :--- |
| **`$tab = ['cle' => 'valeur'];`** | Créer un tableau associatif (clé/valeur). | `$moi = ['prenom' => 'Theo'];` |
| **`echo $tab['cle'];`** | Afficher une valeur précise d'un tableau associatif. | `echo $moi['prenom'];` |
| **`foreach($liste as $item):`** | Démarrer une boucle pour lire un tableau (syntaxe HTML). | `foreach($products as $p):` |
| **`endforeach;`** | Fermer la boucle `foreach` proprement dans du HTML. | `endforeach;` |
| **`for($i=0; $i<10; $i++)`** | Boucle compteur (Départ ; Arrêt ; Pas). | `for($i=0; $i<10; $i++)` |
| **`while($x < 100)`** | Boucle "Tant que la condition est vraie". | `while($cagnotte < 500)` |
| **`$a += $b`** | L'Accumulateur. Ajoute `$b` à ce qu'il y a déjà dans `$a`. | `$cagnotte += $economie;` |
| **`rand(min, max)`** | Génère un nombre aléatoire. | `$de = rand(1, 6);` |
| **`count($tab)`** | Compte combien il y a d'éléments dans un tableau. | `echo count($products);` |
| **`continue`** | "Passe ton tour". Saute l'élément actuel et passe au suivant. | `if($stock==0) continue;` |
| **`break`** | "Arrête tout". Stoppe immédiatement la boucle. | `if($danger) break;` |
| **`require 'fichier.php'`** | Importe le contenu d'un autre fichier PHP. | `require 'data.php';` |
| **`number_format($x, 2)`** | Formate un prix (ex: met 2 chiffres après la virgule). | `number_format($prix, 2)` |

---

## 🚨 Les points de vigilance

1.  **L'ordre du fichier :** Toujours définir les données (`$products`) *avant* de lancer la boucle `foreach`.
2.  **La syntaxe `:`** : Dans le HTML, ne pas oublier les deux points après le `foreach` et le `endforeach;` à la fin.
3.  **Chemins de fichiers :** Attention aux dossiers quand je lance le serveur ou que je fais un `require` (utiliser `__DIR__` aide beaucoup).

## 💻 Mes Exemples de Code

### 1. La boucle `foreach` (La plus utilisée)
C'est celle que j'utiliserai pour mes sites web (afficher des produits, des utilisateurs...).

**Exemple simple :**
```php
$prenoms = ["Alice", "Bob", "Charlie"];

foreach ($prenoms as $p) {
    echo "Je dis bonjour à " . $p . "<br>";
}

Exemple HTML (Syntaxe alternative) :
PHP

<?php foreach ($produits as $p): ?>
    <div class="carte">
        <h3><?= $p['nom'] ?></h3>
    </div>
<?php endforeach; ?>

2. La boucle for (Le compteur mathématique)

Je l'utilise quand je dois compter précisément (ex: pagination, numéroter des pages).

Exemple : Compter jusqu'à 10
PHP

// Départ : 1 ; Arrêt : 10 ; Pas : +1 à chaque tour
for ($i = 1; $i <= 10; $i++) {
    echo "Numéro : " . $i . "<br>";
}

3. La boucle while (L'incertaine)

Je l'utilise quand le nombre de tours dépend du hasard ou d'une action utilisateur.

Exemple : Le lancer de dé
PHP

$de = 0;

// Tant que le dé n'est pas 6... je continue
while ($de != 6) {
    $de = rand(1, 6);
    echo "J'ai fait un " . $de . "<br>";
}

4. Break et Continue (Le videur)

Pour contrôler le flux à l'intérieur d'une boucle.

Exemple :
PHP

foreach ($liste as $item) {
    // Si c'est vide, je passe au suivant (zappe ce tour)
    if ($item == "vide") { 
        continue; 
    }
    
    // Si c'est dangereux, j'arrête tout (sort de la boucle)
    if ($item == "danger") { 
        break; 
    }
    
    echo $item;
}