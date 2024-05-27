<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=signin");
	die("");
}

?>

<div class="page-header">
	<h2>Créer un compte</h2>
</div>

<p class="lead">


 <form role="form" action="controleur.php">
  <div class="form-group">
    <label for="surname">Nom</label>
    <input type="text" class="form-control" id="surname" name="surname">
  </div>
  <div class="form-group">
    <label for="first_name">Prénom</label>
    <input type="text" class="form-control" id="firs_name" name="first_name">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email">
  </div>
  <div class="form-group">
    <label for="pass">Mot de passe</label>
    <input type="password" class="form-control" id="pass" name="pass">
  </div>
    <div class="form-group">
        <label for="confirm_pass">Confirmer le mot de passe</label>
        <input type="password" class="form-control" id="confirm_pass" name="confirm_pass">
    </div>
  <button type="submit" name="action" value="Signin">Créer</button>
</form>

</p>