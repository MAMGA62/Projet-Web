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
$id_order= valider("id_order", "COOKIE");
else $id_order = Null;
?>

<script>
function switchProduct(elt){
	var id = elt.value;
	document.cookie = "id_order=" + encodeURIComponent(id) + "; path=/";
	
	location.reload(true);
	return;

}
	
</script>
<div class="page-header">
</div>

<?php
echo "<h2>Supprimer une commande </h2>";
$listeCommande = recupererCommandeUser($email);

if($id_order==Null && count($listeCommande) > 0){
	$id_order = $listeCommande[0]["id_order"];
}
else if (count($listeCommande)== 0) {echo "Aucune commande"; $id_order = Null;}
mkForm("controleur.php");
mkSelect("id_order", $listeCommande,"id_order", "name");
if($id_order !==NUll ){
$content = recupererContenuCommande($id_order);
foreach($content as $elt){
	echo $elt["name"] .": ".$elt["quantity"];
}


}
mkInput("hidden", "email", $email);
mkInput("submit", "action", "Annuler commande");
endForm();
echo "</br></br>";

echo count($listeCommande);


?>

<a href="index.php?view=accueil"><button>Retourner à l'accueil</button></a>

