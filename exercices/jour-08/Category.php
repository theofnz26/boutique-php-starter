<?php

class Category
{
    // 1. PROPRIÉTÉS & CONSTRUCTEUR
    // On utilise la "promotion" PHP 8 pour déclarer et remplir en même temps
    public function __construct(
        public int $id,
        public string $nom,
        public string $description
    ) {
    }

    // 2. MÉTHODE
    // Transforme "Jeux Vidéo" en "jeux-video"
    public function getSlug(): string
    {
        // Étape 1 : Tout mettre en minuscules
        $text = strtolower($this->nom);

        // Étape 2 : Remplacer les espaces par des tirets
        // str_replace(ce_que_je_cherche, ce_par_quoi_je_remplace, la_phrase)
        $slug = str_replace(' ', '-', $text);

        return $slug;
    }
}

// --- 3. TESTS (Crée 3 catégories et affiche leurs slugs) ---

// Création
$cat1 = new Category(1, "Cartes Rares", "Les cartes qui brillent");
$cat2 = new Category(2, "Accessoires de Jeu", "Tapis, dés et pochettes");
$cat3 = new Category(3, "Editions Limitees", "Seulement pour les collectionneurs");

// Affichage
echo "<h2>Test des Slugs :</h2>";

echo "Nom : " . $cat1->nom . " 👉 Slug : <strong>" . $cat1->getSlug() . "</strong><br>";
echo "Nom : " . $cat2->nom . " 👉 Slug : <strong>" . $cat2->getSlug() . "</strong><br>";
echo "Nom : " . $cat3->nom . " 👉 Slug : <strong>" . $cat3->getSlug() . "</strong><br>";