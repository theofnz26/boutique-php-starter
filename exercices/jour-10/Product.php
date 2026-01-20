<?php

class Product
{
    public function __construct(
        private ?int $id = null,      // L'ID est null tant qu'on n'a pas sauvegardé en BDD
        private string $name,
        private ?string $description, // Peut être vide
        private float $price,
        private int $stock,
        private ?int $categoryId = null
    ) {}

    // --- GETTERS (Pour récupérer les infos) ---
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getStock(): int { return $this->stock; }
    public function getCategoryId(): ?int { return $this->categoryId; }
}