<?php

class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupérer un produit précis par son ID
     * (Ex: Donne-moi le T-shirt Blanc, ID 1)
     */
    public function find(int $id): array|false
    {
        // 1. On prépare la requête pour éviter les failles de sécurité
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        
        // 2. On remplace :id par la vraie valeur
        $stmt->execute(['id' => $id]);

        // 3. On récupère le résultat
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer TOUTE la liste
     */
    public function findAll(): array
    {
        // Pas de variable à insérer, donc query() suffit
        $stmt = $this->pdo->query("SELECT * FROM products");
        
        // fetchAll récupère toutes les lignes d'un coup
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}