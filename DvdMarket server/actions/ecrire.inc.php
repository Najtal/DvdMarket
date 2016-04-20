<?php
#

# ----------------------------
# Action formulaire de contact
# ----------------------------
$afficheMsg = "";

$destinataire = $_GET['idm'];
$objet = "";
if (isset($_GET['objet'])) 
	$objet = $_GET['objet'];
$message = "";

$msg = "";
if($_GET['idm'] == $_SESSION['id']) { 
	header("Location: index.php?action=messages"); 
# Envoi d'un message interne sur base des informations du formulaire transmises par la m&eacute;thode POST
} elseif (isset($_POST['objet']) && isset($_POST['message']) && isset($_POST['destinataire'])) {

$objet = $_POST['objet'];
$message = $_POST['message'];
$destinataire = $_POST['destinataire'];
$expediteur = $_SESSION['id'];

	if (empty($_POST['objet']) & empty($_POST['message'])) {
		$msg = message_html("error","Veuillez entrer un objet et un message.");
	} elseif (empty($_POST['objet'])) {
		$msg = message_html("error","Veuillez entrer un objet.");
	} elseif (empty($_POST['message'])) {
		$msg = message_html("error","Veuillez entrer un message.");
	} else {	
			envoyer_msg($expediteur, $destinataire, $objet, $message);
			$msg = message_html("ok","Votre message à &eacute;t&eacute; envoy&eacute; avec succès.");
	}
}
 
$formulaire = formulaire_envoie_msg(get_pseudo($destinataire), $destinataire, $objet, $message);

$menus = $msg . $menus;

# --------------------
# Vue : Page d'envoie d'un nouveau message
# --------------------
require(CHEMIN_VUES .'ecrire.inc.php');



?>