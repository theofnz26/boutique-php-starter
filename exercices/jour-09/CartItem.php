<?php

require_once 'Product.php';

class CartItem
{
    public function __construct(
        public Product $product,
        public int $quantity
    ) {}

    // Méthode 1 : Calculer le total de la ligne
    public function getTotal(): float
    {
        // Prix du produit multiplié par la quantité choisie
        return $this->product->price * $this->quantity;
    }

    // Méthode 2 : Augmenter la quantité
    public function incremente(): void
    {
        $this->quantity++;
    }

    // Méthode 3 : Diminuer la quantité
    public function decremente(): void
    {
        // On évite les quantités négatives
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
}