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
echo "<h2>Supprimer un event </h2>";
$listeEvent = recupererEvenements();
mkForm("controleur.php");
mkSelect("date_event", $listeEvent,"date_event", "name");
mkInput("submit", "action", "Supprimer Event");
endForm();
echo "</br></br>";

echo "<h2>Créer un event </h2>";
mkForm("controleur.php");
mkInput("text", "name", "", "placeHolder=\"Nom de l'event à ajouter\"");
mkInput("text", "date_event", "", "placeHolder=\"Date (YYYY-MM-DD)\"");
mkInput("text", "url", "", "placeHolder=\"Url de l'event à ajouter\"");
mkInput("submit", "action", "Creer Event");
endForm();
echo "</br></br>";

$listeMenu = recupererMenus();
echo "<h2>Modifier un event </h2>";
mkForm("controleur.php");
mkSelect("date_event", $listeEvent,"date_event", "name");
mkSelect("id_menu[]", $listeMenu,"id_menu", "name");
mkInput("text", "name", "", "placeHolder=\"Nom\"");
mkInput("text", "url", "", "placeHolder=\"url\"");
mkInput("submit", "action", "Modifier Event");
endForm();
?>

<a href="index.php?view=menu"><button>Valider les modifications</button></a>

