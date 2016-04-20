<?php

$mail = "";
$mdp = "";
$msg = "";
$idprod = "";
if (isset($_GET['idprod']))
	$idprod = $_GET['idprod'];

if (isset($_POST['mailpseudo']) && isset($_POST['mdp']) && (!empty($_POST['mailpseudo']) or !empty($_POST['mdp']))){
	
	$mail = $_POST['mailpseudo'];
	$mdp = $_POST['mdp'];

	
	if (!confirme($mail)) {
		$msg = message_html("error","Vous devez d'abord confirmer votre inscription avant de pouvoir vous connecter. V&eacute;rifiez vos mails.");
	} else {
		//	On check les infos de connexion
		if (connexion_login($mail,$mdp)) {
			// Si connexion ok, on initialise les variables de session
			$_SESSION['connexion'] = true;
			$tab_info_user = get_info_user($mail);
			$_SESSION['id'] = $tab_info_user['id'];
			$_SESSION['pseudo'] = $tab_info_user['pseudo'];
			$_SESSION['mail'] = $tab_info_user['mail'];
			$_SESSION['etat'] = $tab_info_user['etat'];
			
			if (isset($_POST['idprod']) && $_POST['idprod']<>"") {
				header("Location: index.php?action=produit&id=".$_POST['idprod']);
				die();
			} else {
				header("Location: index.php?action=profil");
				die();
			}

		} else {
			// sinon on affiche un message d'erreur
			$msg = message_html("error","Les donn&eacute;es d'identification entr&eacute;es ne sont pas correctes");	
		}
	}
}

$formulaire = formulaire_login($mail, $mdp, $idprod);
$menus = $msg . $menus;

# --------------------
# Vue : Page de login
# --------------------
require(CHEMIN_VUES .'login.inc.php');



?>