<?php

include_once "maLibUtils.php";	// Car on utilise la fonction valider()
include_once "modele.php";	// Car on utilise la fonction connecterUtilisateur()

/**
 * @file login.php
 * Fichier contenant des fonctions de vérification de logins
 */

/**
 * Cette fonction vérifie si le login/passe passés en paramètre sont légaux
 * Elle stocke les informations sur la personne dans des variables de session : session_start doit avoir été appelé...
 * Infos à enregistrer : pseudo, idUser, heureConnexion, isAdmin
 * Elle enregistre l'état de la connexion dans une variable de session "connecte" = true
 * @pre login et passe ne doivent pas être vides
 * @param string $login
 * @param string $password
 * @return false ou true ; un effet de bord est la création de variables de session
 */
function verifUser($login,$password)
{
    
    $email = verifUserBdd($login,$password);

    if (!$email) return false; 

    // Cas succès : on enregistre pseudo, idUser dans les variables de session 
    // il faut appeler session_start ! 
    // Le controleur le fait déjà !!
    $_SESSION["email"] = $email;
    $info = getInfoUser($_SESSION["email"]);
    $_SESSION["nom"] = getInfoUser($email)[0]["first_name"];
    $_SESSION["prenom"] = getInfoUser($email)[0]["surname"];
    $_SESSION["admin"] = isAdmin($email);
    $_SESSION["waster_score"] = getInfoUser($email)[0]["waster_score"]; 
    $_SESSION["banned"] = getInfoUser($email)[0]["banned"];
    $_SESSION["connecte"] = true;
    $_SESSION["heureConnexion"] = date("H:i:s");
    return true;
    
}


function isValidDate($date){
    $pattern = '/^\d{4}-\d{2}-\d{2}$/';

    if (preg_match($pattern, $date)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Fonction à placer au début de chaque page privée
 * Cette fonction redirige vers la page $urlBad en envoyant un message d'erreur 
	et arrête l'interprétation si l'utilisateur n'est pas connecté
 * Elle ne fait rien si l'utilisateur est connecté, et si $urlGood est faux
 * Elle redirige vers urlGood sinon
 */
function securiser($urlBad,$urlGood=false)
{
	if (! valider("connecte","SESSION")) {
		rediriger($urlBad);
		die("");
	}
	else {
		if ($urlGood)
			rediriger($urlGood);
	}
}


function verifOrder($date_event, $id_menu, $id_content, $id_drink, $id_dessert){
    //tprint($date_event);
    // tprint($e = evenementExiste($date_event));
    // tprint($id_menu);

    // $e = evenementExiste($date_event);
    // $m = isMenuInEvenement($date_event, $id_menu);
    // $c = isProduitInMenu($id_menu, $id_content, "plat");

    // tprint($m);
    // tprint(empty($m));
    // tprint($c);

    // $s = verifierStockIngredientsProduit($id_content);

    /*
    if ($e){
        tprint("evenement existe");
    } else {
        tprint("evenement existe pas");
    }

    if ($m){
        tprint("menu existe dans les events");
    } else {
        tprint("menu existe pas dans les events");
    }

    if ($c){
        tprint("content existe dans menu");
    } else {
        tprint("content existe pas dans menu");
    }

    if ($s){
        tprint("stock dispo");
    } else {
        tprint("stock pas dispo");
    }
    */

    //tprint($m);

    if (evenementExiste($date_event))
    if (isMenuInEvenement($date_event, $id_menu))
    if (isProduitInMenu($id_menu, $id_content, "plat"))
    if (isProduitInMenu($id_menu, $id_drink, "boisson"))
    if (isProduitInMenu($id_menu, $id_dessert, "dessert"))
    if (verifierStockIngredientsProduit($id_content, $id_menu))
    if (verifierStockIngredientsProduit($id_drink, $id_menu))
    if (verifierStockIngredientsProduit($id_dessert, $id_menu)){
        // tprint("Tout est bon!");
        return true;
    }

    return false;
}

?>
