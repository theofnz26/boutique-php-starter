<?php

require_once 'CartItem.php';

class Cart
{
    private array $items = [];

  
    public function add(Product $product, int $quantity = 1): self
    {
        $newItem = new CartItem($product, $quantity);
        $this->items[] = $newItem;

      
        return $this;
    }

    
    public function remove(int $productId): self
    {
        foreach ($this->items as $key => $item) {
            if ($item->product->id === $productId) {
                unset($this->items[$key]);
                break; 
            }
        }
        $this->items = array_values($this->items);

        
        return $this;
    }

    
    public function update(int $productId, int $quantity): self
    {
        foreach ($this->items as $item) {
            if ($item->product->id === $productId) {
                $item->quantity = $quantity;
                break;
            }
        }
        
        return $this;
    }

    
    public function clear(): self
    {
        $this->items = [];
        
        return $this;
    }



    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}