<?php

session_start();

# ------
# Modèle
# ------

# Requis pour les vues
require('includes/siteVariablesGlobales.inc.php');
require('includes/siteFonctionHTML.inc.php');
require('includes/siteFonctionsSQL.inc.php');
require('includes/siteFonctionMetier.inc.php');

# Constructions des éléments HTML communs à toutes les vues
$header = header_html($css_main, $css_specific ,$titre);
$menu = menu_main_html();

// Variables de menu
$tab = get_genres();

$tab_info_messages = array(0,0);
$tab_info_nb_enchere = array(0,0);
if (isset($_SESSION['connexion'])) {
	$tab_info_messages = messages_nonlu($_SESSION['id']);
	$tab_info_nb_enchere = nb_encheres_gagnees($_SESSION['id']);
}

$menus = menu_secondaire_html("erreur", "images/animation/alert.png", $tab, $tab_info_messages, $tab_info_nb_enchere);
$footer = footer_html();


# --------------------
# Contrôleur principal
# --------------------

# Quelle action est demandée par l'utilisateur dans l'URL ?
if (isset($_SESSION['connexion']) && $_SESSION['etat'] == 1 ) {
	// Pages accessibles par les membres connectés
	$actions = array('accueil', 'boutique', 'produit', 'contact', 'profil', 'modif', 'messages', 'message', 'ecrire', 'panier', 'mes_achats', 'mes_ventes', 'vendre', 'logout', 'condition_g', 'a_propos');
} elseif (isset($_SESSION['connexion']) && $_SESSION['etat'] == 2) {
	// Pages accessibles par les administrateur connectés
	$actions = array('accueil', 'boutique', 'produit', 'contact', 'profil', 'modif', 'messages', 'message', 'ecrire', 'panier', 'mes_achats', 'mes_ventes', 'vendre', 'logout', 'a_genre', 'a_liste_membre', 'condition_g', 'a_propos');
} else {
	// Pages accessibles internautes non connectés
	$actions = array('accueil', 'boutique', 'produit', 'inscription', 'connexion', 'contact', 'login', 'profil', 'condition_g','activation', 'a_propos');
}

if (isset($_GET['action']) && in_array($_GET['action'],$actions)) {

	$link = 'actions/'.$_GET['action'] . '.inc.php';

	
	switch ($_GET['action']) { 
		case 'accueil' : 	$titre_page = 'Accueil';
								$ico = 'world';
							break;
		case 'boutique' : 	$titre_page = 'Boutique';
									$ico = 'list';
									break;
		case 'produit' : 	$titre_page = 'Produit';
								$ico = 'movie';
							break;
		case 'enchere' : 	$titre_page = 'Ench&egrave;re';
									$ico = 'friend';
							break;
		case 'inscription' : $titre_page = 'Inscription';
									$ico = 'friend';
							break;
		case 'contact' : 	$titre_page = 'Contact';
									$ico = 'mail';
							break;
		case 'login' : 		$titre_page = 'Login';
									$ico = 'lock';
							break;
		case 'activation' :	$titre_page = 'Login';
								$ico = 'lock';
							break;
		case 'profil' : 	$titre_page = 'Mon profil';
								$ico = 'info';
							break;
		case 'modif' : 	$titre_page = 'Mon profil : option';
								$ico = 'option';
							break;
		case 'messages' : $titre_page = 'Mes messages';
								$ico = 'mail';
							break;
		case 'message' : $titre_page = 'Mes messages';
								$ico = 'mail';
							break;
		case 'ecrire' : $titre_page = 'Nouveau message';
								$ico = 'mail';
							break;
		case 'panier' : 	$titre_page = 'Mon profil : mon panier';
								$ico = 'panier';
							break;
		case 'mes_achats' : $titre_page = 'Mon profil : mes achats';
									  $ico = 'add';
							break;
		case 'mes_ventes' : $titre_page = 'Mon profil : mes ventes';
									   $ico = 'del';
							break;
		case 'vendre' : 	$titre_page = 'Ajouter un produit &agrave; la vente';
								$ico = 'del';
							break;
		case 'a_genre' : 	$titre_page = 'Admin : Gestion des genres';
								$ico = 'option';
							break;
		case 'a_liste_membre' :	$titre_page = 'Admin : Liste des membres';
								$ico = 'list';
							break;
		case 'logout' : 	$titre_page = 'D&eacute;connexion';
								$link = 'deconnexion.inc.php';
							break;
		case 'condition_g': $titre_page = 'Conditions g&eacute;n&eacute;rales';
								$ico = 'list';
							break;
		case 'a_propos'	:	$titre_page = 'A propos';
								$ico = 'world';
							break;
	 	default : 			break;					
	}
	
	$ico = 'images/animation/'.$ico.'.png';
	
	$menus = menu_secondaire_html($titre_page,$ico, $tab, $tab_info_messages, $tab_info_nb_enchere);
	
	// Appel du code contrôleur correspondant à l'action demandée
	require($link);
} else {
    $titre_page = 'Accueil';
	$ico = "images/animation/world.png";
	$menus = menu_secondaire_html($titre_page, $ico, $tab, $tab_info_messages, $tab_info_nb_enchere);

	// Appel du code contrôleur de la page d'accueil
    require('actions/accueil.inc.php');
}


?>