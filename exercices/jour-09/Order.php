<?php

require_once 'User.php';
require_once 'Cart.php';

class Order
{
    // Propriétés demandées par l'énoncé
    public array $items = []; // Va contenir la liste des CartItem
    public DateTime $date;
    public string $statut;

    public function __construct(
        public int $id,
        public User $user,
        Cart $cart // On injecte le Panier pour récupérer ses articles
    ) {
        // 1. On fige les articles : on copie ce qu'il y a dans le panier vers la commande
        $this->items = $cart->getItems();
        
        // 2. On définit la date à l'instant présent
        $this->date = new DateTime();
        
        // 3. Statut par défaut
        $this->statut = "En attente de paiement";
    }

    // Méthode 1 : Calculer le total (en parcourant les items copiés)
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    // Méthode 2 : Compter les articles
    public function getItemCount(): int
    {
        return count($this->items);
    }

    // Méthode 3 : Changer le statut
    public function setStatut(string $newStatut): void
    {
        $this->statut = $newStatut;
    }
}