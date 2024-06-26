<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
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
					// Cf. maLibSecurisation$
					$login = htmlentities($login);
					$passe = htmlentities($passe);

					if (verifUser($login,$passe) && !isBanned($login)) {
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
					else {
						if(isBanned($login)){
							$msg = "Vous avez été banni... Contactez un administrateur pour plus d'informations.";
						} 
						else {
							$msg = "Adresse email ou mot de passe invalide...";
						}
						$addArgs = "?view=login&msg=" . urlencode($msg);
					}
					}
				

				// On redirigera vers la page index automatiquement
			break;

			case 'Logout' :
                session_destroy();
                $addArgs = "?view=accueil";
            break;

            case 'Signin';
                if (($first_name = htmlentities(valider("first_name")))
				&&	($surname = htmlentities(valider("surname")))
				&&	($email = htmlentities(valider("email")))
				&&	($pass = htmlentities(valider("pass")))
				&&	($confirm_pass = htmlentities(valider("confirm_pass")))){
					tprint($first_name);

					if($pass == $confirm_pass){

						if (isUserInBdd($email) !== false){
							$msg = "Un compte possède déjà cette adresse email...";
							$addArgs = "?view=signin&msg=" . urlencode($msg);
						}

						creerUtilisateur($email, $first_name, $surname, $pass);
						$urlBase = dirname($_SERVER["PHP_SELF"]) . "/controleur.php";
						$addArgs = "?action=Connexion&login=" . urlencode($email) . "&passe=" . urlencode($pass);


					} else {
						//TODO: message d'erreur
						$msg = "Les mots de passes ne correspondent pas...";
						$addArgs = "?view=signin&msg=" . urlencode($msg);
					}

				} else {
					$msg = "Les informations entrées sont incorrectes... Renseignez bien tous les champs !";
					$addArgs = "?view=signin&msg=" . urlencode($msg);
				}


            break;


			case "Ajouter Produit" :
				if ($id_product = valider("id_product"))
				if ($id_menu = valider("id_menu"))
				if($quantity = valider("quantity"))
				{
				if($quantity < 0)$quantity = 1;
				ajouterContenuMenu($id_menu, $id_product, $quantity);
				$addArgs .= "?view=edit_menu";
				
				}
				break;
				case "Creer Menu" :
				if ($name = htmlentities(valider("name")))
				if($price = valider("price"))
				{
				if($price < 0)$price = 1;

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
				$addArgs .= "?view=edit_event";
				if ($date_event = htmlentities(valider("date_event"))){

					$name = htmlentities(valider("name"));
					$url = htmlentities(valider("url"));

					if($id_menu = valider("id_menu")){
						clearEvenement($date_event);

					foreach($id_menu as $elt){
						echo $elt;
						ajouterMenuEvenement($elt, $date_event);
					}}
					
					modifierEvenement($date_event,$name,$url);
				
				} else {
					$msg = "Veuillez renseigner tous les champs";
					$addArgs .= "&msg=" . urlencode($msg);
				}
				
				break;


			case "Creer Event" :
				$addArgs .= "?view=edit_event";
				if (($name = htmlentities(valider("name")))
				&&	($date_event = htmlentities(valider("date_event")))
				&&	isValidDate($date_event)){
					$url = htmlentities(valider("url"));
					//echo $date_event;
					ajouterEvenement($name, $date_event, $url);
					
				} else {
					$msg = "Erreur lors de la création de l'événement...";
					$addArgs .= "&msg=" . urlencode($msg);
				}
				
				break;
				
			case "Supprimer Event":
				$addArgs .= "?view=edit_event";
				if ($date_event = htmlentities(valider("date_event"))){
				supprimerEvenement($date_event);
				
				} else {
					$msg = "Erreur lors de la suppression de l'événement...";
					$addArgs .= "&msg=" . urlencode($msg);
				}
				
				break;
			case "Creer Ingredient" :
					$addArgs .= "?view=edit_stock";
					if (($name = htmlentities(valider("name")))
					&&	($quantity = valider("quantity"))){
						if($quantity < 1)$quantity = 1;
						ajouterIngredient($name, $quantity);
					} else {

					$msg = "Veuillez renseigner tous les champs";
					$addArgs .= "&msg=" . urlencode($msg);

					}
					
					break;
					
				case "Supprimer Ingredient":
					$addArgs .= "?view=edit_stock";
					if ($id_product = valider("id_product")){
					supprimerIngredient($id_product);
					
					} else {

					$msg = "Veuillez renseigner tous les champs";
					$addArgs .= "&msg=" . urlencode($msg);
					}

					break;

					case "Modifier Stock":
						$addArgs .= "?view=edit_stock";
						if ($id_product = valider("id_product"))
						if(($quantity = valider("quantity"))!==false)
						{
						if($quantity < 0)$quantity = 0;
						modifierStock($id_product, $quantity);
						
						} else {

						$msg = "Veuillez renseigner tous les champs";
						$addArgs .= "&msg=" . urlencode($msg);
						}
						break;


				case "Creer Produit" :
					$addArgs .= "?view=edit_product";
					if ($name = htmlentities(valider("name")))
					if ($price = valider("price")){
						if($price < 0)$price = 1;
						ajouterProduit($name, $price);
					} else {
					
					$msg = "Veuillez renseigner tous les champs";
					$addArgs .= "&msg=" . urlencode($msg);
					
					}
					break;
					
				case "Supprimer Produit":
					$addArgs .= "?view=edit_product";

					if ($id_product = valider("id_product")){
					supprimerProduit($id_product);
					
					} else {

					$msg = "Veuillez renseigner tous les champs";
					$addArgs .= "&msg=" . urlencode($msg);
					}
					
					break;

					case "Ajouter Contenu Produit" :
						$addArgs .= "?view=edit_product_content";
						if ($id_product = valider("id_product"))
						if($quantity = valider("quantity"))
						if ($id_ingredient = valider("id_ingredient")){
							if($quantity<1)$quantity = 1;
							ajouterIngredientProduit($id_product, $id_ingredient, $quantity);
						} else {

						$msg = "Veuillez renseigner tous les champs";
						$addArgs .= "&msg=" . urlencode($msg);
						}
						break;
						
					case "Supprimer Contenu Produit":

						$addArgs .= "?view=edit_product_content";

						if ($id_product = valider("id_product"))
						if ($id_ingredient = valider("id_ingredient")){

							supprimerIngredientProduit($id_product, $id_ingredient);
						
						} else {

						$msg = "Veuillez renseigner tous les champs";
						$addArgs .= "&msg=" . urlencode($msg);
						}
						break;

		
			case "Order":
				
				if (valider("connecte", "SESSION")){

					$date_event = htmlentities(valider("date_event"));
					$id_menu = valider("id_menu");
					$id_content = valider("id_content");
					$id_drink = valider("id_drink");
					$id_dessert = valider("id_dessert");
					$id_total = valider("total");

					if ($id_total === false){
						$id_total = recupererPrix($id_menu);
					}

					if (verifOrder($date_event, $id_menu, $id_content, $id_drink, $id_dessert)){
						// tprint($date_event);
						$id_order = ajouterCommande($_SESSION["email"], $date_event, $id_total);

						if ($id_content !== false){
							commanderProduit($id_order, $id_content, recupererQuantiteProduitMenu($id_menu, $id_content));
						}
						
						if ($id_drink !== false){
							commanderProduit($id_order, $id_drink, recupererQuantiteProduitMenu($id_menu, $id_drink));
						}

						if ($id_dessert !== false){
							commanderProduit($id_order, $id_dessert, recupererQuantiteProduitMenu($id_menu, $id_dessert));
						}
						
						$addArgs = "?view=panier";
					} else {
						$addArgs = "?view=order";
						$msg = "Erreur lors de la création de la commande...";
						$addArgs .= "&msg=" . urlencode($msg);
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

			case 'Valider commande':
                if($id_order = valider("id_order")){
                    validerCommande($id_order);
                    $addArgs = "?view=caisse";
                }
				break;
			
			case 'Annuler commande':
                if($id_order = valider("id_order"))
                    if(isCancelable($id_order))
					if($email = valider("email"))
                    {
                        annulerCommande($id_order, $email);
                        $addArgs = "?view=panier";
                    }
				break;


		}

	}

	header("Location:" . $urlBase . $addArgs);

	ob_end_flush();
	
?>










