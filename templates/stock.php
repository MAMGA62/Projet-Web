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
	 <a href="index.php?view=edit_stock"><button>Gestionnaire de stocks</button></a>
	 <a href="index.php?view=edit_product_content"><button>Gestionnaire de produits</button></a>

          