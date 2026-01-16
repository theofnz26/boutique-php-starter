<?php

require_once 'Address.php';

class User
{
    // On prépare le tableau pour stocker les objets Address
    private array $addresses = [];

    public function __construct(
        public string $nom,
        public string $email,
        public DateTime $dateInscription // Type natif de PHP pour les dates
    ) {}

    // 1. Ajouter une adresse
    public function addAddress(Address $address): void
    {
        $this->addresses[] = $address;
    }

    // 2. Récupérer toutes les adresses
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    // 3. Récupérer l'adresse par défaut
    // (On décide arbitrairement que la première adresse ajoutée est celle par défaut)
    // Le "?" devant Address signifie : "Retourne une Address OU null (si pas d'adresse)"
    public function getDefaultAddress(): ?Address
    {
        if (empty($this->addresses)) {
            return null; // Pas d'adresse
        }
        
        // Retourne la première du tableau (index 0)
        return $this->addresses[0];
    }
}