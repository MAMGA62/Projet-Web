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
      if(valider("connecte", "SESSION")){
      if(!$first_name = valider("first_name", "SESSION"))
      $first_name = "Prénom";
      if(!$surname = valider("surname", "SESSION"))
      $surname = "Nom";
      echo "<h1>Bienvenue $surname $first_name !</h1>";
      echo "<h2><b>Que vas-tu commander aujourd'hui?</b></h2>";}
      else{
        echo "<h1>Bonjour, n'hésite pas à te connecter pour avoir accès à ton compte.</h1>";
        echo "<h2><b>N'hésite pas à commander le menu du jours !</b></h2>";
      }?>
    </div>

    
