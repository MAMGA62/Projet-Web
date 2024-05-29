<!DOCTYPE html>
<html>
<head>
    <title>Incorporer test.php avec une iframe</title>
</head>
<body>

<?php 
include_once("../libs/modele.php");
$listeIngredient = recupererIngredient();
foreach($listeIngredient as $elt){
    $color = "black";
    if($elt["quantity"] == 0)$color="red";
    echo "<p> <font color=$color> Nom: " . $elt["name"] . " Stock: ". $elt["quantity"]. "</font></p>";
}




?>

</body>
</html>