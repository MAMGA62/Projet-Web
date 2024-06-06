<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../css/styles.css"/>
</head>
<body>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("../libs/modele.php");
include_once("../libs/maLibUtils.php");
if ((!valider("connecte","SESSION")) || (!isAdmin($_SESSION["email"]))) {
	// header("Location:?view=login&msg=" . urlencode("Il faut vous connecter !!")); 
	// déclenche une erreur headers already sent 
	// car les entetes HTTP de réponse ont déjà envoyées
	// car la page header envoie un résultat HTML au client 
	// ET que le serveur ne bufferise pas 
	
	// On choisit de charger la vue de login


} else {
$listeIngredient = recupererIngredient();
?>
<table style="text-align: center; width:95%;">
    <th>Nom de l'ingrédient</th>
    <th>Quantité en stock</th>
<?php
    foreach($listeIngredient as $elt){
        $color = "black";
        if($elt["quantity"] == 0) $color="red";

?>
    <tr>
        <td style="color:<?=$color?>;"><?=$elt["name"]?></td>
        <td style="color:<?=$color?>;"><?=$elt["quantity"]?></td>
    </tr>
<?php
        //echo "<p> <font color=$color> Nom: " . $elt["name"] . " Stock: ". $elt["quantity"]. "</font></p>";
    }
?>
</table>
<?php

    }
?>

</body>
</html>
