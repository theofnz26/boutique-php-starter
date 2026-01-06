# 📘 Jour 1 : Les Fondamentaux de PHP

## 1. Architecture
* **Langage Serveur :** PHP s'exécute sur le serveur. Il génère le HTML qui est ensuite envoyé au navigateur du client.
* **Dynamique :** Contrairement au HTML statique, PHP permet de modifier le contenu de la page avant l'affichage (calculs, bases de données, conditions).

## 2. Syntaxe de base
* **Balises :** Le code doit être entouré de `<?php ... ?>`.
* **Variables :** Toujours préfixées par un `$` (ex: `$prix`).
* **Instructions :** Se terminent obligatoirement par un point-virgule `;`.

## 3. Gestion des Chaînes de caractères (Strings)
Il existe deux manières de gérer le texte, avec une différence technique majeure :

**A. Simple quotes (`'`) : Performance & Concaténation**
PHP n'analyse pas le contenu. Pour insérer une variable, il faut concaténer (assembler) avec le point `.`.
```php
echo 'Prix : ' . $price . ' €';

```

**B. Double quotes (`"`) : Interpolation**
PHP analyse le contenu et remplace automatiquement les variables par leur valeur.

```php
echo "Prix : $price €";

```

## 4. Intégration HTML (Templating)

Pour afficher des données PHP dans une structure HTML, on sépare la logique de la vue.
On utilise la balise courte d'écho `<?= ... ?>` pour l'affichage.

```html
<h1><?= $titre ?></h1>
<p>Prix : <?= $prix ?> €</p>

```

## 5. Formatage des données (Data Formatting)

Ne jamais modifier la donnée brute pour l'affichage. Utiliser des fonctions de présentation au moment du rendu.

* **Fonction :** `number_format()`
* **Usage :** Convertit un float (ex: `1200.5`) en string formatée (ex: `"1 200,50"`).

```php
// (Nombre, Décimales, Séparateur décimal, Séparateur milliers)
echo number_format($prix, 2, ',', ' ');

```

---

## 6. Focus : Points techniques abordés (Q&A)

### A. Le Rendu Côté Serveur (Injection dans le DOM)

Lorsqu'on écrit un bloc comme :

```html
<div class="card">
    <h1><?= $nom ?></h1>
</div>

```

Il s'agit d'un **template**.

1. Le serveur lit le fichier PHP.
2. Il exécute les instructions entre `<?= ?>`.
3. Il remplace le code PHP par la valeur finale (ex: "MacBook").
4. Le client (navigateur) reçoit uniquement du HTML pur. Le code PHP n'est jamais visible dans le code source de la page reçue.

### B. Distinction Donnée Brute vs Donnée Affichée

Il est crucial de distinguer le type de données pour le calcul du type pour l'affichage.

* **Donnée Brute (Raw Data) :** Optimisée pour la machine (Type `Float` ou `Int`). Indispensable pour les opérations mathématiques (`+`, `*`).
* *Exemple :* `1198.8`


* **Donnée Formatée (Formatted Data) :** Optimisée pour l'expérience utilisateur (Type `String`).
* *Exemple :* `"1 198,80 €"`


* **Règle :** On ne stocke jamais une donnée formatée en base de données, et on ne fait pas de calculs dessus. Le formatage intervient uniquement à la toute dernière étape (l'affichage).

```

```