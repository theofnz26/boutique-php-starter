<?php

class Product
{
    public function __construct(
        // CORRECTION ICI : J'ai enlevé " = null"
        // L'ID est nullable (?int) mais on doit le fournir (même si c'est null)
        private ?int $id,
        
        private string $name,
        private ?string $description,
        private float $price,
        private int $stock,
        
        // Celui-ci est à la fin, donc il a le droit d'avoir une valeur par défaut
        private ?int $categoryId = null 
    ) {}

    // --- GETTERS ---
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getStock(): int { return $this->stock; }
    public function getCategoryId(): ?int { return $this->categoryId; }

    // --- SETTERS ---
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $desc): void { $this->description = $desc; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function setStock(int $stock): void { $this->stock = $stock; }
    public function setCategoryId(int $id): void { $this->categoryId = $id; }
}