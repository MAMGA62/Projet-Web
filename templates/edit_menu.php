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
echo "<h2>Supprimer un menu </h2>";
$listeMenus = recupererMenus();
mkForm("controleur.php");
mkSelect("id_menu", $listeMenus,"id_menu", "name");
mkInput("submit", "action", "Supprimer Menu");
endForm();
echo "</br></br>";

echo "<h2>Créer un menu </h2>";
mkForm("controleur.php");
mkInput("text", "name", "", "placeHolder=\"Nom du menu à ajouter\"");
mkInput("number", "price", "", "placeHolder=\"Prix\"  step=\"0.5\"");
mkInput("submit", "action", "Creer Menu");
endForm();
echo "</br></br>";

$listeProduit = recupererProduits();
echo "<h2>Ajouter un produit </h2>";
mkForm("controleur.php");
mkSelect("id_menu", $listeMenus,"id_menu", "name");
mkSelect("id_product", $listeProduit,"id_product", "name");
mkInput("number", "quantity", "", "placeHolder=\"Quantité\"  step=\"1\"");
mkInput("submit", "action", "Ajouter Produit");
endForm();
?>

<a href="index.php?view=menu"><button>Valider les modifications</button></a>

