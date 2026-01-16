<?php

require_once 'CartItem.php';

class Cart
{
   
    private array $items = [];

    // 1. AJOUTER
    public function add(Product $product, int $quantity): void
    {
        // On crée la ligne et on l'ajoute
        $newItem = new CartItem($product, $quantity);
        $this->items[] = $newItem;
    }

    // 2. RETIRER (Complexité : Moyenne)
    public function remove(int $productId): void
    {
        // On doit parcourir le tableau pour trouver le bon ID
        // On a besoin de la clé ($key) pour pouvoir supprimer la ligne précise
        foreach ($this->items as $key => $item) {
            
            if ($item->product->id === $productId) {
                // Trouvé ! On le supprime de la liste
                unset($this->items[$key]);
                
                // On arrête la boucle, le travail est fait
                break; 
            }
        }
        
        // Petite astuce : on réorganise les clés du tableau (0, 1, 2...)
        // sinon après un "unset", il peut y avoir des trous (0, 2, 3...)
        $this->items = array_values($this->items);
    }

    // 3. METTRE À JOUR LA QUANTITÉ (Complexité : Moyenne)
    public function update(int $productId, int $quantity): void
    {
        foreach ($this->items as $item) {
            if ($item->product->id === $productId) {
                // Trouvé ! On change juste sa quantité
                $item->quantity = $quantity;
                break;
            }
        }
    }

    // 4. TOTAL GLOBAL
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    // 5. COMPTER
    public function count(): int
    {
        return count($this->items);
    }

    // 6. VIDER
    public function clear(): void
    {
        $this->items = [];
    }

    // (Pour l'affichage)
    public function getItems(): array
    {
        return $this->items;
    }
}