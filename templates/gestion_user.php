<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "gestion_user.php")
{
	header("Location:../index.php?view=users");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint
include_once("libs/maLibForms.php"); 
// définit mkTable

// Interface de gestion des utilisateurs 
// Cette interface ne doit pas etre offerte aux utilisateurs non connectés

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

} else {

// la partie administration ne doit pas etre offerte aux utilisateurs connectés qui ne sont pas administrateurs

// Côté serveur, les opérations d'administration ne doivent pas etre déclenchées si l'utilisateur n'est pas administrateur  
?>

<div class="page-header">
      <h2>Administration des utilisateurs</h2>
    </div>

    <p class="lead"> 

			<h3>Liste des utilisateurs</h3>
			<?php
			echo "<h4>Liste des utilisateurs autorisés :</h4>"; 
			$users = listerUtilisateurs("nbl");
			// tprint($users);	// préférer un appel à 
			echo "<div style=\"display:flex; justify-content:center;\">";
			mkTable($users,array("email","surname", "first_name", "admin"));
			echo "</div>";

			echo "<hr/>";
			echo "<h4>Liste des utilisateurs non autorisés :</h4>"; 
			$users = listerUtilisateurs("bl");
			//tprint($users);	// préférer un appel à mkTable($users);
			echo "<div style=\"display:flex; justify-content:center;\">";
			mkTable($users,array("email","surname", "first_name", "admin"));
			echo "</div>";
			?>
			<hr />
			
<?php
// la partie administration ne doit pas etre offerte aux utilisateurs connectés qui ne sont pas administrateurs
		
//if (valider("isAdmin","SESSION")) {
if (isAdmin($_SESSION["email"])) {
?>			
			<h3>Gestion des utilisateurs</h3>
			
			
<?php
			mkForm("controleur.php");
			mkInput("hidden","entite","email");
			
			$users = listerUtilisateurs(); // produits par parcoursRs(recordset mysql)
			$lastEmail = valider("lastEmail");
			mkSelect2("email[]", $users,"email", "surname",valider("email"),"first_name",
    		"admin",
    		array("0"=>"Utilisateurs standards", "1"=>"Administrateurs"));
?>
	<div>
			<button type="submit" name="action" value="Interdire">Interdire</button>
			<button type="submit" name="action" value="Autoriser">Autoriser</button>
			<button type="submit" name="action" value="Supprimer">Supprimer</button>
			<button type="submit" name="action" value="Retrograder">Retrograder</button>
			<button type="submit" name="action" value="Promouvoir">Promouvoir</button>
	</div>
<?php				 
			endForm(); 	
			
?>


<?php
}	// fin si user est admin 
?>

</p>

<?php
} // Fin si user non connecté
?>



