<?php
#
$tab_genres = get_all_genres();
$dated = date("Y-m-d H:i:s");  

$msg = "";
$msge = "";

/*
	if(isset($_POST['cover'])){
		if(isset($_POST['titre'])){
			$url = get_url_search_cover($_POST['titre']);
			header("Location: $url target=\"_blank\"");
			die();
		}
	}*/
	if (!isset($_POST['titre']) && !isset($_POST['genre'])) {
	// titre, genre, realisateur, acteurs, duree, description, support, langue, prix_initial, date_debut, date_fin, cover
		$tab_info = array();
		$tab_info['titre'] = "";
		$tab_info['genre'] = "";
		$tab_info['realisateur'] = "";
		$tab_info['acteurs'] = "";
		$tab_info['duree'] = "";
		$tab_info['description'] = "";
		$tab_info['support'] = "";
		$tab_info['langue'] = "";
		$tab_info['prix_initial'] = 0;
		$tab_info['date_debut'] = $dated;
		$tab_info['duree_e_j'] = "";
		$tab_info['duree_e_h'] = "";
		$tab_info['cover'] = "";
	} else {
		$tab_info = array();
		$tab_info['titre'] = $_POST['titre'];
		$tab_info['genre'] = $_POST['genre'];
		$tab_info['realisateur'] = $_POST['realisateur'];
		$tab_info['acteurs'] = $_POST['acteurs'];
		$tab_info['duree'] = $_POST['duree'];
		$tab_info['description'] = $_POST['description'];
		$tab_info['support'] = $_POST['support'];
		$tab_info['langue'] = $_POST['langue'];
		$tab_info['prix_initial'] = $_POST['prix_initial'];
		$tab_info['date_debut'] = $dated;
		$tab_info['duree_e_j'] = $_POST['duree_e_j'];
		$tab_info['duree_e_h'] = $_POST['duree_e_h'];
		//$tab_info['cover'] = $_POST['cover'];
		
		// Verification des donn&eacute;es
		if (empty($tab_info['titre']))
			$msge .= "<br>- Veuillez indiquer un titre à votre film.";
		else if(!valider_text($tab_info['titre'])){
				$msge .= "<br>- Veuillez &eacute;crire votre titre correctement.";
		}
		if (empty($tab_info['realisateur']))
			$msge .= "<br>- Veuillez indiquer un ou des r&eacute;alisateurs à votre film.";
		else if(!valider_text($tab_info['realisateur'])){
				$msge .= "<br>- Veuillez &eacute;crire le(s) nom(s) du (des) r&eacute;alisateur(s) correctement.";
		}
		if (empty($tab_info['acteurs']))
			$msge .= "<br>- Veuillez indiquer un ou des acteurs à votre film.";
		else if(!valider_text($tab_info['acteurs'])){
			$msge .= "<br>- Veuillez &eacute;crire le(s) nom(s) du (des) acteur(s) correctement.";
		}
		if (empty($tab_info['duree']))
			$msge .= "<br>- Veuillez indiquer une dur&eacute;e à votre film.";
		else if(!valider_duree($tab_info['duree'])){
			$msge .= "<br>- Veuillez entrer une dur&eacute;e correcte";
		}
		if (empty($tab_info['description']))
			$msge .= "<br>- Veuillez indiquer une description à votre film.";
		else if(!valider_description($tab_info['description'])){
			$msge .= "<br>- Veuillez &eacute;crire votre description correctement.";
		}
		if (empty($tab_info['prix_initial']) && $tab_info['prix_initial'] <> 0 ){
			$msge .= "<br>- Veuillez indiquer un prix initial de vente pour votre film.";
		}else{
				$tab_info['prix_initial'] = (valider_chiffre($tab_info['prix_initial']));
				if($tab_info['prix_initial'] === false)
					$msge .= "<br>- Veuillez indiquer un prix initial de vente correcte pour votre film.";
		}
		if (empty($_FILES['photo_produit']['name'])) {

		}else if(!extension_valide(extension_de($_FILES['photo_produit']['name']))){
			$msge .= "<br>- Ce fichier n'est pas une image.";
		}
				
				
			if ($msge <> "") {
				// On affiche un message d'erreur
				$msg = message_html("error","Tous les champs du formulaire n'ont pas &eacute;t&eacute; correctement rempli.<br>$msge");
			} else {
				$delai = (($_POST['duree_e_j']*24+$_POST['duree_e_h'])*60*60);
				$datefin = date("Y-m-d H:i:s", (time()+$delai));
				
				$tab_info['date_fin'] = $datefin;
				$tab_info['cover'] = "0.jpg";
				
				$nom_cover = $tab_info['cover'];
				
				if(extension_de($_FILES['photo_produit']['name'])<> "probleme"){
					$uploaddir = "images/covers/";
					$extension =  extension_de($_FILES['photo_produit']['name']);
					$nom_cover = get_cover_code().".$extension";
					$uploadfile = $uploaddir.basename($nom_cover);
					move_uploaded_file($_FILES['photo_produit']['tmp_name'], $uploadfile);
				}
				
				
				$tab_info['cover'] = $nom_cover;
				ajouter_film($tab_info, $_SESSION['id']);
				
				$msg = message_html("ok", "Votre film à bien &eacute;t&eacute; ajout&eacute;e à votre bibliothèque");
		
				$tab_info = array();
				$tab_info['titre'] = "";
				$tab_info['genre'] = "";
				$tab_info['realisateur'] = "";
				$tab_info['acteurs'] = "";
				$tab_info['duree'] = "";
				$tab_info['description'] = "";
				$tab_info['support'] = "";
				$tab_info['langue'] = "";
				$tab_info['prix_initial'] = 0;
				$tab_info['date_debut'] = $dated;
				$tab_info['duree_e_j'] = "";
				$tab_info['duree_e_h'] = "";
				$tab_info['cover'] = "";
			}
				
	}

$menus = $msg . $menus;
$formulaire = nouveau_produit($tab_info, $tab_genres, $tab_support, $tab_langues);

# --------------------
# Vue : Page d'ajout de produit
# --------------------
require(CHEMIN_VUES .'vendre.inc.php');



?>