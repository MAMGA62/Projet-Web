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
?>

<div class="page-header">
</div>

<?php
echo "<h2>Supprimer une commande </h2>";
$listeCommande = recupererCommandeUser($email);

mkForm("controleur.php");
mkSelect("id_order", $listeCommande,"id_order", "name");
mkInput("submit", "action", "Supprimer commande");
endForm();
echo "</br></br>";

?>

<a href="index.php?view=accueil"><button>Retourner à l'accueil</button></a>

