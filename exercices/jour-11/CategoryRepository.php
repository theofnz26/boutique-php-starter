<?php

require_once 'Category.php';
require_once 'Product.php'; // Indispensable car on va manipuler des Produits

class CategoryRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function hydrate(array $data): Category
    {
        return new Category(
            id: (int)$data['id'],
            nom: $data['nom']
        );
    }

    // --- CRUD CLASSIQUE ---

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM categories");
        return array_map([$this, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function find(int $id): ?Category
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->hydrate($data) : null;
    }

    public function save(Category $cat): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO categories (nom) VALUES (:nom)");
        $stmt->execute(['nom' => $cat->getNom()]);
        echo "✅ Catégorie " . $cat->getNom() . " créée.<br>";
    }

    public function update(Category $cat): void
    {
        $stmt = $this->pdo->prepare("UPDATE categories SET nom = :nom WHERE id = :id");
        $stmt->execute(['id' => $cat->getId(), 'nom' => $cat->getNom()]);
        echo "🔄 Catégorie mise à jour.<br>";
    }

    public function delete(int $id): void
    {
        // Attention : Si des produits sont liés, ça plantera à cause de la Clé Étrangère (SQL)
        // Il faudrait d'abord passer les produits en category_id = NULL ou les supprimer.
        // Pour l'exercice, on tente le delete simple.
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        echo "🗑️ Catégorie supprimée.<br>";
    }

    // --- LA MÉTHODE SPÉCIALE (Niveau Boss) ---

    /**
     * Récupère toutes les catégories ET remplit leurs produits
     */
    public function findWithProducts(): array
    {
        // 1. On récupère toutes les catégories
        $categories = $this->findAll();

        // 2. Pour chaque catégorie, on va chercher ses produits
        foreach ($categories as $category) {
            
            // Requete SQL pour trouver les produits de CETTE catégorie
            $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id = :id");
            $stmt->execute(['id' => $category->getId()]);
            $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // On transforme les données brutes en Objets Product
            $productsObjects = [];
            foreach ($productsData as $pData) {
                $productsObjects[] = new Product(
                    id: (int)$pData['id'],
                    name: $pData['name'],
                    description: $pData['description'],
                    price: (float)$pData['price'],
                    stock: (int)$pData['stock'],
                    categoryId: (int)$pData['category_id']
                );
            }

            // 3. On range les produits DANS l'objet Catégorie
            $category->setProducts($productsObjects);
        }

        return $categories;
    }
}