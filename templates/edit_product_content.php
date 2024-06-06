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
	
	location.reload(true);
	return;

}
	
</script>

<div class="page-header">
	<h2>Gestion du contenu des produits</h2>
</div>

<?php
echo "<h3>Supprimer un ingredient du produit </h3>";
$listeProduit = recupererProduits();
$listeIngredient = recupererContenuNonProduit($id_product);
$listeContenu = recupererContenuProduit($id_product);

mkForm("controleur.php");
mkSelect("id_product", $listeProduit,"id_product", "name", $id_product, false, "onchange=\"switchProduct(this)\"", "Produit à supprimer");
mkSelect("id_ingredient", $listeContenu,"id_product", "name");
mkInput("submit", "action", "Supprimer Contenu Produit");
endForm();
echo "</br></br>";

echo "<h3>Ajouter un ingredient au produit </h3>";
mkForm("controleur.php");
mkSelect("id_product", $listeProduit,"id_product", "name", $id_product, false, "onchange=\"switchProduct(this)\"", "Ingrédient à ajouter au produit");
mkSelect("id_ingredient", $listeIngredient,"id_product", "name");
mkInput("number", "quantity", "", "min=\"0\" max=\"9999\" placeHolder=\"Quantité\"  step=\"1\"");
mkInput("submit", "action", "Ajouter Contenu Produit");
endForm();
echo "</br></br>";

?>

<a href="index.php?view=edit_product"><button>Gerer les produits</button></a>
<a href="index.php?view=stock"><button>Valider les modifications</button></a>