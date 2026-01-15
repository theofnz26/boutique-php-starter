<?php
// Force l'affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



class BankAccount
{
    //1. PROPRIÉTÉ PRIVÉE
    // 'private' signifie : Accessible UNIQUEMENT depuis l'intérieur de cette classe.
    // Impossible de faire $account->balance depuis l'extérieur.
    private float $balance;

    //2. CONSTRUCTEUR
    public function __construct(float $initialBalance = 0)
    {
        // On protège dès la création : pas de solde négatif au départ
        if ($initialBalance < 0) {
            $this->balance = 0;
        } else {
            $this->balance = $initialBalance;
        }
    }

    //3. MÉTHODES

    // Getter : Permet de VOIR le solde, mais pas de le toucher
    public function getBalance(): float
    {
        return $this->balance;
    }

    // Déposer de l'argent
    public function deposit(float $amount): void
    {
        // Règle de sécurité : On ne peut pas déposer un montant négatif
        if ($amount > 0) {
            $this->balance += $amount;
            echo "✅ Dépôt de $amount €. Nouveau solde : $this->balance €<br>";
        } else {
            echo "❌ Erreur : Montant invalide pour le dépôt.<br>";
        }
    }

    // Retirer de l'argent
    public function withdraw(float $amount): void
    {
        // Règle 1 : Montant positif
        if ($amount <= 0) {
            echo "❌ Erreur : Montant invalide.<br>";
            return; // On arrête la fonction ici
        }

        // Règle 2 : On ne peut pas retirer plus que ce qu'on a (Pas de découvert)
        if ($amount > $this->balance) {
            echo "⚠️ Retrait refusé : Fonds insuffisants (Vous avez $this->balance €).<br>";
        } else {
            $this->balance -= $amount;
            echo "💸 Retrait de $amount €. Nouveau solde : $this->balance €<br>";
        }
    }
}

//TESTS

$account = new BankAccount(100); // On ouvre un compte avec 100€

echo "Solde initial : " . $account->getBalance() . " €<br><hr>";

// Test 1 : Dépôt valide
$account->deposit(50); // Solde passe à 150

// Test 2 : Tentative de triche (Dépôt négatif)
$account->deposit(-2000); // Doit échouer

// Test 3 : Retrait valide
$account->withdraw(30); // Solde passe à 120

// Test 4 : Retrait trop gros (Fonds insuffisants)
$account->withdraw(500); // Doit échouer

echo "<hr>Solde final : " . $account->getBalance() . " €";



// La ligne interdite 
$account->balance = 1000000; 

echo "<h1 style='color:red; font-size:50px;'>SI TU VOIS CE TEXTE, ALORS TU AS RAISON !</h1>";