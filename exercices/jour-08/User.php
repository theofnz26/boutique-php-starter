<?php

class User
{
    // Propriétés
    public string $name;
    public string $email;
    public DateTime $registrationDate; // Typage fort : ce DOIT être un objet DateTime

    // --- LE CONSTRUCTEUR ---
    // Il s'exécute dès qu'on fait "new User(...)"
    // ?string signifie que la date peut être une chaîne OU null
    public function __construct(string $name, string $email, ?string $dateString = null)
    {
        $this->name = $name;
        $this->email = $email;

        // Logique pour la date :
        if ($dateString) {
            // Si une date est fournie (ex: "2020-05-01"), on crée un DateTime avec
            $this->registrationDate = new DateTime($dateString);
        } else {
            // Sinon, on crée un DateTime vide = Maintenant (Date du jour)
            $this->registrationDate = new DateTime();
        }
    }

    // --- MÉTHODE ---
    // Retourne VRAI si inscrit depuis moins de 30 jours
    public function isNewMember(): bool
    {
        $today = new DateTime(); // Date d'aujourd'hui
        
        // On calcule la différence ($interval) entre la date d'inscription et aujourd'hui
        $interval = $this->registrationDate->diff($today);

        // $interval->days nous donne le nombre de jours de différence
        return $interval->days < 30;
    }
}

// --- TESTS ---

// Cas 1 : Un ancien (Date précise)
// On passe les arguments directement dans les parenthèses grâce au constructeur
$user1 = new User("Alice", "alice@gmail.com", "2020-01-01");

// Cas 2 : Un nouveau (Pas de date fournie -> Donc date du jour par défaut)
$user2 = new User("Bob", "bob@gmail.com");

echo "Alice (Inscrite le " . $user1->registrationDate->format('d/m/Y') . ") : ";
echo $user1->isNewMember() ? "Nouveau membre" : "Ancien membre";
echo "<br>";

echo "Bob (Inscrit le " . $user2->registrationDate->format('d/m/Y') . ") : ";
echo $user2->isNewMember() ? "Nouveau membre" : "Ancien membre";