# 📘 Jour 11 : Architecture Professionnelle & Pattern Repository

## 1. Introduction : Pourquoi changer d'architecture ?

Avant le Jour 11, nous écrivions du code "procédural" (tout dans un seul fichier : connexion SQL, HTML, logique PHP).
**Problème :** Impossible à maintenir, à tester ou à faire évoluer.

**Solution :** La séparation des responsabilités.
1.  **Entity (Entité) :** Représente l'objet (ex: `Product`). C'est juste un conteneur de données.
2.  **Repository (Dépôt) :** Gère l'accès aux données (SQL). C'est le seul endroit où on parle à la base de données.
3.  **Controller (Contrôleur) :** Le chef d'orchestre. Il demande des données au Repository et les envoie à la Vue.

---

## 2. Tableau de Syntaxe & Nouvelles Fonctions

Voici les outils techniques introduits pour supporter cette architecture :

| Syntaxe / Fonction | Utilité | Exemple |
| :--- | :--- | :--- |
| **`PDO::prepare()`** | Prépare une requête SQL pour éviter les failles d'injection. Indispensable avec des variables utilisateur. | `$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');` |
| **`execute(['key' => $val])`** | Exécute la requête préparée en remplaçant les paramètres nommés (`:id`) par les vraies valeurs. | `$stmt->execute(['id' => 42]);` |
| **`fetch(PDO::FETCH_ASSOC)`** | Récupère **une seule** ligne de résultat sous forme de tableau associatif. | `$user = $stmt->fetch(PDO::FETCH_ASSOC);` |
| **`fetchAll(PDO::FETCH_ASSOC)`** | Récupère **toutes** les lignes de résultat (tableau de tableaux). | `$users = $stmt->fetchAll(PDO::FETCH_ASSOC);` |
| **Injection de Dépendance** | Passer un objet nécessaire (ex: PDO) via le constructeur au lieu de le créer dedans. | `public function __construct(private PDO $pdo) {}` |
| **Typage strict** | Forcer le type des arguments et des retours pour éviter les bugs. | `public function find(int $id): ?Product` |
| **`?Type` (Nullable)** | Indique qu'une fonction peut renvoyer le Type OU `null`. | `?Product` (Renvoie un Produit ou rien si non trouvé). |

---

## 3. Cours : Le Pattern Repository & CRUD

### Qu'est-ce qu'un Repository ?
C'est une classe PHP dont l'unique responsabilité est de **parler à la base de données** pour une Entité spécifique.
* `ProductRepository` gère la table `products`.
* `UserRepository` gère la table `users`.

### L'Injection de PDO
Pour travailler, le Repository a besoin de la connexion à la base. On ne crée pas `new PDO()` à l'intérieur (ce serait une mauvaise pratique). On lui **injecte** la connexion via son constructeur.

### Le concept CRUD
Un Repository complet implémente généralement les 4 opérations fondamentales de la persistance des données :

* **C**reate (Créer) : `save()` ou `create()` -> `INSERT INTO`
* **R**ead (Lire) : `find()`, `findAll()` -> `SELECT`
* **U**pdate (Mettre à jour) : `save()` ou `update()` -> `UPDATE`
* **D**elete (Supprimer) : `delete()` -> `DELETE`

---

## 4. L'Hydratation : Le cœur du système

**Définition :** L'hydratation est le processus de conversion d'un tableau de données brutes (venant de SQL) en un Objet PHP riche.

* **SQL renvoie :** `['id' => 1, 'name' => 'Carte', 'price' => 10]` (Tableau bête)
* **On veut :** `new Product(1, 'Carte', 10)` (Objet intelligent avec méthodes)

C'est le rôle d'une méthode souvent privée appelée `hydrate()`. Elle fait le pont entre le monde relationnel (SQL) et le monde objet (PHP).

---

## 5. Implémentation Complète : ProductRepository

Voici le code modèle intégrant toutes les notions : Injection, CRUD, Hydratation et Typage strict.

```php
<?php

namespace App\Repository;

use App\Entity\Product;
use PDO;

class ProductRepository
{
    // 1. Injection de Dépendance : On reçoit la connexion, on ne la crée pas.
    public function __construct(private PDO $pdo) {}

    /**
     * HYDRATATION
     * Transforme un tableau SQL (array) en Objet Product.
     * Cette méthode centralise la création d'objets pour ne pas répéter le code.
     */
    private function hydrate(array $data): Product
    {
        return new Product(
            (int)$data['id'],          // Cast en int car SQL renvoie parfois des strings
            $data['name'],
            $data['description'],
            (float)$data['price'],     // Cast en float
            (int)$data['stock']
        );
    }

    /**
     * READ (Un seul)
     * Récupère un produit par son ID.
     * Retourne ?Product (Objet ou null si pas trouvé).
     */
    public function find(int $id): ?Product
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        // Récupération du tableau associatif
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si pas de données, on renvoie null
        if (!$data) {
            return null;
        }

        // Sinon, on hydrate et on renvoie l'objet
        return $this->hydrate($data);
    }

    /**
     * READ (Tous)
     * Récupère tous les produits.
     * Retourne un tableau d'objets Product.
     * @return array<Product>
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // On hydrate chaque ligne et on l'ajoute au tableau
            $products[] = $this->hydrate($data);
        }

        return $products;
    }

    /**
     * CREATE / UPDATE (Save)
     * Sauvegarde un objet en base.
     * Ici, exemple simplifié pour l'INSERTion (Création).
     */
    public function save(Product $product): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO products (name, description, price, stock) 
            VALUES (:name, :description, :price, :stock)
        ");

        $stmt->execute([
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'stock' => $product->getStock()
        ]);
        
        // Note : Si c'était un Update, on ferait un UPDATE ... WHERE id = ...
    }
    
    /**
     * DELETE
     * Supprime un produit.
     */
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}