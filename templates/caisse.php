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
$date_event = date('Y-m-d');

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
echo "<h2>Valider une commande </h2>";
$listeCommande = recupererCommandeNonValide($date_event);

if($id_order==Null && count($listeCommande)> 0){
	$id_order = $listeCommande[0]["id_order"];
	
}
elseif (count($listeCommande)== 0) {echo "Aucune commande"; $id_order = Null;}
mkForm("controleur.php");
mkSelect("id_order", $listeCommande,"id_order", "email");
if($id_order !==NUll ){
	$content = recupererContenuCommande($id_order);
	$user = recupererUserCommande($id_order)[0];
	echo $user["first_name"] . " " . $user["surname"];
	foreach($content as $elt){
		
		echo " " . $elt["name"] .": ".$elt["quantity"];
	}
	
	
	}
	echo "</br>";
mkInput("submit", "action", "Valider commande");
endForm();
echo "</br></br>";

?>

<a href="index.php?view=accueil"><button>Retourner à l'accueil</button></a>

