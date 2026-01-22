<?php

namespace App\Repository;

use PDO;

class ProductRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @param array<string, mixed> $data
     */
    private function hydrate(array $data): \App\Entity\Product
    {
        return new \App\Entity\Product(
            (int)$data['id'],
            $data['name'],
            $data['description'],
            (float)$data['price'],
            (int)$data['stock']
        );
    }

    public function find(int $id): ?\App\Entity\Product
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }

    /**
     * @return array<\App\Entity\Product>
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM products');
        $products = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = $this->hydrate($data);
        }

        return $products;
    }
}
