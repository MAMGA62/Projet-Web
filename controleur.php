<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$addArgs = "";

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		
		switch($action)
		{
			
			
			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, 
					// et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					if (verifUser($login,$passe)) {
						// tout s'est bien passé, doit-on se souvenir de la personne ? 
						if (valider("remember")) {
							setcookie("login",$login , time()+60*60*24*30);
							setcookie("passe",$password, time()+60*60*24*30);
							setcookie("remember",true, time()+60*60*24*30);
						} else {
							setcookie("login","", time()-3600);
							setcookie("passe","", time()-3600);
							setcookie("remember",false, time()-3600);
						}

					}	
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Logout' :
                session_destroy();
                $addArgs = "?view=accueil";
            break;

            case 'Signin';
                $first_name = valider("first_name");
                $surname = valider("surname");
                $email = valider("email");
                $pass = valider("pass");
                $confirm_pass = valider("confirm_pass");
                if($pass == $confirm_pass){
                    creerUtilisateur($email, $first_name, $surname, $pass);
                }
                else{
                    //TODO: message d'erreur
                }
            break;


			case "Ajouter Produit" :
				if ($id_product = valider("id_product"))
				if ($id_menu = valider("id_menu"))
				if($quantity = valider("quantity"))
				{
				if($quantity < 0)$quantity = 0;
				ajouterContenuMenu($id_menu, $id_product, $quantity);
				$addArgs .= "?view=edit_menu";
				
				}
				break;
				case "Creer Menu" :
				if ($name = valider("name"))
				if($price = valider("price"))
				{
				if($price < 0)$price = 0;
				ajouterMenu($name, $price);
				$addArgs .= "?view=edit_menu";
				
				
				}
				
				break;
				
				case "Supprimer Menu" :
				if ($id_menu = valider("id_menu"))
				{
				supprimerMenu($id_menu);
				$addArgs .= "?view=edit_menu";
				
				
				}
				
				break;
				
				
				
			case "Modifier Event" :
				if ($date_event = valider("date_event"))
				if ($id_menu = valider("id_menu"))
				if($url = valider("url"))
				if($name = valider("name")){
					clearEvent($date_event);
					foreach($id_menu as $elt){
						echo $elt;
						ajouterMenuEvent($elt, $date_event);
					}
					
					//modifierEvent($date_event,$name,$url);
					$addArgs .= "?view=edit_event";
				
				}
				
				break;


			case "Creer Event" :
				if ($name = valider("name"))
				if ($date_event = valider("date_event"))
				if($url = valider("url")){
					echo $date_event;
					ajouterEvenement($name, $date_event, $url);
					$addArgs .= "?view=edit_event";
				}
				
				break;
				
			case "Supprimer Event":
				if ($date_event = valider("date_event")){
				supprimerEvenement($date_event);
				$addArgs .= "?view=edit_event";
				
				}
				
				break;
			case "Creer Ingredient" :
					if ($name = valider("name"))
					if ($quantity = valider("quantity")){
						if($quantity = 0)$quantity = 0;
						ajouterIngredient($name, $quantity);
						$addArgs .= "?view=edit_stock";
					}
					
					break;
					
				case "Supprimer Ingredient":
					if ($id_product = valider("id_product")){
					supprimerIngredient($id_product);
					$addArgs .= "?view=edit_stock";
					
					}
					
					break;
					case "Modifier Stock":
						if ($id_product = valider("id_product"))
						if(($quantity = valider("quantity"))!==false)
						{
						modifierStock($id_product, $quantity);
						$addArgs .= "?view=edit_stock";
						
						}
						
						break;


				case "Creer Produit" :
					if ($name = valider("name"))
					if ($price = valider("price")){
						if($price = 0)$price = 0;
						ajouterProduit($name, $price);
						$addArgs .= "?view=edit_product";
					}
					
					break;
					
				case "Supprimer Produit":
					if ($id_product = valider("id_product")){
					supprimerProduit($id_product);
					$addArgs .= "?view=edit_product";
					
					}
					
					break;
					case "Ajouter Contenu Produit" :
						if ($id_product = valider("id_product"))
						if($quantity = valider("quantity"))
						if ($id_ingredient = valider("id_ingredient")){
							if($quantity<0)$quantity = 0;
							ajouterIngredientProduit($id_product, $id_ingredient, $quantity);
							$addArgs .= "?view=edit_product_content";
						}
						
						break;
						
					case "Supprimer Contenu Produit":
						if ($id_product = valider("id_product"))
						if ($id_ingredient = valider("id_ingredient")){

							supprimerIngredientProduit($id_product, $id_ingredient);
						$addArgs .= "?view=edit_product_content";
						
						}
						
						break;

		
			case "Order":
				
				if (valider("connecte", "SESSION")){

					$date_event = valider("date_event");
					$id_menu = valider("id_menu");
					$id_content = valider("id_content");
					$id_drink = valider("id_drink");
					$id_dessert = valider("id_dessert");

					if (verifOrder($date_event, $id_menu, $id_content, $id_drink, $id_dessert)){
						$addArgs = "?view=panier";
					} else {
						$addArgs = "?view=order";
					}

				}

				break;
				
			case 'Promouvoir' : 				
				if ($email = valider("email"))
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["email"])) 
				if (is_array($email)) {
					foreach($email as $nextEmail) {
						modifierUser($nextEmail, 1, 0); 
					}
				}  
				else {
					modifierUser($email, 1, 0);
				} 
				$addArgs = "?view=gestion_user"; 
			break;

			case 'Retrograder' : 				
				if ($email = valider("email"))
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["email"])) 
				if (is_array($email)) {
					foreach($email as $nextEmail) {
						modifierUser($nextEmail, 0, 0); 
					}
				}  
				else {
					modifierUser($email, 0, 0);
				} 
				$addArgs = "?view=gestion_user"; 
			break;
			

			case 'Autoriser' : 				
				if ($email = valider("email"))
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["email"])) 
				if (is_array($email)) {
					foreach($email as $nextEmail) {
						modifierUser($nextEmail, 0, 0); 
					}
				}  
				else {
					modifierUser($email, 0, 0);
				} 
				$addArgs = "?view=gestion_user"; 
			break;

			case 'Interdire' :  
				if ($email = valider("email"))
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["email"])) 
				if (is_array($email)) {
					foreach($email as $nextEmail) {
						modifierUser($nextEmail, 0, 1); 
					}
				}  
				else {
					modifierUser($email, 0, 1);
				} 
				$addArgs = "?view=gestion_user"; 
			break;

			case 'Supprimer' :  
				if ($email = valider("email"))
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["email"])) 
				if (is_array($email)) {
					foreach($email as $nextEmail) {
						supprimerUser($nextEmail); 
					}
				}  
				else {
					supprimerUser($email);
				} 
				$addArgs = "?view=gestion_user";
			break;


		}

	}

	

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";

	header("Location:" . $urlBase . $addArgs);

	ob_end_flush();
	
?>










