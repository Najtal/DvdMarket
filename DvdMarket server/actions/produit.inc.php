<?php
#

$tab_info_produit = array();
$tab_genres = get_all_genres();
$note = "";
$msg = "";
$dated = date("Y-m-d H:i:s");

if (isset($_POST['idprodDel'])) {
	$sol = delete_prod($_POST['idprodDel']);
	if ($sol <> null)
		$msg = message_html("ok","Les ench&egrave;res de votre produit &agrave; &eacute;t&eacute; nettoy&eacute;es ! ($sol ench&egrave;res supprim&eacute;es)");
	else
		$msg = message_html("error","Aucune ench&egrave;re n'a pu &ecirc;tre supprim&eacute;e !");
	$tab_info_produit = get_produit_detail($_POST['idprodDel']);
}

if (!isset($_GET['id']) && !isset($_POST['idprodDel'])){
	header("Location: index.php"); 
	die;
} else {
	if (isset($_GET['id']))
		$id = $_GET['id'];
	if (isset($_POST['idprodDel']))
		$id = $_POST['idprodDel'];
	$tab_info_produit = get_produit_detail($id);
	$no_genre = $tab_info_produit['genre'];
}

if (isset($_POST['somme'])) {

	$chiffre = valider_chiffre($_POST['somme']);

	if (!isset($_SESSION['connexion'])){
		header("Location: index.php?action=login");	
		die;
	}
		
	if(!$chiffre){
		$msg = message_html("error","Vous devez entrer un prix correct.");
	} elseif ($chiffre < ($tab_info_produit['prix_enchere'] + 1)) {
		$msg = message_html("error","Vous devez ench&eacute;rir une valeur plus grande d'au moins 1 euro que le prix actuel.");
	}
		
	if ($msg == "") {
			encherir($id, $chiffre, $_SESSION['id']);
			$tab_info_produit = get_produit_detail($id);
	}
}

if (isset($_POST['note'])) {
		noter_produit($id, $_POST['note']);
		$msg = message_html("ok","Votre note à bien &eacute;t&eacute; enregistr&eacute;e.");
		$tab_info_produit = get_produit_detail($id);
}

if (isset($_SESSION['id']) && ($_SESSION['id'] == get_acheteur($tab_info_produit['id_produit'])) && ($tab_info_produit['date_fin'] < $dated)) {
	$note = note_produit($tab_info_produit);
}

$tab_info_encheres = tab_encheres($id);
$tab_info_produit['genre_nom'] = $tab_genres[$no_genre]['nom'];
$menus = $msg . $menus;
$description = produit_detail($tab_info_produit);
$tab_encheres_html = tab_encheres_html($tab_info_encheres);




# --------------------
# Vue : Page d'accueil
# --------------------
# Variables n&eacute;cessaires : $header, $homepage, $titre, $menu, $h2_titre, $footer
require(CHEMIN_VUES .'produit.inc.php');
?>