<?php

class Category
{
    // On prépare un tableau pour stocker les produits liés à cette catégorie
    private array $products = [];

    public function __construct(
        private ?int $id,
        private string $nom
    ) {}

    // --- GETTERS ---
    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    
    // Pour lire les produits qu'on a rangés dedans
    public function getProducts(): array { return $this->products; }

    // --- SETTERS ---
    public function setNom(string $nom): void { $this->nom = $nom; }
    
    // Pour remplir le sac à dos de produits
    public function setProducts(array $products): void { $this->products = $products; }
    
    // Pour ajouter un seul produit au sac
    public function addProduct(Product $product): void {
        $this->products[] = $product;
    }
}