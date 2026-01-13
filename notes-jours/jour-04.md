# 📝 Bilan du Jour 4 : La Logique Conditionnelle

Aujourd'hui, j'ai franchi une étape majeure. Mon code ne se contente plus d'afficher bêtement des données, il commence à **réfléchir**. J'ai appris à rendre mes pages "intelligentes" : elles peuvent prendre des décisions, filtrer du contenu et s'adapter selon les données (stock, promo, âge...).

---

## 🧠 1. Les Conditions (`if`, `elseif`, `else`)
C'est la base de la prise de décision.
* **J'ai appris :** À dire à PHP "Si telle condition est vraie, fais ça. Sinon, fais autre chose".
* **Mon erreur au début :** J'ai confondu l'affectation (donner une valeur) et la comparaison.
    * *Mauvais :* `$age = ($dice != 90)` (Ceci donnait "Vrai" ou "Faux" à mon âge, pas un nombre).
    * *Bon :* `$age = 90;` puis `if ($age < 18)...`

## ⚖️ 2. Le Choc des Comparaisons (`==` vs `===`)
C'est sans doute la notion la plus importante pour la sécurité et la logique.
* **`==` (Laxe) :** PHP essaie d'être "sympa" et convertit les types.
    * *Danger :* `0 == ""` est VRAI (Zéro est égal à Vide). Cela peut causer des bugs énormes.
