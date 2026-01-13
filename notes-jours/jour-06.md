# 📝 Journal de Bord : Jour 6 — Interactivité et Données (GET/POST)

**Date :** 13 Janvier 2026
**Sujet :** Rendre le site vivant, communiquer avec l'URL et les formulaires.

---

## 🚀 Résumé de la journée
Aujourd'hui, mon site a arrêté de parler tout seul. Il a appris à **écouter** l'utilisateur.
J'ai compris comment récupérer des informations (via l'adresse du site ou via des formulaires) et comment organiser mon code pour ne pas mélanger les données et l'affichage.

---

## 1. `$_GET` : Les infos dans l'URL
J'ai appris que l'adresse du site (URL) peut transporter des variables.
* **Syntaxe :** `page.php?nom=Toto&age=25`
* **En PHP :** `$_GET['nom']` contient "Toto".
* **Utilisation :** Pour la navigation (ID d'un produit), la recherche, les filtres.
* **Sécurité :** Tout le monde voit ces infos, donc jamais de mot de passe ici !

> **L'opérateur magique `??` :**
> `$nom = $_GET['name'] ?? 'Inconnu';`
> Ça veut dire : "Prends le nom dans l'URL, mais s'il n'y est pas, prends 'Inconnu' par défaut". Ça évite les erreurs rouges.

---

## 2. `$_POST` : Les formulaires sécurisés
Pour envoyer des données sensibles (email, mot de passe) ou volumineuses (message contact), j'utilise la méthode POST.
* Les données voyagent cachées dans "l'enveloppe" de la requête.
* **En PHP :** Je récupère tout dans le tableau `$_POST`.

### La Sécurité (Règle d'or)
J'ai appris qu'il ne faut **JAMAIS** faire confiance à l'utilisateur.
Si j'affiche ce qu'il a écrit, je dois le nettoyer pour empêcher le piratage (XSS).
* **Commande :** `htmlspecialchars($message)`

---

## 3. Le Moteur de Recherche et Filtres
J'ai créé un moteur de recherche interne.
* **La logique :** Je parcours mon tableau de produits avec `foreach`.
* **Le test :** Si le nom du produit contient le mot recherché (`stripos`), je le garde. Sinon, je passe au suivant (`continue`).
* **L'entonnoir :** Je peux cumuler les filtres (Prix + Catégorie + Stock) pour affiner les résultats.

---

## 4. L'Architecture "Données vs Vue"
J'ai séparé mon code en deux fichiers distincts pour la même page :
1.  **Le Frigo (`app/produits.php`) :** Il ne contient QUE le tableau de données. Pas de HTML.
2.  **L'Assiette (`public/produit.php`) :** Il contient le HTML et va chercher les données dans le frigo.

**Avantage :** Si je change le prix d'un produit dans le frigo, il est mis à jour partout sur le site instantanément.

---

## ⚡ Aide-Mémoire Syntaxique

| Syntaxe | Exemple | À quoi ça sert ? |
| :--- | :--- | :--- |
| **$_GET** | `$id = $_GET['id'] ?? null;` | Récupère une info visible dans l'URL (`?id=5`). |
| **$_POST** | `$mail = $_POST['email'];` | Récupère une info envoyée par un formulaire (caché). |
| **Coalescence** | `$x = $_GET['a'] ?? 'b';` | "Si ça existe prends-le, sinon prends la valeur par défaut". |
| **Sécurité XSS** | `echo htmlspecialchars($nom);` | Transforme les symboles `< >` en texte pour éviter le piratage. |
| **Recherche** | `stripos($phrase, $mot)` | Cherche un mot dans une phrase (Insensible aux Majuscules). |
| **Passer au suivant** | `continue;` | Dans une boucle, saute directement à l'élément suivant (utile pour filtrer). |
| **Lien dynamique** | `<a href="produit.php?id=<?= $id ?>">` | Crée un lien unique pour chaque produit. |

---

---

### 1. Le "Sticky Form" (Formulaire Collant)
C'est une règle d'or en UX (Expérience Utilisateur). Si l'utilisateur fait une erreur dans un formulaire, **il ne doit pas tout retaper**.
* **La technique :** Je remets ce qu'il a écrit dans l'attribut `value`.
* **Le code :** `<input value="<?= htmlspecialchars($username) ?>">`
* **Résultat :** Le champ reste rempli même après rechargement de la page.

### 2. Le Trio de la Sécurité
J'ai compris que le traitement d'une donnée se fait en 3 étapes distinctes :
1.  **Nettoyer (Input) :** J'utilise `trim()` pour enlever les espaces inutiles au début et à la fin.
2.  **Valider (Logic) :** J'utilise `filter_var()` ou `strlen()` pour vérifier si la donnée est bonne.
3.  **Sécuriser (Output) :** J'utilise `htmlspecialchars()` **seulement au moment d'afficher** pour éviter les failles XSS.

### 3. La Stratégie du "Early Exit" (Sortie Rapide)
Dans ma boucle de filtrage, au lieu de faire des `if` imbriqués (qui créent un code en escalier difficile à lire), j'utilise `continue`.
* **Mauvaise pratique :** `Si (prix ok) { Si (catégorie ok) { Si (stock ok) { ... } } }`
* **Bonne pratique (Ce que j'ai fait) :**
    ```php
    if (prix trop cher) continue; // Hop, au suivant !
    if (mauvaise catégorie) continue; // Hop, au suivant !
    // Si on est encore là, c'est que tout est bon.
    ```
Ça rend mon code beaucoup plus lisible et plat.

### 4. Le Concept de "Template Dynamique"
J'ai réalisé que je n'ai plus besoin de créer 50 pages pour 50 produits.
* Je crée **un seul moule** (`produit.php`).
* Je verse les données dedans dynamiquement selon l'ID.
* C'est la base de tous les CMS modernes (WordPress, Shopify, etc.).

## 🧠 Bilan Personnel
* **Difficulté :** J'ai eu du mal à comprendre pourquoi j'avais deux fichiers `produits.php`. J'ai compris que l'un est le stock de données (pluriel, dossier `app`) et l'autre est la page d'affichage (singulier, dossier `public`).
* **Victoire :** Voir mon catalogue filtrer les produits et cliquer sur un produit pour voir ses détails. C'est magique !