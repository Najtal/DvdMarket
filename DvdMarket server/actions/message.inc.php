<?php

if (!isset($_GET['idm']))
	header("Location: index.php"); 

modif_etat_msg($_SESSION['id'], $_GET['idm']);

$tab_info_msg = tab_info_msg($_GET['idm']);		

if (!($tab_info_msg['id_receveur'] == $_SESSION['id'] || $tab_info_msg['id_envoyeur'] == $_SESSION['id']))
	header("Location: index.php"); 
	
	$tab_info_msg['receveur'] = get_pseudo($tab_info_msg['id_receveur']);
	$tab_info_msg['envoyeur'] = get_pseudo($tab_info_msg['id_envoyeur']);

$detail_msg_html = detail_msg_html($tab_info_msg);


# --------------------
# Vue : Page qui affiche un message
# --------------------
require(CHEMIN_VUES .'message.inc.php');
?>