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

<iframe src="templates/stock_iframe.php" width="600" height="400" frameborder="0">
        Votre navigateur ne supporte pas les iframes.
    </iframe>

<?php
echo "<h2>Supprimer un ingrédient </h2>";
$listeIngredient = recupererIngredient();
mkForm("controleur.php");
mkSelect("id_product", $listeIngredient,"id_product", "name");
mkInput("submit", "action", "Supprimer Ingredient");
endForm();
echo "</br></br>";

echo "<h2>Créer un ingrédient </h2>";
mkForm("controleur.php");
mkInput("text", "name", "", "placeHolder=\"Nom de l'ingrédient\"");
mkInput("number", "quantity", "", "placeHolder=\"Stock\"  step=\"1\"");
mkInput("submit", "action", "Creer Ingredient");
endForm();
echo "</br></br>";

$listeIngredient = recupererIngredient();
echo "<h2>Modifier un stock </h2>";
mkForm("controleur.php");
mkSelect("id_product", $listeIngredient,"id_product", "name");
mkInput("number", "quantity", "", "placeHolder=\"Quantité\"  step=\"1\"");
mkInput("submit", "action", "Modifier Stock");
endForm();
echo "</br></br>";

?>

<a href="index.php?view=stock"><button>Valider les modifications</button></a>

