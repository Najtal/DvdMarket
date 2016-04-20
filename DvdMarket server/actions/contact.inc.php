<?php
#

# ----------------------------
# Action formulaire de contact
# ----------------------------
$afficheMsg = "";

$mail = "";
$objet = "";
$messagetxt = "";

$msg = "";
 


# Envoi d'un email sur base des informations du formulaire transmises par la m&eacute;thode POST
$notification='';
if (isset($_POST['monMail']) && isset($_POST['text'])) {

$mail = $_POST['monMail'];
$objet = $_POST['objet'];
$messagetxt = $_POST['text'];

	if (empty($_POST['monMail']) & empty($_POST['text'])) {
		$msg = message_html("error","Veuillez entrer une adresse email et un message.");
	} elseif (empty($_POST['monMail'])) {
		$msg = message_html("error","Veuillez entrer une adresse email.");
	} elseif (empty($_POST['text'])) {
		$msg = message_html("error","Veuillez entrer un message.");
	} elseif (strlen($_POST['objet']) >= 75) {
		$msg = message_html("error","Votre Objet est trop long (max 75 caractères).");
	} elseif (!valider($_POST['monMail'])) {
		$msg = message_html("error","Veuillez entrer une adresse email correcte.");
	} else {
		$to      = 'madgaet@gmail.com';
		$subject = "contact dvdMarket : " . $_POST['objet'];
		$message = $_POST['text'];
		$headers = 'From: ' . $_POST['monMail'];
		$envoye = mail($to, $subject, $message, $headers);
		if ($envoye) {
			$msg = message_html("ok","Vos informations ont &eacute;t&eacute; transmises avec succ&egrave;s.");
		} else {
			$msg = message_html("error","Vos informations n\'ont pas &eacute;t&eacute; transmises &agrave; cause d\'un souci technique.");
		}
	}
}
 
$formulaire = formulaire_contact($mail, $objet, $messagetxt);

$menus = $msg . $menus;

# --------------------
# Vue : Page de contact
# --------------------
require(CHEMIN_VUES .'contact.inc.php');



?>