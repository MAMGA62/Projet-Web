<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

// Chargement eventuel des données en cookies
$email = valider("email", "SESSION");
$first_name = valider("first_name", "SESSION");
$surname = valider("surname", "SESSION") ;
$date_event = date('Y-m-d');
?>

<div class="page-header">
</div>

<?php
echo "<h2>Valider une commande </h2>";
$listeCommande = recupererCommandeNonValide($date_event);
mkForm("controleur.php");
mkSelect("id_order", $listeCommande,"id_order", "name");
mkInput("submit", "action", "Valider commande");
endForm();
echo "</br></br>";

?>

<a href="index.php?view=accueil"><button>Retourner à l'accueil</button></a>

