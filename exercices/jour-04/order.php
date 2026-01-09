<?php
// Change cette valeur pour tester : "standby", "validated", "shipped", "delivered", "canceled"
$status = "shipped"; 

echo "<h3>Statut de la commande</h3>";


switch ($status) {
    case "standby":
        echo "<span style='color: orange'>⏳ En attente</span>";
        break; // Stop, on sort du switch

    case "validated":
        echo "<span style='color: blue'>✅ Validée</span>";
        break;

    case "shipped":
        echo "<span style='color: purple'>🚚 Expédiée</span>";
        break;
        
    case "delivered":
        echo "<span style='color: green'>🏠 Livrée</span>";
        break;

    case "canceled":
        echo "<span style='color: red'>❌ Annulée</span>";
        break;

    default: // Si rien ne correspond
        echo "❓ Statut inconnu";
}
echo "<hr>";
?>
<?php
echo "<h3>Statut de la commande (Version Match - PHP 8)</h3>";

// Regarde comme c'est plus propre :
$message = match ($status) {
    "standby"   => "<span style='color: orange'>⏳ En attente</span>",
    "validated" => "<span style='color: blue'>✅ Validée</span>",
    "shipped"   => "<span style='color: purple'>🚚 Expédiée</span>",
    "delivered" => "<span style='color: green'>🏠 Livrée</span>",
    "canceled"  => "<span style='color: red'>❌ Annulée</span>",
    default     => "❓ Statut inconnu",
};

echo $message;
?>