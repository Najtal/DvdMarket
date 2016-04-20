<?php

$tab_info = array();
$tab_info = info_profil($_SESSION['id']);

$tab_modif_profil_html = tab_modif_profil($tab_info,$tab_etat);
$msg = "";
$msge = "";

if (isset($_POST['pwd0']) && isset($_POST['pwd1']) && isset($_POST['pwd2'])) {

	if ($_POST['pwd1'] <> $_POST['pwd2']) {
			$msg = message_html("error","Les mots de passe ne sont pas identiques.");
	} elseif (!connexion_login($_SESSION['mail'], $_POST['pwd0'])) {
			$msg = message_html("error","Votre mot de passe actuel n'est pas correcte");
	} elseif (strlen($_POST['pwd1']) >= 30 || strlen($_POST['pwd1']) < 4) {
			$msg = message_html("error","Votre mot de passe doit contenir entre 4 et 30 caract&egrave;res");
	} else {
			set_pwd($_POST['pwd1'], $_SESSION['id']);
			$msg = message_html("ok","Votre mot de passe &agrave; &eacute;t&eacute; modifi&eacute; avec succ&egrave;s.");
	}
}

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['photo'])) {

		if (empty($_POST['nom']))
			$msge .= "<br>- Vous devez entrer un nom.";
		if (strlen($_POST['nom']) >= 50)
			$msge .= "<br>- Votre nom est trop long.";
		if (empty($_POST['prenom']))
			$msge .= "<br>- Vous devez entrer un prenom.";
		if (strlen($_POST['prenom']) >= 50)
			$msge .= "<br>- Votre pr&eacute;nom est trop long.";
		
		if (empty($msge)) {
			modif_profil($_POST['nom'],$_POST['prenom'],$_POST['photo'],$_SESSION['id']);
			$msg = message_html("ok","Vos informations ont &eacute;t&eacute; modifi&eacute;es avec succ&egrave;s.");
		} else {
			$msg = message_html("error","Tous les champs du formulaire n'ont pas &eacute;t&eacute; correctement rempli.<br>$msge");
		}
			$tab_info = info_profil($_SESSION['id']);
			$tab_modif_profil_html = tab_modif_profil($tab_info, $tab_etat);
}

$menus = $msg . $menus;

# --------------------
# Vue : Page de modification du profil
# --------------------
require(CHEMIN_VUES .'modif.inc.php');
?>