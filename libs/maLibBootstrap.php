<?php


/*
Ce fichier définit diverses fonctions permettant de faciliter la production de mises en formes complexes
Il est utilisé en conjonction avec le style de bootstrap et insère des classes bootstrap
*/

function mkHeadLink($label,$view,$currentView="",$class="", $attrs="")
{
	// fabrique un lien pour l'entête en insèrant la classe 'active' si view = currentView

	// EX: <?=mkHeadLink("Accueil","accueil",$view)
	// produit <li class="active"><a href="index.php?view=accueil">Accueil</a></li> si $view= accueil

	$sup = "";

	if ($view == $currentView){
		$class .= " active";
	} else {
		$sup = "style=\"color: white;\"";
	}
	return "<li class=\"$class\"><a $attrs href=\"index.php?view=$view\" $sup>$label</a></li>";
}

?>
