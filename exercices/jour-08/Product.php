<?php

class Product {

    public function __construct(

        public int $id,
        public string $name,
        public string $description,
        public float $price,
        public int $stock,
        public string $category,
){}

// Calculer le prix TTC 
    public function getPriceIncludingTax(float $vat = 20): float
    {
        // Formule : Prix * (1 + Taux/100)
        // Ex: 10 * 1.20 = 12
        return $this->price * (1 + $vat / 100);
}
    public function isInStock(): bool{// verifie le stock 
        return $this->stock > 0; //retourne vrais si le stock est supp à 0 sinon faux
    }

    public function reduceStock(int $quantity): void{//fonction pour mettre à jour le stock

        $this->stock -= $quantity; // on enlève la quant vendue du stock actuel
    }

    public function applyDiscount(float $percentage): void{//fonction qui applique une promo

        $discountAmount = $this->price * ($percentage / 100);

        $this->price -= $discountAmount;

    }

}

// --- 3. TESTS (Pour vérifier que ça marche) ---

// Création d'un T-shirt à 20€ avec 10 en stock
$tshirt = new Product(1, "T-shirt Noir", "100% Coton", 20.0, 10, "Vêtements");

echo "<h2>Produit : $tshirt->name</h2>";

// Test Prix TTC
echo "Prix HT : $tshirt->price €<br>";
echo "Prix TTC (TVA 20%) : " . $tshirt->getPriceIncludingTax() . " €<br>";

// Test Stock
echo "En stock ? " . ($tshirt->isInStock() ? "OUI ✅" : "NON ❌") . "<br>";

// Test Vente
echo "<hr>📉 Un client achète 3 T-shirts...<br>";
$tshirt->reduceStock(3);
echo "Nouveau stock : $tshirt->stock <br>"; // Devrait afficher 7

// Test Promo
echo "<hr>🏷️ C'est les soldes ! -50% !<br>";
$tshirt->applyDiscount(50);
echo "Nouveau prix HT : $tshirt->price €<br>"; // Devrait afficher 10
echo "Nouveau prix TTC : " . $tshirt->getPriceIncludingTax() . " €<br>";