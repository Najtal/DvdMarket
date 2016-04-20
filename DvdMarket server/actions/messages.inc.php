<?php

$tab_msg = tab_msg($_SESSION['id']);
		
$tab_to_print = array();

if (isset($_GET['re']) && $_GET['re'] == "recu") {
	$msg = "Boite de r&eacute;ception :";
		$j = 0;
		for ($i = 0; $i < sizeof($tab_msg); $i ++) {
			if ($tab_msg[$i]['id_receveur'] == $_SESSION['id']) {
				$tab_to_print[$j] = array();
				$tab_to_print[$j]['idm'] = $tab_msg[$i]['idm'];
				$tab_to_print[$j]['nosource'] = $tab_msg[$i]['id_envoyeur'];
				$tab_to_print[$j]['pseudo_source'] = get_pseudo($tab_msg[$i]['id_envoyeur']);
				$tab_to_print[$j]['objet'] = $tab_msg[$i]['objet'];
				$tab_to_print[$j]['lu'] = $tab_msg[$i]['lu'];	
				$j++;
			}
		}
} elseif (isset($_GET['re']) && $_GET['re'] == "envoye") {
	$msg = "Messages envoy&eacute;s :";
		$j = 0;
		for ($i = 0; $i < sizeof($tab_msg); $i ++) {
			if ($tab_msg[$i]['id_envoyeur'] == $_SESSION['id']) {
				$tab_to_print[$j] = array();
				$tab_to_print[$j]['idm'] = $tab_msg[$i]['idm'];
				$tab_to_print[$j]['nosource'] = $tab_msg[$i]['id_envoyeur'];
				$tab_to_print[$j]['pseudo_source'] = get_pseudo($tab_msg[$i]['id_receveur']);
				$tab_to_print[$j]['objet'] = $tab_msg[$i]['objet'];
				$tab_to_print[$j]['lu'] = $tab_msg[$i]['lu'];	
				$j++;
			}
		}
} elseif (isset($_GET['idsource'])) {
	$msg = "Conversation avec <a href=\"index.php?action=profil&id=".$_GET['idsource']."\">".get_pseudo($_GET['idsource'])."</a> :";
		$j = 0;
		for ($i = 0; $i < sizeof($tab_msg); $i ++) {	
			if ($tab_msg[$i]['id_envoyeur'] == $_GET['idsource'] || ($tab_msg[$i]['id_envoyeur'] == $_SESSION['id'] && $tab_msg[$i]['id_receveur'] == $_GET['idsource'])) {
					$tab_to_print[$j] = array();
					$tab_to_print[$j]['idm'] = $tab_msg[$i]['idm'];
					$tab_to_print[$j]['nosource'] = $tab_msg[$i]['id_envoyeur'];
					$tab_to_print[$j]['pseudo_source'] = get_pseudo($tab_msg[$i]['id_envoyeur']);
					$tab_to_print[$j]['objet'] = $tab_msg[$i]['objet'];
					$tab_to_print[$j]['lu'] = $tab_msg[$i]['lu'];		
					$j++;
			}
		}
} else {
	$msg = "Tous les messages :";
		$j = 0;
		for ($i = 0; $i < sizeof($tab_msg); $i ++) {	
				$tab_to_print[$j] = array();
				$tab_to_print[$j]['idm'] = $tab_msg[$i]['idm'];
				$tab_to_print[$j]['nosource'] = $tab_msg[$i]['id_envoyeur'];
				$tab_to_print[$j]['pseudo_source'] = get_pseudo($tab_msg[$i]['id_envoyeur']);
				$tab_to_print[$j]['objet'] = $tab_msg[$i]['objet'];
				$tab_to_print[$j]['lu'] = $tab_msg[$i]['lu'];	
				$j++;
		}
}
			

$liste = tab_msg_html($msg,$tab_to_print);



# --------------------
# Vue : Page des messages
# --------------------
require(CHEMIN_VUES .'mes_ventes.inc.php');
?>