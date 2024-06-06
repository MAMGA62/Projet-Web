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

if(valider("date_event", "COOKIE"))
$date_event= valider("date_event", "COOKIE");
else $date_event = Null;

?>

<script>
function switchProduct(elt){
	var id = elt.value;
	document.cookie = "date_event=" + encodeURIComponent(id) + "; path=/";
	
	location.reload(true);
	return;

}
	
</script>

<div class="page-header">
	<h2>Menu</h2>
</div>


<?php

if (empty($dates = recupererEvenements())){
	echo "<h4>Aucun événement n'est prévu pour le moment...</h4><br/><hr/>";
}

$listeEvent = recupererEvenements();
if($date_event == NULL){
	$date_event = $listeEvent[0]["date_event"];
}

mkForm("controleur.php");
?>
<label for="date_event">Date :</label>
<?php
mkSelect("date_event", $listeEvent,"date_event", "name", $date_event, false, "onchange=\"switchProduct(this)\" id=date_event", "date de l'événement");
endForm();
$url = urlEvenement($date_event);

if ($url){
	echo "<img class=\"img_menu\" src=\"$url\"  alt=\"Menu de la date $date_event\" />";
}


?>


	 <!--<a href="index.php?view=edit_menu"><button>Gestion des menus</button></a>-->
	 <!--<a href="index.php?view=edit_event"><button>Gestion des événements</button></a>-->

	 <a href="index.php?view=order"><button>Commander</button></a>



          
