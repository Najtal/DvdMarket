<?php

$style = 0;
	if (isset($_GET['style'])) {
		$_SESSION['style'] = $_GET['style'];
		$style = $_GET['style'];
	} else if (isset($_SESSION['style'])) {
		$style = $_SESSION['style'];
	}

$tab_info_ventes = tab_mes_ventes($_SESSION['id']);
$titre ="Mes ventes";
$liste = tab_mes_ventes_html($tab_info_ventes, $titre, $style);

# --------------------
# Vue : Page mes ventes
# --------------------
require(CHEMIN_VUES .'mes_ventes.inc.php');
?>