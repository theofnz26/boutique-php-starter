# Bilan Jour 02 : Tableaux, Boucles et Structure

Aujourd'hui, nous sommes passés de variables simples à des structures de données complexes. Nous avons appris à stocker beaucoup d'informations et à les afficher automatiquement.

---

## 1. Les Tableaux (Arrays)

Pour stocker plusieurs valeurs dans une seule variable.

### A. Tableau Indexé (Liste simple)
Les clés sont des numéros automatiques (0, 1, 2...).
```php
$notes = [12, 18, 9];
echo $notes[0]; // Affiche 12

```

### B. Tableau Associatif (Clé => Valeur)

On choisit nous-mêmes les noms des clés. Idéal pour décrire un objet précis.

```php
$produit = [
    "nom" => "Pull",
    "prix" => 20
];
echo $produit["nom"]; // Affiche "Pull"

```

### C. Tableau Multidimensionnel

Un tableau qui contient d'autres tableaux. C'est la structure de base d'un catalogue ou d'une base de données.

```php
$catalogue = [
    ["nom" => "Pull", "prix" => 20],
    ["nom" => "Mug", "prix" => 10]
];
echo $catalogue[0]["nom"]; // Accède au 1er produit, puis à son nom.

```

---

## 2. Les Fonctions Utiles du Jour

Des outils intégrés à PHP pour manipuler les données.

| Fonction | Utilité | Exemple |
| --- | --- | --- |
| `count($tab)` | Compte le nombre d'éléments dans un tableau. | `count($notes)` |
| `print_r($tab)` | Affiche le contenu brut d'un tableau (pour le débug). Souvent utilisé avec `<pre>`. | `print_r($catalogue)` |
| `number_format()` | Formate un nombre (décimales, virgule, séparateur de milliers). | `number_format($prix, 2, ',', ' ')` |
| `array_filter()` | Filtre un tableau selon une règle (fonction anonyme) pour ne garder que certains éléments. | *Exo 5 (Petit budget)* |

---

## 3. L'Automatisation : La Boucle `foreach`

C'est l'outil magique pour **ne plus se répéter**. Elle parcourt un tableau élément par élément.

**Syntaxe :**

```php
// Pour chaque produit du catalogue, on le met temporairement dans $item
foreach ($catalogue as $item) {
    echo $item["nom"]; // Affiche le nom du produit en cours
}

```

*Note : On utilise la syntaxe alternative `foreach(...): ... endforeach;` quand on mélange PHP et HTML pour plus de lisibilité.*

---

## 4. Architecture et Structure de Fichiers

Nous avons commencé à organiser le projet comme des pros ("Séparation des préoccupations").

* **`app/data.php`** : Le "Cerveau". Contient uniquement les données (le tableau PHP).
* **`public/catalogue.php`** : Le "Visage". Contient le HTML et l'affichage.

**Pour relier les deux :**

```php
// require_once : "J'ai besoin de ce fichier sinon je plante"
// __DIR__ : "Dossier actuel"
// /../ : "Remonter d'un dossier"
require_once __DIR__ . '/../app/data.php';

```

---

## 5. Gestion des Images

* Ne jamais utiliser de lien local absolu (`C:/Users...` ou `/var/www...`).
* Utiliser des liens relatifs au serveur web (`/assets/images/mon-image.png`).
* Toujours ajouter les images dans Git (`git add`).

---

## 6. Git & GitHub (Niveau 2)

Nous avons rencontré des cas concrets de travail en équipe.

| Commande | Action |
| --- | --- |
| `git pull` | **Récupérer** les modifications depuis GitHub vers mon PC. |
| `git rm fichier` | **Supprimer** un fichier proprement (disque + historique git). |
| `git config --global pull.rebase false` | Configurer Git pour qu'il fusionne (merge) par défaut lors d'un pull. |

### Gérer un conflit

Quand GitHub et mon PC ne sont pas d'accord sur un fichier :

1. Faire `git pull` (message d'erreur CONFLIT).
2. Choisir ce qu'on garde (modifier le fichier ou faire un `git add` pour valider notre version).
3. Faire un `git commit` pour valider la fusion.
4. Faire `git push`.
