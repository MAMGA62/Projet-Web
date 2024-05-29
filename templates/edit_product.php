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
echo "<h2>Supprimer un produit </h2>";
$listeProduit = recupererProduits();
mkForm("controleur.php");
mkSelect("id_product", $listeProduit,"id_product", "name");
mkInput("submit", "action", "Supprimer Produit");
endForm();
echo "</br></br>";

echo "<h2>Créer un produit </h2>";
mkForm("controleur.php");
mkInput("text", "name", "", "placeHolder=\"Nom du produit à ajouter\"");
mkInput("number", "price", "", "placeHolder=\"Prix\"  step=\"0.5\"");
mkInput("submit", "action", "Creer Produit");
endForm();
echo "</br></br>";


?>

<a href="index.php?view=stock"><button>Valider les modifications</button></a>

