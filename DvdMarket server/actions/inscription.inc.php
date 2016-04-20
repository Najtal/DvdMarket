<?php
#

$nom = "";
$prenom = "";
$mail = "";
$pseudo = "";
$mdp = "";

$msg = "";
$msge = "";


if (isset($_POST['nom']))
	$nom = $_POST['nom'];
if (isset($_POST['prenom']))
	$prenom = $_POST['prenom'];
if (isset($_POST['email']))
	$mail = $_POST['email'];
if (isset($_POST['pseudo']))
	$pseudo = $_POST['pseudo'];
if (isset($_POST['mdp']))
	$mdp = $_POST['mdp'];

	
		// Condition de validation des champs du formulaire d'inscription
		if (isset ($_POST['cg']) && $_POST['cg']<>'checked'){
			$msge .= "<br>- Veuillez agr&eacute;er aux conditions d'utilisations g&eacute;n&eacute;rales.";
		}		
		if (empty($nom)) {
			$msge .= "<br>- Veuillez entrer un nom.";
			$nom = "";
		}
		if (strlen($nom) >= 50) {
			$msge .= "<br>- Votre nom est trop long.";
			$nom = "";
		}
		if (empty($prenom)) {
			$msge .= "<br>- Veuillez entrer un prenom.";
			$prenom = "";
		}
		if (strlen($prenom) >= 50) {
			$msge .= "<br>- Votre pr&eacute;nom est trop long.";
			$prenom = "";
		}
		if (!valider($mail)) {
			$msge .= "<br>- Veuillez entrer une adresse mail valide.";
			$mail = "";
		}
		if (strlen($mdp) >= 50 || strlen($mdp) < 4) {
			$msge .= "<br>- Votre pseudo doit contenir entre 4 et 50 caractères.";
			$mdp = "";
		}
		if (strlen($mdp) >= 30 || strlen($mdp) < 4) {
			$msge .= "<br>- Votre mot de passe doit contenir entre 4 et 30 caractères.";
			$mdp = "";
		}
		if (deja_present_pseudo($pseudo)) {
			$msge .= "<br>- Ce pseudo existe d&eacute;jà !.";
			$pseudo = "";
		}
		if (deja_present_email($mail)) {
			$msge .= "<br>- Cet &eacute;mail est d&eacute;jà utilis&eacute; dans pour un autre compte.";
			$mail = "";
		}
		
		$formulaire = formulaire_inscription($nom, $prenom, $mail, $pseudo, $mdp);
		
		// Ajout et envoie du mail de confirmation
		if (isset($_POST['nom']) || isset($_POST['prenom']) || isset($_POST['mail']) || isset($_POST['pseudo']) || isset($_POST['mdp'])){
				// Si il y a une erreur
				if ($msge <> "") {
					// On affiche un message d'erreur
						$msg = message_html("error","Tous les champs du formulaire n'ont pas &eacute;t&eacute; correctement rempli.<br>$msge");
				} else {
					// Autrement on pr&eacute;pare les informations (crypter le mot de passe et g&eacute;n&eacute;rer un code d'activation)
					$codeacti = rand(1000000, 9999999);
					$mdpcrypte = sha1($mdp);
					// On ajoute le tuple
					
					$req = inscription($nom, $prenom, $pseudo, $mail, $codeacti, $mdpcrypte, $date);
						
						if (!$req) {
								// L'ajout à &eacute;chou&eacute;, on affiche un message d'erreur.
								$msg = message_html("error","Votre inscription à &eacute;chou&eacute;e");
						} else {
								// L'ajout à r&eacute;ussi,.
								// On mets le formulaire de login
								$formulaire = formulaire_login("", "");
								$titre_page = "Première connexion";
								// On envoye le mail de confirmation
								$envoye = envoieMail($codeacti, $mail, $prenom, $pseudo, $mdp);
								if(!$envoye){
									$msg = message_html("error","L'inscription a fonctionn&eacute;e mais l'envoie du mail a &eacute;chou&eacute; <br> 
									http://dvdmarket.net76.net/projetPHP/index.php?action=activation&code=$codeacti&mail=$mail");
								}else{
									// On affiche un message de r&eacute;ussite
									$msg = message_html("ok","Votre inscription a r&eacute;ussie ! V&eacute;rifiez vos mails pour confirmer.");
								}
						}
				}
			}

$menus = $msg . $menus;

# --------------------
# Vue : Page de contact
# --------------------
require(CHEMIN_VUES .'inscription.inc.php');
?>