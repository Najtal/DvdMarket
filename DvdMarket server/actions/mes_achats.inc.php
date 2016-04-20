<?php

$style = 0;
	if (isset($_GET['style'])) {
		$_SESSION['style'] = $_GET['style'];
		$style = $_GET['style'];
	} else if (isset($_SESSION['style'])) {
		$style = $_SESSION['style'];
	}
$tab_info_achats = tab_mes_achats($_SESSION['id']);
$liste = tab_mes_achats_html($tab_info_achats, $style);



# --------------------
# Vue : Page mes achats
# --------------------
require(CHEMIN_VUES .'mes_ventes.inc.php');
?>