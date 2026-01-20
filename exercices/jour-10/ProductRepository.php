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
     * Cette méthode privée transforme un tableau SQL (array) en un Objet Product.
     * C'est elle qui fait la magie pour que tu puisses faire $produit->getName()
     */
    private function hydrate(array $data): Product
    {
        return new Product(
            id:          (int)$data['id'],
            name:        $data['name'],
            description: $data['description'] ?? null, // ?? null gère le cas où c'est vide
            price:       (float)$data['price'],
            stock:       (int)$data['stock'],
            categoryId:  isset($data['category_id']) ? (int)$data['category_id'] : null
        );
    }

    /**
     * READ: Récupérer un produit précis par son ID
     * Retourne un Objet Product (ou false si pas trouvé)
     */
    public function find(int $id): Product|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si pas de résultat, on retourne false
        if (!$data) {
            return false;
        }

        // Sinon, on transforme le tableau en Objet
        return $this->hydrate($data);
    }

    /**
     * READ: Récupérer TOUTE la liste
     * Retourne un tableau d'Objets Product
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $lines = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // array_map applique la méthode 'hydrate' sur chaque ligne trouvée
        return array_map([$this, 'hydrate'], $lines);
    }

    // --- NOUVELLES MÉTHODES DE RECHERCHE (EXERCICE 3) ---

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

    // --- MÉTHODES D'ÉCRITURE (C.U.D) ---

    /**
     * CREATE: Ajouter un nouveau produit
     * ⚠️ J'ai changé $category (string) en $categoryId (int) pour coller à ta nouvelle BDD !
     */
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
            'cat_id'      => $categoryId // On insère l'ID maintenant
        ]);
        
        echo "✅ Produit ajouté avec succès !<br>";
    }

    public function update(int $id, string $name, float $price): void
    {
        $sql = "UPDATE products SET name = :name, price = :price WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'name' => $name, 'price' => $price]);
        echo "✅ Produit $id modifié avec succès !<br>";
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        echo "🗑️ Produit $id supprimé de la base.<br>";
    }
}