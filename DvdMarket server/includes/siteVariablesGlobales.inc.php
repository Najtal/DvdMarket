<?php

// Variables globales

// lien du fichier css principal
$css_main = "css/main_style.css";
$css_specific = "css/specific.css";
// valeur de la balise <title> du site
$titre = "dvdMarket";
// date du jour
$date = date("j:m:Y");
$dated = date("Y-m-d H:i:s");

$tab_etat = array("compte non confirm&eacute;","compte membre","compte administrateur","compte clotur&eacute;");
$tab_support = array("Dvd","VHS","Blue-Ray");
$tab_langues = array("francais", "anglais", "neerlandais", "langage des signes");

# D&eacute;finition de constantes
define('CHEMIN_VUES', 'vues/');
define('CHEMIN_IMAGES_A', 'images/animation/');
define('CHEMIN_IMAGES_C', 'images/covers/');
define('CHEMIN_IMAGES_RG', 'images/rendu_graphique/');
?>