<?php
$produits = [
    ["nom" => "Clavier", "prix" => 50, "stock" => 10],     // OK
    ["nom" => "Souris", "prix" => 20, "stock" => 0],       // Stock 0 -> on saute (continue)
    ["nom" => "Tapis", "prix" => 15, "stock" => 50],       // OK
    ["nom" => "Ecran 4K", "prix" => 500, "stock" => 5],    // Prix > 100 -> on arrête tout (break)
    ["nom" => "USB", "prix" => 5, "stock" => 100],         // On ne le verra jamais car on a break avant !
];

echo "<h3>Liste filtrée :</h3>";

foreach ($produits as $p) {

    // 1. CONDITION : Si le stock est égal à 0
    if ($p['stock'] == 0) {
        continue;// ... Ton code ici pour dire "Passe au suivant"
    }

    // 2. CONDITION : Si le prix est supérieur à 100
    if ($p['prix'] > 100) {
        break;// ... Ton code ici pour dire "Stop tout"
    }

    // 3. Affichage (Si on arrive ici, c'est que le produit est validé)
    echo "Je vends : " . $p['nom'] . " (" . $p['prix'] . "€) <br>";
}



// Les objets sur le tapis roulant
$bagages = [
    "Valise",
    "Sac à dos",
    "Eau",        // Interdit -> Poubelle (continue)
    "Ordi",
    "Veste",
    "Couteau",    // DANGER -> Arrêt immédiat (break)
    "Peluche",    // On ne devrait jamais voir cet objet car la machine sera arrêtée
];

echo "<h2>Démarrage du scanner...</h2>";
//exercice sur la base du fait que je suis un douanier d'aéroport
foreach ($bagages as $objet) {

    // CAS 1 : C'est du liquide ?
    if ($objet == "Eau") {
        echo "🚫 <em>Objet interdit (Liquide). On le jette.</em><br>";
        // ICI : On passe au suivant sans valider l'objet
        continue; 
    }

    // CAS 2 : C'est dangereux ?
    if ($objet == "Couteau") {
        echo "🚨 <strong>ALERTE SÉCURITÉ ! Objet dangereux trouvé !</strong><br>";
        // ICI : On arrête tout le scanner immédiatement
        break;
    }

    // CAS 3 : Tout va bien (Code qui ne s'exécute pas si on a fait continue ou break)
    echo "✅ " . $objet . " : Validé.<br>";
}

echo "<hr>Scanner éteint.";

?>