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

	 <a href="index.php?view=edit_menu"><button>Gestion des menus</button></a>
	 <a href="index.php?view=edit_event"><button>Gestion des événements</button></a>



          
