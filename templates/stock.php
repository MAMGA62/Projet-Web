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
}
else{
// Chargement eventuel des données en cookies
$email = valider("email", "SESSION");
$first_name = valider("first_name", "SESSION");
$surname = valider("surname", "SESSION") ;

?>

<div class="page-header">
<h2>Stock</h2>
</div>
<iframe src="templates/stock_iframe.php" width="600" height="400" frameborder="0">
        Votre navigateur ne supporte pas les iframes.
    </iframe>
	 <a href="index.php?view=edit_stock"><button>Gestionnaire de stocks</button></a>
	 <a href="index.php?view=edit_product_content"><button>Gestionnaire de produits</button></a>
<?php
}
?>
          
