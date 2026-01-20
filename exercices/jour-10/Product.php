<?php

class Product
{
    public function __construct(
        private ?int $id = null,
        private string $name,
        private ?string $description,
        private float $price,
        private int $stock,
        private ?int $categoryId = null
    ) {}

    // --- GETTERS (Lecture) ---
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getStock(): int { return $this->stock; }
    public function getCategoryId(): ?int { return $this->categoryId; }

    // --- SETTERS (Écriture - NÉCESSAIRE pour respecter l'énoncé) ---
    // Ils permettent de modifier l'objet avant de le sauvegarder
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function setStock(int $stock): void { $this->stock = $stock; }
    public function setCategoryId(int $categoryId): void { $this->categoryId = $categoryId; }
}