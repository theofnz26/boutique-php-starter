# 📚 Mémento Syntaxique PHP (Jours 1 à 4)

### 1. Les Bases et l'Affichage
| Syntaxe | Description | Exemple |
| :--- | :--- | :--- |
| **`<?php ... ?>`** | Balises d'ouverture et fermeture | Toujours au début du fichier. |
| **`echo`** | Affiche du texte ou du HTML à l'écran | `echo "Bonjour";` |
| **`<?= ... ?>`** | Raccourci pour `echo` (pratique dans le HTML) | `<h1><?= $titre ?></h1>` |
| **`//`** | Commentaire sur une ligne (ignoré par PHP) | `// Ceci est une note pour moi` |
| **`/* ... */`** | Commentaire sur plusieurs lignes | `/* Note sur <br> deux lignes */` |
| **`;`** | **Point-virgule** (Obligatoire) | Marque la fin d'une instruction. |

### 2. Variables et Types de Données
| Syntaxe | Description | Exemple |
| :--- | :--- | :--- |
| **`$nom`** | Déclarer une variable (toujours avec `$`) | `$prix = 10;` |
| **`string`** | Chaîne de caractères (Texte) | `"Hello World"` |
| **`int`** | Entier (Nombre sans virgule) | `42` |
| **`float`** | Décimal (Nombre à virgule) | `19.99` (avec un point !) |
| **`bool`** | Booléen (Vrai ou Faux) | `true` ou `false` |
| **`.`** | **Concaténation** (Coller du texte) | `"J'ai " . $age . " ans"` |

### 3. Les Tableaux (Arrays)
| Syntaxe | Description | Exemple |
| :--- | :--- | :--- |
| **`[...]`** | Créer un tableau simple (liste) | `$fruits = ["Pomme", "Poire"];` |
| **`$tab[0]`** | Accéder au 1er élément (index 0) | `echo $fruits[0];` // Pomme |
| **`=>`** | Associer une Clé à une Valeur | `["nom" => "Jean", "age" => 25]` |
| **`$tab['clé']`** | Accéder à une valeur par sa clé | `echo $user['nom'];` |

### 4. Les Conditions (Logique)
| Syntaxe | Description | Exemple |
| :--- | :--- | :--- |
| **`if (...) { }`** | Si la condition est vraie | `if ($age >= 18) { ... }` |
| **`else { }`** | Sinon (par défaut) | `else { echo "Mineur"; }` |
| **`elseif (...)`** | Sinon Si (autre condition) | `elseif ($age > 12) { ... }` |
| **`(cond) ? X : Y`** | **Ternaire** (If/Else en une ligne) | `$etat = ($stock > 0) ? 'Ok' : 'Rupture';` |
| **`match`** | Version moderne du Switch (PHP 8) | `$res = match($statut) { 'ok' => 'Super', ... };` |

### 5. Les Comparaisons et Opérateurs
| Syntaxe | Description | Exemple |
| :--- | :--- | :--- |
| **`==`** | Égalité Laxe (Valeur seule) | `0 == "0"` (VRAI - Dangereux) |
| **`===`** | **Égalité Stricte (Valeur + Type)** | `0 === "0"` (FAUX - Sécurisé) |
| **`!=`** | Différent de | `$a != $b` |
| **`>` / `<`** | Plus grand / Plus petit | `$prix < 50` |
| **`&&`** | **ET** (Les deux doivent être vrais) | `$stock > 0 && $actif === true` |
| **`||`** | **OU** (L'un des deux suffit) | `$role == 'admin' || $role == 'editor'` |
| **`!`** | **NON** (Inverse le résultat) | `if (!empty($var))` (Si PAS vide) |

### 6. Les Boucles
| Syntaxe | Description | Exemple |
| :--- | :--- | :--- |
| **`foreach`** | Parcourir chaque élément d'un tableau | `foreach ($produits as $p) { ... }` |
| **`continue`** | Passer directement au tour suivant | `if ($stock == 0) continue;` |
| **`break`** | Arrêter complètement la boucle | `if ($trouve) break;` |

### 7. Fonctions Utiles (Outils)
| Fonction | Utilité | Exemple |
| :--- | :--- | :--- |
| **`var_dump($x)`** | Débug : Affiche le type et le contenu brut | `var_dump($produits);` |
| **`count($tab)`** | Compte les éléments d'un tableau | `echo count($articles);` |
| **`number_format()`**| Formate un prix (décimales) | `number_format($prix, 2);` |
| **`include`** / **`require`** | Inclure un autre fichier PHP | `require 'app/data.php';` |
| **`date('Y-m-d')`** | Affiche la date actuelle | `echo date('d/m/Y');` |
| **`time()`** | Timestamp actuel (secondes depuis 1970) | Utilisé pour comparer des dates |