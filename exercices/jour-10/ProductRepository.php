<?php

class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * READ: Récupérer un produit précis par son ID
     */
    public function find(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * READ: Récupérer TOUTE la liste
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * CREATE: Ajouter un nouveau produit
     */
    public function create(string $name, string $description, float $price, int $stock, string $category): void
    {
        $sql = "INSERT INTO products (name, description, price, stock, category) 
                VALUES (:name, :description, :price, :stock, :category)";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            'name'        => $name,
            'description' => $description,
            'price'       => $price,
            'stock'       => $stock,
            'category'    => $category
        ]);
        
        echo "✅ Produit ajouté avec succès !<br>";
    }

    /**
     * UPDATE: Modifier un produit existant
     * (Ici on modifie juste le nom et le prix pour l'exemple)
     */
    public function update(int $id, string $name, float $price): void
    {
        $sql = "UPDATE products SET name = :name, price = :price WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            'id'    => $id,
            'name'  => $name,
            'price' => $price
        ]);
        
        echo "✅ Produit $id modifié avec succès !<br>";
    }

    /**
     * DELETE: Supprimer un produit
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM products WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        echo "🗑️ Produit $id supprimé de la base.<br>";
    }
}