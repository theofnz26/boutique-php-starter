<?php

// 1. On charge la définition de l'objet Product
require_once 'Product.php';

class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 🪄 HYDRATATION
     * Transforme un tableau SQL en Objet Product
     */
    private function hydrate(array $data): Product
    {
        return new Product(
            id:          (int)$data['id'],
            name:        $data['name'],
            description: $data['description'] ?? null,
            price:       (float)$data['price'],
            stock:       (int)$data['stock'],
            categoryId:  isset($data['category_id']) ? (int)$data['category_id'] : null
        );
    }

    // --- LECTURE (READ) ---

    public function find(int $id): Product|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Si data est faux (pas trouvé), on renvoie false, sinon on hydrate
        return $data ? $this->hydrate($data) : false;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return array_map([$this, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findByCategory(int $categoryId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id = :id");
        $stmt->execute(['id' => $categoryId]);
        return array_map([$this, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findInStock(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products WHERE stock > 0");
        return array_map([$this, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function search(string $term): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE name LIKE :term OR description LIKE :term");
        $stmt->execute(['term' => "%$term%"]);
        return array_map([$this, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // --- ÉCRITURE (CREATE, UPDATE, DELETE) ---

    public function create(string $name, string $description, float $price, int $stock, int $categoryId): void
    {
        $sql = "INSERT INTO products (name, description, price, stock, category_id) 
                VALUES (:name, :description, :price, :stock, :cat_id)";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            'name'        => $name,
            'description' => $description,
            'price'       => $price,
            'stock'       => $stock,
            'cat_id'      => $categoryId
        ]);
        
        echo "✅ Produit ajouté avec succès !<br>";
    }

    /**
     * UPDATE : La version COMPLÈTE pour edit.php
     * Elle met à jour le nom, la description, le prix, le stock et la catégorie.
     */
    public function update(int $id, string $name, string $description, float $price, int $stock, int $categoryId): void
    {
        $sql = "UPDATE products 
                SET name = :name, 
                    description = :desc, 
                    price = :price, 
                    stock = :stock, 
                    category_id = :cat_id 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            'id'     => $id,
            'name'   => $name,
            'desc'   => $description,
            'price'  => $price,
            'stock'  => $stock,
            'cat_id' => $categoryId
        ]);
        
        // On ne met pas d'echo ici, car edit.php gère son propre message de succès.
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        // L'echo ici n'est pas grave, mais delete.php fait une redirection rapide donc on ne le verra pas.
    }
}