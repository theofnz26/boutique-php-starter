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
}