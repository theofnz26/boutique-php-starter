<?php
// Ta liste s'appelle $prenoms
$prenoms = ["Theo", "Romain", "Dylan", "Ayoub", "Anthony"];
?>

<ul>
    <?php
    $i = 1;

   
    // On lit : Pour chaque élément du tableau $prenoms, on l'appelle $prenom
    foreach ($prenoms as $prenom) {

        echo "<li>" . $i . ". " . $prenom . "</li>";

        $i++; 
    }
    ?>
</ul>