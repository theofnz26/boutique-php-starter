<?php

class Car
{
    // --- 1. PROPRIÉTÉS (Les caractéristiques) ---
    public string $brand;
    public string $model;
    public int $year;

    // --- 2. MÉTHODES (Les comportements) ---

    // Calcule l'âge de la voiture
    public function getAge(): int
    {
        $currentYear = date("Y"); // Année actuelle (ex: 2026)
        // $this->year signifie "L'année de CETTE voiture"
        return $currentYear - $this->year;
    }

    // Affiche les infos formatées
    public function display(): string
    {
        // On retourne une phrase en utilisant les propriétés de l'objet ($this)
        return "$this->brand $this->model (" . $this->getAge() . " ans)";
    }
}

// --- 3. UTILISATION (Hors de la classe) ---

// Création de la première voiture (Objet 1)
$car1 = new Car();
$car1->brand = "Peugeot";
$car1->model = "208";
$car1->year = 2019;

// Création de la deuxième voiture (Objet 2)
$car2 = new Car();
$car2->brand = "Tesla";
$car2->model = "Model 3";
$car2->year = 2024;

// Création de la troisième voiture (Objet 3)
$car3 = new Car();
$car3->brand = "Ford";
$car3->model = "Mustang";
$car3->year = 1968;

// Affichage
echo $car1->display() . "<br>";
echo $car2->display() . "<br>";
echo $car3->display() . "<br>";