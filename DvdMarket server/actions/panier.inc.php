<?php

	$tab_info_panier = get_panier($_SESSION['id']);
	$style = 0;
	if (isset($_GET['style'])) {
		$_SESSION['style'] = $_GET['style'];
		$style = $_GET['style'];
	} else if (isset($_SESSION['style'])) {
		$style = $_SESSION['style'];
	}
		
		
	for ($i = 0; $i < sizeof($tab_info_panier); $i ++) {
		$tab_info_panier[$i]['dernier_encherisseur'] = verif_encherisseur($_SESSION['id'], $tab_info_panier[$i]['id_produit']);
	}

	$liste = tab_mon_panier_html($tab_info_panier, $style);

# --------------------
# Vue : Page panier
# --------------------
require(CHEMIN_VUES .'mes_ventes.inc.php');
?>