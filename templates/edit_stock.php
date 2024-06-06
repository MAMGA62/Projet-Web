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


if(valider("id_product", "COOKIE"))
$id_product= valider("id_product", "COOKIE");
else $id_product = 1;
?>
<script>
function switchProduct(elt){
	var id = elt.value;
	document.cookie = "id_product=" + encodeURIComponent(id) + "; path=/";
	console.log(id);
	location.reload(true);
	return;

}
	
</script>

<div class="page-header">
	<h2>Modification du stock</h2>
</div>

<iframe src="templates/stock_iframe.php" width="600" height="400" frameborder="0">
        Votre navigateur ne supporte pas les iframes.
    </iframe>

<?php
echo "<h3>Supprimer un ingrédient </h3>";
$listeIngredient = recupererIngredient();
mkForm("controleur.php");
mkSelect("id_product", $listeIngredient,"id_product", "name", false, false, "", "Ingrédient à supprimer");
mkInput("submit", "action", "Supprimer Ingredient");
endForm();
echo "</br></br>";

echo "<h3>Créer un ingrédient </h3>";
mkForm("controleur.php");
mkInput("text", "name", "", "placeHolder=\"Nom de l'ingrédient\"");
mkInput("number", "quantity", "", "min=\"0\" max=\"9999\" placeHolder=\"Stock\"  step=\"1\"");
mkInput("submit", "action", "Creer Ingredient");
endForm();
echo "</br></br>";

$listeIngredient = recupererIngredient();
$quantity = recupererQuantité($id_product);
echo "<h3>Modifier un stock </h3>";
mkForm("controleur.php");
mkSelect("id_product", $listeIngredient,"id_product", "name", $id_product, false, "onchange=\"switchProduct(this)\"", "Ingrédient à modifier");
mkInput("number", "quantity", $quantity, "min=\"0\" placeholder=\"Quantité\"");
mkInput("submit", "action", "Modifier Stock");
endForm();
echo "</br></br>";

?>

<a href="index.php?view=stock"><button>Valider les modifications</button></a>

