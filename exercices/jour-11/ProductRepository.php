<?php

require_once 'Product.php';

class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Méthode privée pour transformer un tableau SQL en Objet Product
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

    // --- CONSIGNE EXERCICE 1 : find() et findAll() ---

    public function find(int $id): ?Product
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si data existe, on hydrate, sinon on retourne null
        return $data ? $this->hydrate($data) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // On utilise array_map pour transformer chaque ligne en Objet
        return array_map([$this, 'hydrate'], $lignes);
    }

    // --- AJOUTS EXERCICE 2 (C.U.D) ---

    /**
     * CREATE : Sauvegarder un nouveau produit
     */
    public function save(Product $product): void
    {
        $sql = "INSERT INTO products (name, description, price, stock, category_id) 
                VALUES (:name, :desc, :price, :stock, :cat_id)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name'  => $product->getName(),
            'desc'  => $product->getDescription(),
            'price' => $product->getPrice(),
            'stock' => $product->getStock(),
            'cat_id'=> $product->getCategoryId()
        ]);
        
        echo "✅ Produit \"" . $product->getName() . "\" créé en base de données !<br>";
    }

    /**
     * UPDATE : Modifier un produit existant
     */
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
            'id'    => $product->getId(),
            'name'  => $product->getName(),
            'desc'  => $product->getDescription(),
            'price' => $product->getPrice(),
            'stock' => $product->getStock(),
            'cat_id'=> $product->getCategoryId()
        ]);
        
        echo "🔄 Produit ID " . $product->getId() . " mis à jour !<br>";
    }

    /**
     * DELETE : Supprimer par l'ID
     */
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        echo "🗑️ Produit ID $id supprimé.<br>";
    }
}