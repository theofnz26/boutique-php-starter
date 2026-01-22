<?php

namespace App\Repository;

use App\Entity\Category;
use PDO;

// CategoryRepository avec PDO
// Méthodes : find, findAll, findBySlug, save, update, delete
// Utilise des requêtes préparées
// Retourne des objets Category

class CategoryRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @param array<string, mixed> $data
     */
    private function hydrate(array $data): Category
    {
        return new Category(
            (int)$data['id'],
            $data['name'],
            $data['slug'],
            $data['description'] ?? null
        );
    }

    public function find(int $id): ?Category
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }
    /**
     * @return array<Category>
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM categories');
        $categories = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $this->hydrate($data);
        }

        return $categories;
    }


    public function findBySlug(string $slug): ?Category
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }

    public function save(Category $category): void
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO categories (name, slug, description) 
            VALUES (:name, :slug, :description)
        ');

        $stmt->execute([
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'description' => $category->getDescription()
        ]);
    }

    public function update(Category $category): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE categories 
            SET name = :name, slug = :slug, description = :description 
            WHERE id = :id
        ');

        $stmt->execute([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'description' => $category->getDescription()
        ]);
    }
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
