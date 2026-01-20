<?php

require_once 'Product.php';

class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

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

    //LECTURE (READ)

    public function find(int $id): Product|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->hydrate($data) : false;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return array_map([$this, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    //RECHERCHES AVANCÉES (Pour l'Exercice 3)

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
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE name LIKE :t1 OR description LIKE :t2");
        
        $wildcard = "%$term%";
        
        $stmt->execute([
            't1' => $wildcard,
            't2' => $wildcard
        ]);
        
        return array_map([$this, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // --- ÉCRITURE STRICTE (MODE OBJET) ---

    
    //CREATE (SAVE) : On reçoit un OBJET Product
    
    public function save(Product $product): void
    {
        $sql = "INSERT INTO products (name, description, price, stock, category_id) 
                VALUES (:name, :description, :price, :stock, :cat_id)";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            'name'        => $product->getName(),
            'description' => $product->getDescription(),
            'price'       => $product->getPrice(),
            'stock'       => $product->getStock(),
            'cat_id'      => $product->getCategoryId()
        ]);
        
        echo "✅ Produit sauvegardé !<br>";
    }

    
     //UPDATE : On reçoit un OBJET Product
     
    public function update(Product $product): void
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
            'id'     => $product->getId(),
            'name'   => $product->getName(),
            'desc'   => $product->getDescription(),
            'price'  => $product->getPrice(),
            'stock'  => $product->getStock(),
            'cat_id' => $product->getCategoryId()
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}