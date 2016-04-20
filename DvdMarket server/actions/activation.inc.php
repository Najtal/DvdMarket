<?php

$mail = "";
$mdp = "";
$msg = "";

if (isset($_GET['code']) && isset($_GET['mail']) && (!empty($_GET['mail']) or !empty($_GET['code']))){
	$est_confirme = activer_compte($_GET['code'],$_GET['mail']);
	if ($est_confirme) {
		$msg = message_html("ok","Votre compte est d&eacute;sormais activ&eacute;");
		$mail = $_GET['mail'];
	}else{
		$msg = message_html("error","Erreur ! Veuillez contacter un administrateur!");
	}
}

$formulaire = formulaire_login($mail, $mdp, "");
$menus = $msg . $menus;

# --------------------
# Vue : Page de login
# --------------------
require(CHEMIN_VUES .'login.inc.php');



?>