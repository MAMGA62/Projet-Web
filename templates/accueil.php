<?php

//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

?>


    <div class="page-header">
      <?php 
      if(valider("connecte", "SESSION")){     // Si la personne est connectée
        if(!$first_name = valider("first_name", "SESSION"))
          $first_name = "Prénom";

        if(!$surname = valider("surname", "SESSION"))
          $surname = "Nom";
      ?>

          <h1>Bienvenue <?=$surname?> <?=$first_name?> !</h1>
          <h2>Que vas-tu commander aujourd'hui?</h2>
      
      <?php
      
      } else {                                // Si la personne n'est pas connectée
      
      ?>
        <h1>Bienvenue à la cafétéria</h1>
        <h2>Vous pouvez ici réserver vos repas pour vous restaurer</h2>

        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

        <form action="controleur.php">

          <button value="test">Se Connecter</button>
          <h6>Vous êtes nouveau? <a href="index.php?view=signin">Créez un compte !</a><h6>

        </form>

      <?php
      }
      ?>
    </div>

    
