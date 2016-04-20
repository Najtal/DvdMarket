<?php
#
$style = 0;
$genre = null;
$recherche = null;
$id = null;

	if (isset($_GET['style'])) {
		$_SESSION['style'] = $_GET['style'];
		$style = $_GET['style'];
	} else if (isset($_SESSION['style'])) {
		$style = $_SESSION['style'];
	}

	// La variable genre est une valeur num&eacute;rique
	$titre = "Films disponible";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$tab_lignes = get_boutique_membre($id);
		$titre = "Boutique de &#34; ".get_pseudo($_GET['id'])." &#34;";

	} else {
	
		$recherche_genre = "";
		if (isset($_GET['genre'])) {
				$genre = $_GET['genre'];

			if ($_GET['genre'] == "") {
				$titre = "Recherche parmi tous les films";
			} else {
				$tab_genres = get_all_genres();
				$genre_nom = $tab_genres[$_GET['genre']]['nom'];
				$titre = "Recherche des films du genre &#34; $genre_nom &#34;";
				$recherche_genre = $_GET['genre'];
			}
		}	
		if (isset($_GET['recherche'])) {
			$recherche = $_GET['recherche'];
			$titre = "Recherche pour &#34; $recherche &#34;";
		} 
			$tab_lignes = get_boutique($recherche_genre, $recherche);
	}

		
		$tab_genres = get_tab_genres();
		for ($i = 0; $i < sizeof($tab_lignes); $i++) {
			$c = $tab_lignes[$i]['id_genre'];
			$tab_lignes[$i]['genre'] = $tab_genres[$c]['nom'];
		}

	$lignes = tab_boutique_html($tab_lignes, $titre, $style, $genre, $recherche, $id);
		
	
# -----------------------
# Vue : Page de la boutique
# -----------------------
require(CHEMIN_VUES . 'boutique.inc.php');
?>