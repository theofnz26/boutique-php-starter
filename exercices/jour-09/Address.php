<?php

class Address
{
    public function __construct(
        public string $rue,
        public string $codePostal,
        public string $ville,
        public string $pays
    ) {}

    // Une petite méthode pour afficher l'adresse joliment
    public function getFullAddress(): string
    {
        return "$this->rue, $this->codePostal $this->ville ($this->pays)";
    }
}