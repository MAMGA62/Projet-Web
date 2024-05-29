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
$id_product = $valider("id_product", "COOKIE");
else $id_product = 1;
tprint($id_product); 	
?>
<script>
function switchProduct(elt){
	var id = elt.value;
	setcookie("id_product", id, time()+5);
	
	reload(true);
	return;

}
	
</script>

<div class="page-header">
</div>

<?php
echo "<h2>Supprimer un ingredient du produit </h2>";
$listeProduit = recupererProduits();
$listeIngredient = recupererIngredient();

mkForm("controleur.php");
mkSelect("id_product", $listeProduit,"id_product", "name", false, false);
mkSelect("id_product", $listeIngredient,"id_product", "name");
mkInput("submit", "action", "Supprimer Produit");
endForm();
echo "</br></br>";

$listeContenu = recupererContenuProduit($id_product);
echo "<h2>Ajouter un ingredient au produit </h2>";
mkForm("controleur.php");
mkSelect("id_product", $listeProduit,"id_product", "name", false, false, "onchange=\"switchProduct(this)\"");
mkSelect("id_product", $listeIngredient,"id_product", "name");
mkInput("submit", "action", "Supprimer Produit");
endForm();
echo "</br></br>";

?>

<a href="index.php?view=edit_product"><button>Gerer les produits</button></a>
<a href="index.php?view=stock"><button>Valider les modifications</button></a>