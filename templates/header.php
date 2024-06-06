<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>2i'Cafet</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

	<!-- Liaisons aux fichiers css de Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" />
	<link href="css/sticky-footer.css" rel="stylesheet" />

	<link rel="icon" href="ressources/icon.ico" />
	
	<link href="css/styles.css" rel="stylesheet"/>
	<!--[if lt IE 9]>
	  <script src="js/html5shiv.js"></script>
	  <script src="js/respond.min.js"></script>
	<![endif]-->

	<script src="js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	

</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

<!-- style inspiré de http://www.bootstrapzero.com/bootstrap-template/sticky-footer --> 

<!-- Wrap all page content here -->
<div id="wrap">
  
  <!-- Fixed navbar -->
  <div class="navbar navbar-default navbar-fixed-top" style="background-color: #4d4d4d; background-image: none;">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
        </button>
	<a class="navbar-brand" href="index.php?view=accueil"></a>
      </div>
	  <div class="header">
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
         	<!-- <li class="active"><a href="index.php?view=accueil">Accueil</a></li> -->
		<?php

		// Si l'utilisateur n'est pas connecte, on affiche un lien de connexion

		if ($view == "accueil"){
			echo mkHeadLink("<img src=\"ressources/home.png\" width=\"24\"/>", "accueil", $view, "", "style=\"padding:8px;\"");
		} else {
			echo mkHeadLink("<img src=\"ressources/home_white.png\" width=\"24\"/>", "accueil", $view, "", "style=\"padding:8px;\"");
		}
		



		if (!valider("connecte","SESSION")){

			if ($view != "login"
			&&	$view != "signin"
			&&	$view != "accueil"){
				header("Location:index.php?view=login&msg=" . urlencode("Vous n'êtes pas connecté !"));
				die();
			}

			echo mkHeadLink("Se connecter","login",$view);
		
		} else {
			if(isAdmin($_SESSION["email"])){
                echo mkHeadLink("Stock","stock",$view);
                echo mkHeadLink("Gestion des utilisateurs","gestion_user",$view);
				echo mkHeadLink("Gestion des événements", "edit_event",$view);
				echo mkHeadLink("Gestion des menus", "edit_menu",$view);
                echo mkHeadLink("Caisse","caisse",$view);

            }
			echo mkHeadLink("Menu", "menu",$view); 
			echo mkHeadLink("Commander","order",$view); 

			echo mkHeadLink("Mon panier","panier",$view);

			echo "<li> <a href=\"controleur.php?action=Logout\" style=\"color: white;\">Se déconnecter</a></li>";
		} 

			//echo "<li><a href=\"index.php?view=login\">Se connecter</a></li>";
		?>
		
        </ul>
      </div><!--/.nav-collapse -->
    </div>
		</div>
  </div>
  


  <!-- Begin page content -->
  <div class="container">

<?php
	$msg = valider("msg", "GET");
	include("templates/messages.php");
?>








