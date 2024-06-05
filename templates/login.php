<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}

// Chargement eventuel des données en cookies
$login = valider("login", "COOKIE");
$passe = valider("passe", "COOKIE"); 
if ($checked = valider("remember", "COOKIE")) $checked = "checked"; 



// Si un message est présent dans la chaine de requete, on l'affiche 
if ($msg = valider("msg")) {
	$msg = '<h2 style="color:red;">' . stripslashes($msg)  . "</h2>";
}

?>

<div class="page-header">
	<h1>Connexion</h1>
</div>

<p class="lead">

 <form role="form" action="controleur.php">
  <div class="form-group">
    <label for="email">Adresse email</label>
    <input type="email" placeholder="Adresse email" maxlength="320" class="form-control" id="email" name="login" value="<?=$login?>" >
  </div>
  <div class="form-group">
    <label for="pwd">Mot de passe</label>
    <input type="password" title="Taille maximale : 30 caractères" placeholder="Mot de passe" maxlength="30" class="form-control" id="pwd" name="passe" value="<?=$passe?>">
  </div>
  <div class="checkbox">
    <label><input type="checkbox" name="remember" <?=$checked?> >Se souvenir de moi</label>
  </div>
  <button type="submit" name="action" value="Connexion">Connexion</button>
</form>

</p>
<h6>Vous êtes nouveau? <a href="index.php?view=signin">Créez un compte !</a><h6>