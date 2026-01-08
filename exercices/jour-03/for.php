
    <?php 
for ($i = 1; $i <= 10; $i++){
    echo $i . " - ";
}
echo "<br>";
for ($i = 2; $i <= 20; $i +=2){
    echo $i . " - ";
}
echo "<br>";
for ($i = 10; $i >= 0; $i--){
    echo $i . " - ";
}
echo "<br>";

echo "Table de 7". "<br>";

for ($i = 1; $i <= 10; $i++){

    $resultat = 7 * $i;

    echo "7 x" . $i . "=" . $resultat . "<br>"; 
}
?>
