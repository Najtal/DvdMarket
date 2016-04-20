<?php
#

$hotpage = "";

$tab_lm = tab_lm();
$hotpage .= affichage_covers_html("Les Last Minute", $tab_lm, 2);

$tab_de = tab_derniers();
$hotpage .= "<br><br>" . affichage_covers_html("Ajout&eacute;s r&eacute;cemment", $tab_de, 2);

# --------------------
# Vue : Page d'accueil
# --------------------
require(CHEMIN_VUES .'accueil.inc.php');
?>