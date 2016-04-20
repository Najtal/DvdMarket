<?php
#
$recherche = "";
if (isset($_GET['recherche'])) {
	$recherche = $_GET['recherche'];
}

$tableau_mem = liste_membre($recherche);

$formulaire = liste_utilisateur_html($tableau_mem,$tab_etat);

# --------------------
# Vue : Page liste des membres
# --------------------
require(CHEMIN_VUES .'a_liste_membre.inc.php');



?>