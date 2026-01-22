<?php

namespace App\Entity;

// Classe Category pour une boutique e-commerce
// Propriétés : id (int), name (string), slug (string), description (?string)
// Constructeur avec promotion de propriétés PHP 8
// Méthode generateSlug() qui crée le slug à partir du name
// Getters pour toutes les propriétés
class Category
{
    public function __construct(
        private int $id,
        private string $name,
        private string $slug,
        private ?string $description = null
    ) {
    }

    public function generateSlug(): string
    {
        return strtolower(str_replace(' ', '-', $this->name));
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
