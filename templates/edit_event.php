<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

if ((!valider("connecte","SESSION")) || (!isAdmin($_SESSION["email"]))) {
	// header("Location:?view=login&msg=" . urlencode("Il faut vous connecter !!")); 
	// déclenche une erreur headers already sent 
	// car les entetes HTTP de réponse ont déjà envoyées
	// car la page header envoie un résultat HTML au client 
	// ET que le serveur ne bufferise pas 
	
	// On choisit de charger la vue de login
	$msg = "L'interface d'administration des utilisateurs nécessite d'être un administrateur !"; 
	header("Location:index.php?view=accueil&msg=" . urlencode($msg));
	die("");


} else {
// Chargement eventuel des données en cookies
$email = valider("email", "SESSION");
$first_name = valider("first_name", "SESSION");
$surname = valider("surname", "SESSION") ;

?>

<div class="page-header">
	<h2>Gestion des événements</h2>
</div>

<?php
echo "<h3>Supprimer un événement </h3>";
$listeEvent = recupererEvenements();
mkForm("controleur.php");
mkSelect("date_event", $listeEvent,"date_event", "name", false, false, "", "Événement à supprimer");
mkInput("submit", "action", "Supprimer Event");
endForm();
echo "</br></br>";

echo "<h3>Créer un événement </h3>";
mkForm("controleur.php");
mkInput("text", "name", "", "placeHolder=\"Nom de l'événement à créer\"");
mkInput("text", "date_event", "", "placeHolder=\"Date (YYYY-MM-DD)\"");
mkInput("text", "url", "", "placeHolder=\"Url de l'événement à ajouter\"");
mkInput("submit", "action", "Creer Event");
endForm();
echo "</br></br>";

$listeMenu = recupererMenus();
echo "<h3>Modifier un événement </h3>";
mkForm("controleur.php");
mkSelect("date_event", $listeEvent,"date_event", "name", false, false, "", "Événement à modifier");
mkSelect("id_menu[]", $listeMenu,"id_menu", "name", false, false, "", "Menus à ajouter");
mkInput("text", "name", "", "placeHolder=\"Nom\"");
mkInput("text", "url", "", "placeHolder=\"url\"");
mkInput("submit", "action", "Modifier Event");
endForm();
?>

<a href="index.php?view=menu"><button>Valider les modifications</button></a>

<?php
}
?>
