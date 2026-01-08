<?php
$age = rand(1, 100);

echo "J'ai " . $age . " ans : ";

if ($age < 18) {
    echo "Mineur";
} elseif ($age >= 18 && $age <= 25) {
    echo "Jeune Adulte";
}elseif ($age >=26 && $age <=64 ) {
    echo "Adulte";
}else echo "senior";

?>