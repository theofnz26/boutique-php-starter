<?php
class ProductRepository
{
    public function __construct(private PDO $pdo) {}

    private function hydrate(array $data): Product
    {
        return new Product(
            id: (int)$data['id'],
            name: $data['name'],
            description: $data['description'] ?? '',
            price: (float)$data['price'],
            stock: (int)$data['stock']
        );
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return array_map([$this, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public function find(int $id): ?Product
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->hydrate($data) : null;
    }
}