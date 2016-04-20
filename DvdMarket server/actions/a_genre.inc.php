<?php

if (isset($_POST['nvgenre']) && !empty($_POST['nvgenre'])) {
	ajout_genre($_POST['nvgenre']);
}

$formulaire = formulaire_ajout_genre();
$tabgenres = tab_genre_html(get_tab_genres());

# --------------------
# Vue : Page de a_genre
# --------------------
require(CHEMIN_VUES .'a_genre.inc.php');



?>