* **`===` (Strict) :** PHP vérifie la valeur **ET** le type.
    * *Sécurité :* `0 === ""` est FAUX (Un nombre n'est pas du texte).
* **Ma règle d'or :** J'utilise toujours **`===`** par défaut.

## 🔀 3. Switch et Match (L'aiguillage)
Quand j'ai beaucoup de cas précis (ex: statuts de commande), le `if` devient lourd.
* **Switch :** L'ancienne méthode. Il ne faut surtout pas oublier le `break;` à la fin de chaque cas, sinon il exécute tout !
* **Match (PHP 8) :** Plus moderne, plus court, et il fait une comparaison stricte automatiquement. C'est celui que je préfère.

## 🤝 4. Logique Combinée (`&&`, `||`) et Temps
J'ai appris à poser plusieurs questions en même temps.
* **ET (`&&`) :** Il faut que **toutes** les conditions soient vraies (ex: Stock > 0 **ET** Actif).
* **OU (`||`) :** Il suffit qu'**une seule** condition soit vraie.
* **Les Dates :** J'ai vu que pour comparer des dates, il faut utiliser `strtotime()` pour les transformer en nombres (secondes), sinon l'ordinateur ne comprend pas qui est "avant" ou "après".

## ⚡ 5. L'Opérateur Ternaire (Le "One-Liner")
C'est mon nouvel outil préféré pour le HTML. C'est un `if/else` qui tient sur une ligne.
* **Syntaxe :** `(Condition) ? VRAI : FAUX`
* **Utilisation :** Parfait pour changer une classe CSS (`class="<?= $stock ? 'ok' : 'ko' ?>"`) ou afficher un badge.

## 🕵️‍♂️ 6. Filtrer avec `continue`
Dans une boucle, je peux décider d'ignorer certains éléments.
* **Le concept :** Si le produit ne me plaît pas (trop cher, pas de stock), je lance un `continue`.
* **Résultat :** PHP "zappe" ce tour de boucle et passe directement au produit suivant. C'est très propre pour faire des filtres.

---

## 🏗️ 7. Le Projet Fil Rouge : Catalogue Intelligent
J'ai intégré toute cette logique dans mon catalogue.
* **Ce que j'ai fait :**
    * Afficher "NOUVEAU" ou "PROMO" selon les données.
    * Calculer le prix barré (maths simples).
    * Désactiver le bouton "Ajouter" si le stock est à 0.
    * Calculer des statistiques globales (compteurs) avant d'afficher le HTML.

* **⚠️ Mes galères (Points de vigilance) :**
    1.  **La variable `$p` :** J'ai compris que dans `foreach($products as $p)`, `$p` est juste un surnom temporaire pour "l'objet que je tiens dans la main" à chaque tour.
    2.  **La faute de frappe fatale :** J'ai cherché pendant un moment pourquoi mes promos ne s'affichaient pas. C'était une erreur dans mon tableau de données : j'avais écrit `"discoun"` au lieu de `"discount"`.
    * *Leçon :* Toujours vérifier l'orthographe exacte des clés de mon tableau !

---

## 📚 Mémento de Syntaxe (À garder sous le coude)

| Symbole / Mot-clé | Nom | Traduction / Utilité | Exemple |
| :---: | :--- | :--- | :--- |
| **`==`** | Égal (Laxe) | Vérifie la valeur (convertit si besoin) | `5 == "5"` (VRAI) |
| **`===`** | **Identique (Strict)** | **Vérifie la valeur ET le type** | `5 === "5"` (FAUX) |
| **`!=`** | Différent | Est-ce que c'est différent ? | `$age != 18` |
| **`&&`** | **AND (ET)** | Les deux conditions doivent être vraies | `Stock > 0 && Actif` |
| **`||`** | **OR (OU)** | Au moins une condition doit être vraie | `Carte || Espèces` |
| **`!`** | NOT (NON) | Inverse le résultat | `!empty($var)` |
| **`? :`** | **Ternaire** | If/Else en une ligne | `($stock > 0) ? 'Oui' : 'Non'` |
| **`continue`** | Continuer | "Passe au suivant" (dans une boucle) | `if (pas_bon) continue;` |
| **`break`** | Casser | "Arrête tout et sors" (boucle ou switch) | `if (trouvé) break;` |
| **`strtotime()`** | String to Time | Convertit une date texte en secondes | `strtotime("2024-12-31")` |

---

## 🔬 8. Zoom sur des concepts clés

En plus des conditions, j'ai manipulé des outils puissants pour gérer mes données.

### A. La mécanique des Compteurs (Stats)
Pour afficher "3 produits en rupture", j'ai compris qu'il y a un ordre précis à respecter :
1.  **Initialiser** : Je crée une variable à `0` **AVANT** la boucle (`$compteur = 0;`).
2.  **Incrémenter** : J'ajoute `+1` **DANS** la boucle si la condition est remplie (`$compteur++;`).
3.  **Afficher** : J'affiche le résultat final **APRÈS** la boucle.

> **💡 Mon déclic :** Si je mets `$compteur = 0` *à l'intérieur* de la boucle, il se remet à zéro à chaque tour et je finis avec un résultat de 1 ou 0. Il faut bien le sortir !

### B. L'Alias de Boucle (`$p`)
J'ai posé la question "C'est quoi $p ?".
* Dans `foreach ($tableau as $element)`, la variable `$element` (ou `$p`) est une **étiquette temporaire**.
* Elle change de valeur à chaque tour.
* C'est une copie de l'élément en cours. Je peux l'appeler comme je veux (`$produit`, `$item`, `$tshirt`...), l'important est d'être cohérent à l'intérieur des accolades `{}`.

### C. Maths et Affichage
PHP sait faire des maths, mais pour l'affichage (prix), c'est parfois moche (ex: 15.2).
* **Les calculs :** J'ai fait des maths simples pour les promos : `Prix * (1 - Remise / 100)`.
* **L'esthétique :** J'ai découvert `number_format($prix, 2)` qui force l'affichage de deux décimales (ex: transforme `15` en `15.00`). C'est essentiel pour un site e-commerce pro.

### D. Architecture : Séparation des Pouvoirs
À la fin de la journée, j'ai séparé mon code en deux fichiers.
1.  **Le Cerveau (`app/produits.php`)** : Contient uniquement les données (le tableau `$products`). Aucune balise HTML ici.
2.  **Le Visage (`public/catalogue.php`)** : Contient le HTML et la boucle d'affichage. Il va chercher le cerveau avec `require`.
* **Pourquoi ?** Si demain je veux changer un prix, je ne risque pas de casser mon design HTML. C'est plus sûr et plus propre.

---

## 🛠️ Tableau des Fonctions Utiles (Jour 4)

Voici les fonctions PHP spécifiques que j'ai utilisées pour manipuler mes nombres et mes dates.

| Fonction | À quoi ça sert ? | Exemple | Résultat |
| :--- | :--- | :--- | :--- |
| **`count($array)`** | Compte le nombre d'éléments dans un tableau | `count($products)` | `10` |
| **`number_format($x, 2)`** | Formate un nombre avec 2 décimales | `number_format(12, 2)` | `"12.00"` |
| **`rand(min, max)`** | Génère un nombre aléatoire (pour tester) | `rand(1, 100)` | `42` |
| **`time()`** | Donne l'heure actuelle (en secondes) | `time()` | `1704890000` |
| **`date('Y-m-d')`** | Donne la date lisible d'aujourd'hui | `date('Y-m-d')` | `"2025-01-09"` |
| **`require 'fichier.php'`** | Importe le contenu d'un autre fichier | `require 'data.php'` | (Le code est inclus) |

---

## 🛑 Mes points de blocage (Leçons apprises)

1.  **L'orthographe des clés de tableau (Array Keys) :**
    * *Le bug :* J'ai écrit `"discoun"` au lieu de `"discount"` dans mon tableau.
    * *La conséquence :* PHP ne trouvait pas la clé, donc pour lui la valeur était nulle. Aucune erreur ne s'affichait, mais ma logique ne marchait pas.
    * *La solution :* Toujours copier-coller les noms des clés ou utiliser `var_dump($p)` pour vérifier ce que contient vraiment ma variable.

2.  **Le point-virgule après le `break` :**
    * Dans le `switch`, j'ai compris que le `break` est obligatoire. Si je l'oublie, PHP continue bêtement d'exécuter les cas suivants (le "fall-through").

3.  **L'initialisation des variables :**
    * J'ai appris qu'on ne peut pas faire `$compteur++` si `$compteur` n'existe pas encore. Il faut toujours le déclarer (`$compteur = 0`) avant de l'utiliser.

---

### 🎯 Prochaine étape
Je maîtrise maintenant les boucles et les conditions. Je commence à toucher à l'architecture de fichiers. La suite logique sera d'apprendre à envoyer des données vers le serveur (formulaire) ou à mieux organiser mes fonctions !

### ✅ Conclusion
Je suis maintenant capable de manipuler les données, de les trier et de les afficher conditionnellement. J'ai aussi appris à séparer mes fichiers : d'un côté les données (`app/produits-final.php`), de l'autre l'affichage (`public/catalogue-final.php`). C'est beaucoup plus pro !