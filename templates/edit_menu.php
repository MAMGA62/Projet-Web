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
	<h2>Gestion des menus</h2>
</div>

<?php
echo "<h3>Supprimer un menu </h3>";
$listeMenus = recupererMenus();
mkForm("controleur.php");
mkSelect("id_menu", $listeMenus,"id_menu", "name");
mkInput("submit", "action", "Supprimer Menu");
endForm();
echo "</br></br>";

echo "<h3>Créer un menu </h3>";
mkForm("controleur.php");
mkInput("text", "name", "", "placeHolder=\"Nom du menu à ajouter\"");
mkInput("number", "price", "", "placeHolder=\"Prix\"  step=\"0.5\"");
mkInput("submit", "action", "Creer Menu");
endForm();
echo "</br></br>";

$listeProduit = recupererProduits();
echo "<h3>Ajouter un produit </h3>";
mkForm("controleur.php");
mkSelect("id_menu", $listeMenus,"id_menu", "name");
mkSelect("id_product", $listeProduit,"id_product", "name");
mkInput("number", "quantity", "", "placeHolder=\"Quantité\"  step=\"1\"");
mkInput("submit", "action", "Ajouter Produit");
endForm();
?>

<a href="index.php?view=menu"><button>Valider les modifications</button></a>

<?php
}
?>

