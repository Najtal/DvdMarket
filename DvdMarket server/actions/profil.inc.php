<?php

$liste = "";


if ( (isset($_GET['id']) && isset($_SESSION['connexion']) && $_GET['id'] == $_SESSION['id']) || (isset($_SESSION['connexion']) && !isset($_GET['id'])))  {
	$tab_info = array();
	$note = get_note_generale($_SESSION['id']);
	$tab_info = info_profil($_SESSION['id']);

	$tab_info_profil_html = tab_profil($tab_info, $tab_etat, $note);
	
} elseif (isset($_GET['id'])) {
	
	$tab_info = array();
	$note = get_note_generale($_GET['id']);

	$tab_info = info_profil($_GET['id']);
	$tab_info_ventes = tab_mes_ventes($_GET['id']);
	$tab_info_profil_html = tab_vue_profil($tab_info, $tab_etat, $note);
	$titre = "Ventes de ".get_pseudo($_GET['id']);
	/*if (sizeof($tab_info_ventes) <> 0)
		$liste = tab_mes_ventes_html($tab_info_ventes, $titre, $_SESSION['style']);
	else
		$liste = get_pseudo($_GET['id'])." n'a encore vendu aucun produits";
	*/
	
} else {
	header("Location: index.php"); 
}


# --------------------
# Vue : Page de d&eacute;tail de produit
# --------------------
require(CHEMIN_VUES .'profil.inc.php');
?>