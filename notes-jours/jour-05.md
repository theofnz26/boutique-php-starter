# 📝 Journal de Bord : Jour 5 — Les Fonctions et l'Architecture

**Date :** 12 Janvier 2026
**Sujet :** PHP Moderne - Fonctions, Portée des variables et Organisation des fichiers.

---

## 🚀 Résumé de la journée
Aujourd'hui, j'ai franchi un cap majeur. J'ai arrêté de coder "au kilomètre" en copiant-collant des blocs répétitifs. J'ai appris à **factoriser** mon code en créant mes propres outils : les **fonctions**.

J'ai aussi restructuré mon projet pour qu'il ressemble à une application professionnelle : j'ai séparé la logique (le cerveau) de l'affichage (le visage).

---

## 1. Les Fonctions : Mes Nouveaux Robots

Une fonction est un bloc de code auquel je donne un nom. C'est comme fabriquer un petit robot spécialisé.

### Le concept
Au lieu de répéter 5 fois le calcul de la TVA, je crée une fonction `calculerTTC`.
- **Définition (`function`) :** Je construis le robot et je lui donne sa recette.
- **Appel (`nom()`) :** J'appuie sur le bouton pour qu'il exécute la recette.
- **Paramètres (`$arg`) :** Ce sont les ingrédients que je donne au robot pour qu'il travaille (ex: le prix HT).

### `Echo` vs `Return` (Le déclic 💡)
C'est la notion la plus importante que j'ai apprise aujourd'hui.
* **Avec `echo` :** Le robot affiche le résultat directement sur l'écran. C'est comme s'il jetait le jus d'orange par terre. Je ne peux rien en faire d'autre.
* **Avec `return` :** Le robot **me tend** le résultat (le verre de jus). Il ne l'affiche pas. Il me donne la valeur pour que je puisse la stocker dans une variable, l'additionner, ou la modifier encore.

> **Note à moi-même :** Une fonction de calcul (TVA, Remise) doit TOUJOURS utiliser `return`.

---

## 2. La Portée des Variables (Le Scope)

J'ai un peu galéré sur ce point. J'ai appris que les fonctions sont des **boîtes hermétiques**.

* Une variable `$prix` définie à l'extérieur **n'existe pas** à l'intérieur de la fonction.
* Une variable `$total` calculée à l'intérieur de la fonction **disparaît** une fois la fonction finie.

### L'Analogie du "Passe-Plat"
Pour faire communiquer l'intérieur et l'extérieur, il faut passer les plats :
1.  **Entrée :** Je passe des valeurs via les **paramètres** (entre parenthèses).
2.  **Sortie :** La fonction me renvoie le résultat via **`return`**.
3.  **Réception :** Je dois capturer ce résultat dans une variable dehors (`$monResultat = maFonction(...)`).

> **Ce que j'ai compris :** Le nom de la variable à l'intérieur n'a pas besoin d'être le même qu'à l'extérieur. C'est la **valeur** qui voyage.

---

## 3. L'Architecture et le "Refactoring"

J'ai arrêté de tout mélanger dans un seul fichier `catalogue.php`. J'ai mis en place une structure professionnelle.

### L'Organisation des dossiers
```text
/var/www/boutique
├── app/                <-- LE CERVEAU (Caché)
│   └── helpers.php     <-- Ma "Boîte à Outils" (Fonctions pures)
│
├── public/             <-- LE VISAGE (Visible)
│   └── catalogue.php   <-- Mon Affichage HTML

La connexion : require_once

Pour que ma page HTML puisse utiliser mes outils, je dois les importer au tout début du fichier :
PHP

require_once __DIR__ . '/../app/helpers.php';

    __DIR__ : "Le dossier où je suis".

    /../ : "Je remonte d'un étage".

⚡ Aide-Mémoire Syntaxique
Syntaxe	Exemple	Explication Simple
Créer une fonction	function maFonction() { ... }	Je définis une nouvelle action réutilisable.
Paramètres	function test($nom, $age)	Les "ingrédients" nécessaires pour que la fonction marche.
Valeur par défaut	function test($a = 10)	Si je ne précise pas $a lors de l'appel, il vaudra 10 automatiquement.
Retourner	return $resultat;	La fonction s'arrête et renvoie la valeur (indispensable pour les calculs).
Appeler	maFonction("Toto");	J'exécute le code de la fonction.
Fonction Booléenne	return $age >= 18;	Renvoie directement true ou false (super pour les validations).
Importer	require_once "fichier.php";	Charge le contenu d'un autre fichier PHP ici.
Debug	var_dump($var); die();	Affiche le contenu brut d'une variable et tue le script (pratique quand ça plante).
🛠️ Mes Outils "Maison" (Helpers) created today

J'ai créé une bibliothèque de fonctions que je peux réutiliser partout :

    calculateTTC($ht) : Pour ne plus calculer la TVA à la main.

    formatPrice($prix) : Pour avoir de jolis prix (12,50 €) automatiquement.

    displayPrice($prix, $remise) : Gère tout seul l'affichage du prix barré en rouge si promo.

    displayStock($qte) : Affiche le badge "En stock" ou "Rupture" avec la bonne couleur.

    dump_and_die($var) : Ma fonction de détective pour inspecter les bugs.

🧠 Bilan Personnel

    Difficulté rencontrée : Au début, je voyais une page blanche ou un seul produit car j'avais mal nommé mes fonctions entre le fichier helpers et le catalogue. J'ai appris que la rigueur sur les noms est cruciale.

    Victoire : Voir mon code HTML devenir super propre et lisible (une ligne <div class="prix">...</div> au lieu de 10 lignes de if/else).

    À retenir : "Séparer les responsabilités". Le fichier app calcule, le fichier public affiche. Chacun son métier.