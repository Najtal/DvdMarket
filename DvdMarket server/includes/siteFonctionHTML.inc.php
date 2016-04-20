<?php

// FONCTIONS D'AFFICHAGE PRINCIPALE
// renvoie le code html du header
function header_html($css1, $css2,$titre) {
	$head_aretourner = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n
	<html>\n
	<head>\n
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">\n
	<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\">\n
	<title>$titre</title>\n
	<link href=\"$css1\" rel=\"stylesheet\" type=\"text/css\">\n
	<link href=\"$css2\" rel=\"stylesheet\" type=\"text/css\">\n
	<link rel=\"icon\" type=\"image/png\" href=\"images/animation/disc.png\" >\n
	</head>";
	return $head_aretourner;
}

// renvoie le code html du menu sup&eacute;rieur
function menu_main_html() {
$menu_aretourner = "";
$menu_aretourner .= "
	<body>\n
	<div id=\"empty_link\"><a href=\"index.php?action=accueil\"><img src=\"".CHEMIN_IMAGES_RG."empty.png\" class=\"empty\" ALT=\"\" title=\"Retour &agrave; l'accueil\"></a></div>
	<div id=\"header\">\n
	<div id=\"menu_main\">";
		
	if (!isset($_SESSION['connexion'])) {
		$menu_aretourner .= "
			<form action = \"index.php?action=login\" method = \"POST\" class=\"formulaire_div\">
				<span class=\"menulist\"><input class=\"form_login\" name=\"mailpseudo\" type=\"text\" placeholder=\"login/email\"> 
				<input class=\"form_login\" name=\"mdp\" type=\"password\" placeholder=\"mot de passe\" > 
				<input class=\"form_login\" type=\"submit\" value=\"connexion\" >
			</span></form>";
	 } else {
		$menu_aretourner .= "<span class=\"menulist\"><a href=\"index.php?action=profil\">Bonjour ".$_SESSION['pseudo']."</a> - <a href=\"index.php?action=logout\" title=\"Voulez-vous vous d&eacute;connecter ".$_SESSION['pseudo']." ?\"> d&eacute;connexion </a></span>";
	 }
	
	$menu_aretourner .= "
			 <ul class=\"menulist\">
			 <li class=\"menulist\"><a href=\"index.php?action=accueil\" title=\"Retourner &agrave; l'accueil du site.\">Accueil</a></li>
			 <li class=\"menulist\"><a href=\"index.php?action=boutique\" title=\"Voir tous les articles en vente dans notre boutique.\">Boutique</a></li>";
			 if (!isset($_SESSION['connexion'])) {
				$menu_aretourner .= "
				<li class=\"menulist\"><a href=\"index.php?action=inscription\"  title=\"Inscrivez-vous pour acc&eacute;der &agrave; toute les fonctionnalit&eacute;s du site.\">Inscription</a></li>";
			 } else {
				$menu_aretourner .= "
				<li class=\"menulist\"><a href=\"index.php?action=profil\" title=\"Acc&eacute;dez &agrave; vos informations profil.\">Mon profil</a></li>";
			 }
			 $menu_aretourner .= "
			 <li class=\"menulist\"><a href=\"index.php?action=contact\" title=\"N'h&eacute;sitez pas &agrave; nous contacter !\">Contactez-nous</a></li>
			 </ul>
		</div>
	</div>";

	return $menu_aretourner;
}

// renvoie le code html du menu du conteneur
function menu_secondaire_html($titre_page, $ico, $tab, $tab_info_msg, $tab_info_nb_enchere) {
	$menus_aretourner = "";
	$menus_aretourner .= "
	<div id=\"conteneur\">

		<div id=\"contenu\">
			<div id=\"contenu_head\">
				<div id=\"titreh2\">
					$titre_page<div><img src=\"$ico\" class=\"ico\" ALT=\"dvdMarket\"></div>
				</div>
			</div>
			
			<div id=\"contenu_corps\">
				<div id=\"menu_sub\">";
							
			if (isset($_SESSION['etat']) && $_SESSION['etat'] == 2) {	
				$menus_aretourner .= "	
					
					<p class=\"menu_title\">Administration</p>
					<a href=\"index.php?action=a_genre\">Cat&eacute;gories de films</a><br>
					<a href=\"index.php?action=a_liste_membre\">Liste des membres</a>";
			}							
							
			if (isset($_SESSION['connexion'])) {	
				$nbnonlu = $tab_info_msg['nonlu'];
				$nbmsg = $tab_info_msg['nbmsg'];
				$nbnonencheri = $tab_info_nb_enchere['enchere_gagnante'];
				$nbencheri = $tab_info_nb_enchere['enchere_total'];
				
				$menus_aretourner .= "	
					<p class=\"menu_title\">Gestion du compte</p>
					<p><a href=\"index.php?action=profil\">Mon profil</a>
					<br><a href=\"index.php?action=mes_ventes\">Mes ventes</a>
					<br><a href=\"index.php?action=vendre\">Mettre en vente un film</a>
					<br><a href=\"index.php?action=mes_achats\">Mes achats</a>
					<br><a href=\"index.php?action=panier\">Mon panier <span TITLE=\"vous avez ench&eacute;ri $nbencheri produits et vous &ecirc;tes le meilleur ench&eacute;risseur pour $nbnonencheri d'entre eux.\">($nbnonencheri/$nbencheri)</span></a>
					<br><a href=\"index.php?action=messages&amp;re=recu\">Mes messages <span TITLE=\"vous avez $nbmsg messages dont $nbnonlu messages non lu.\">($nbnonlu/$nbmsg)</a>
					</p>";
			}
					
			$nbfilms = 0;
			for ($i = 0; $i < sizeof($tab); $i ++) {
				$nbfilms = ($nbfilms + $tab[$i]['nb']);	
			}
					
			$menus_aretourner .= "		
					<p class=\"menu_title\">Genres</p>
					<p>	<a href=\"index.php?action=boutique&amp;genre=\">Tous les films ($nbfilms)</a><br>";
			
			for ($i = 0; $i < sizeof($tab); $i ++) {
				$menus_aretourner .= "<a href=\"index.php?action=boutique&amp;genre=" .$tab[$i]['id_genre']. "\">" .$tab[$i]['nom']. " (" .$tab[$i]['nb']. ")</a><br>";	
			}
			
			$menus_aretourner .= "</p>";
		
			$menus_aretourner .= "<p class=\"menu_title\">Recherche</p>
				<form action=\"index.php?action=boutique&amp;\" method=\"GET\" class=\"formulaire_div\">
				<input class=\"input_recherche\" name=\"recherche\" type=\"text\" placeholder=\"recherche\"> <input class=\"submit_recherche\" name=\"action\" type=\"submit\" value=\"Go!\" >
				<input name=\"action\" type=\"hidden\" value=\"boutique\">
				</form>";
				
			if (!isset($_SESSION['connexion'])) {
				$menus_aretourner .= "<br><br>
				<p class=\"menu_title\">Autre</p>
				<a href=\"index.php?action=inscription\"  title=\"Inscrivez-vous pour acc&eacute;der &agrave; toute les fonctionnalit&eacute;s du site.\">Inscrivez-vous</a><br>
				<a href=\"index.php?action=login\"  title=\"Connectez-vous.\">Connexion</a>";
			 }
			$menus_aretourner .= "
				</div>
			<div id=\"contenu_main\">";

	return $menus_aretourner;
}

// renvoie le code html du footer de la page
function footer_html() {
	$footer_aretourner = "";
	$footer_aretourner .= "
			</div>

			</div>
			
			<div id=\"contenu_footer\">
				<div id=\"footer_txt\">
					<p> www.dvdmarket.net76.net - Copyright 2012<br>
						<a href=\"index.php\">accueil</a> - <a href=\"index.php?action=contact\">contactez-nous</a> - <a href=\"index.php?action=condition_g\">conditions g&eacute;n&eacute;rales</a> - <a href=\"index.php?action=a_propos\">A propos</a>
					</p>
				</div>
				<div id=\"footer_bot\">
				</div>
			</div>
		</div>
	</div>
	<br><br><br>
	</body>
	</html>
	";

	return $footer_aretourner;
}

// Affiche un  message d'erreur ou de confirmation
function message_html($lvl,$txt) {
	$msg_aretourner = "";
	
	if ($lvl == "ok") {
	$msg_aretourner .= "
		<div id=\"message_ok\">
		<img class=\"message_ico\" height=\"24\" src=\"images/rendu_graphique/ok.gif\" width=\"24\" /><span class=\"message_txt\">$txt</span>
		</div>";
	} 
	if ($lvl == "error") {
	$msg_aretourner .= "
		<div id=\"message_error\">
		<img class=\"message_ico\" height=\"24\" src=\"images/rendu_graphique/error.png\" width=\"24\" ALT=\"Error:\"><span class=\"message_txt\">$txt</span>
		</div>";
	} 

	return $msg_aretourner;
}

// Affiche les détails d'un produit en fenetre volante
function info_prod($cover) {
	$retour = "<span><img src=\"".CHEMIN_IMAGES_C.$cover."\" class=\"info_cover\"></span>";
	
	return $retour;
}


// ACCUEIL
// Foction qui affiche le contenu du tableau de produits sous forme de "vitrine".
function affichage_covers_html($title, $tab_de_produits, $nb_lignes_max) {
	$tabres = "";
	$tabres .= "
	
	<div class=\"title_box\">$title</div>
				<table class=\"tab_vitrine_div\">";
						
				
		// On d&eacute;fini le nombre de lignes

		if ($nb_lignes_max == 0) {
				$nblignes = sizeof($tab_de_produits) / 3;
		} else {  
			if (sizeof($tab_de_produits) / 3 > $nb_lignes_max)
					$nblignes = $nb_lignes_max;
			else
					$nblignes = sizeof($tab_de_produits) / 3;
		}		

			$nbelem = sizeof($tab_de_produits);
			
		$nb_produit = 0;
			
		// Une ligne d'images
		for ($j = 0; $j < $nblignes; $j++) {
				
						$tabres .= "<tr>";
				for ($i = $j*3; $i < $j*3+3; $i++) {

						$tabres .= "
									<td class=\"tab_vitrine\">";
									
									if ($nb_produit < $nbelem) {
							$tabres .= "
										<div class=\"produit_cover_mini_div\">
											<a href=\"index.php?action=produit&amp;id=".$tab_de_produits[$nb_produit]['id_produit']."\"><img src=\"images/covers/".$tab_de_produits[$nb_produit]['cover']."\" class=\"produit_cover_mini\" alt=\"titre: ".$tab_de_produits[$nb_produit]['titre']."\"></a>
										</div>";
									}
									

						$tabres .= "</td>";
						$nb_produit++;
				}
						$nb_produit-=3;
						$tabres .= "</tr><tr>";
						
				for ($i = $j*3; $i < $j*3+3; $i++) {
						$tabres .= "<td class=\"tab_vitrine\"><br>";
						
							if ($nb_produit < $nbelem) {
							$tabres .= "<a href=\"index.php?action=produit&amp;id=".$tab_de_produits[$nb_produit]['id_produit']."\">".$tab_de_produits[$nb_produit]['titre']."</a>
							<br>Il reste ".TimeToJourJ($tab_de_produits[$nb_produit]['date_fin'])."
							<br>".$tab_de_produits[$nb_produit]['prix']." &euro;";
							}
						$tabres .= "</td>";
						$nb_produit++;
				}
						$tabres .= "</tr><tr>";
				for ($i = $j*3; $i < $j*3+3; $i++) {
						$tabres .= "<td class=\"tab_vitrine_spacement\"></td>";
				}
						$tabres .= "</tr>";
		}
	
				$tabres .= "
				</table>";

	return $tabres;
}


// BOUTIQUE
function tab_boutique_html($tab, $titre, $style, $genre, $recherche, $id) {


	$lien = "index.php?action=boutique&amp;";
	if ($genre <> null) {
		$lien .= "genre=$genre";
	} else if ($recherche <> null) {
		$lien .= "recherche=$recherche";
	} else if ($id <> null) {
		$lien .= "id=$id";
	}
	$lien .= "&amp;style=";
	if ($style == 0)
		$lien .= "1";
	else if ($style == 1)
		$lien .= "0";
		
	$tabretour = "<div class=\"title_box\">$titre : ".sizeof($tab)." r&eacute;sultat</div>";
	$mod_loupe = loupe($style, $lien);
	$tabretour .= $mod_loupe;

	if ($style == 1) {
		for ($i = 0; $i < sizeof($tab); $i ++) {
			$tabretour .= "
			<div class=\"vue_detaillee\">
				<div id=\"panier_cover\">
					<a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\"><img src=\"".CHEMIN_IMAGES_C.$tab[$i]['cover']."\" class=\"panier_cover\" ALT=\"Erreur cover\"/></a>
				</div>
				<table style=\"width: 100%\">
					<tr>
						<td class=\"tab_panier\">titre :</td>
						<td><a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\">".$tab[$i]['titre']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">genre :<br></td>
						<td>".$tab[$i]['genre']."</td>
					</tr>
					<tr>
						<td class=\"tab_panier\">langue :<br></td>
						<td>".$tab[$i]['langue']."</td>
					</tr>
					<tr>
						<td class=\"tab_panier\">support :<br><br></td>
						<td>".$tab[$i]['support']."<br><br></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">fin de l'ench&egrave;re dans :</td>
						<td><span TITLE=\"L'ench&egrave;re fini le : ".$tab[$i]['date_fin']."\">".TimeToJourJ($tab[$i]['date_fin'])."</span></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">prix enchere :<br></td>
						<td>".$tab[$i]['prix']." &euro;</td>
					</tr>
				</table>
			</div>";
		}
	} else {	
		$tabretour .= "
			<table class=\"liste_dvd_tab\">
			<tr class=\"liste_dvd_ligne_titre\">
			<td class=\"liste_dvd_id\">n&ordm;</td>
			<td class=\"liste_dvd_titre\">Titre</td>
			<td class=\"liste_dvd_genre\">Temps restant</td>
			<td class=\"liste_dvd_prix\">Prix (&euro;)</td></tr>";
		
		$couleur=true;
		for ($i = 0; $i < sizeof($tab); $i++) {
				if ($couleur) {
					$tabretour .= "<tr class=\"liste_dvd_ligne\">";
				} else {
					$tabretour .= "<tr class=\"liste_dvd_ligne2\">";
				}
				$info = info_prod($tab[$i]['cover']);
					$tabretour .= "
								<td class=\"liste_dvd_id\">".($i+1)."</td>
								<td class=\"liste_dvd_titre\"><a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\" class=\"info\" \">".$tab[$i]['titre']."$info</a></td>	
								<td class=\"liste_dvd_genre\"><span TITLE=\"L'ench&egrave;re fini le : ".$tab[$i]['date_fin']."\">".TimeToJourJ($tab[$i]['date_fin'])."</span></td>
								<td class=\"liste_dvd_prix\">".$tab[$i]['prix']."</td> 
								</tr>";
					$couleur = !$couleur;
		}
		$tabretour .= "</table>";
	}
	return $tabretour;
}


// INSCRIPTION
// 1 - Fonction qui renvoie le code HTML du formulaire d'inscription
function formulaire_inscription($nom, $prenom, $mail, $pseudo, $mdp) {
	$tabres ="";
	$tabres.="		

	
<div class=\"title_box\">Bienvenue dans l'inscription utilisateur de dvdMarket.</div>\n

<table class=\"formtab\">\n
  <tr> \n
    <td><p>\n
      <form action=\"index.php?action=inscription\" method=\"POST\" name=\"regForm\" id=\"regForm\">\n
      <table>\n
       <tr><td>\n
       </td></tr>\n
		
        <tr><td>\n
          	<br>Votre nom<br> \n
            <input name=\"nom\" type=\"text\" size=\"40\" value=\"$nom\">\n
        </td></tr>\n
		
        <tr><td>\n
          	<br>Votre pr&eacute;nom<br> \n
             <input name=\"prenom\" type=\"text\" size=\"40\" value=\"$prenom\">\n
        </td></tr>\n
                   
        <tr><td>\n
          	<br>Votre adresse e-mail<br>\n
			<input name=\"email\" type=\"text\" value=\"$mail\">\n
		</td></tr>\n

        <tr><td class=\"main\">\n
        	<br>Votre pseudo<br> \n
            <input name=\"pseudo\" type=\"text\" value=\"$pseudo\">\n
        </td></tr>\n

        <tr><td class=\"main\">\n
        	<br>Votre mot de passe<br> \n
            <input name=\"mdp\" type=\"password\" value=\"$mdp\">\n
        </td></tr>\n
		
		<tr><td class=\"main\">\n
			<br><br>
			Cochez la case pour signaler que vous agr&eacute;ez aux <a href=\"index.php?action=condition_g\" target=\"_blank\">conditions d'utilisations g&eacute;n&eacute;rales.</a>
			<input name=\"cg\" type=\"checkbox\" value=\"checked\">\n
        </td></tr>\n
	
        </table>\n
        
        <p align=\"center\">\n
          	<br><br><input name=\"inscript\" type=\"submit\" class=\"form_button\" value=\"s'inscrire\"> \n
        </p>\n
      </form>\n
	   
  </td>\n
  </tr>\n
  </table>\n
  "; 
return $tabres;
}

// 2 - Fonction qui envoie un mail de confirmation
function envoieMail($codeactivation, $mail, $prenom, $pseudo, $mdp) {
 
	$siteWeb = 'http://www.dvdmarket.net76.net/projetPHP/index.php';
	$activation = "?action=activation&code=$codeactivation&mail=$mail";
	$objet = 'DvdMarket : Mail de confirmation !';
     // Le message
					$message = "";
					$message .= "Bonjour $prenom! \n";
					$message .= "Nous vous remercions de nous rejoindre sur la plateforme dvdMarket.\n\n";
					
					$message .= "Vos informations de login sont les suivantes : \n";
					$message .= "votre pseudo : $pseudo \n";
					$message .= "votre mot de passe : $mdp \n\n";
					
					$message .= "Pour confirmer votre r&eacute;servation, veuillez suivre le lien ci-dessous \n";
					
					$message .= "$siteWeb$activation \n";
					
					$message .= "Bonnes affaires sur dvdMarket !";
					
     $message = wordwrap($message, 120);
     // Envoi du mail
	 return mail($mail, $objet, $message);

}



// LOGIN
// Fonction qui renvoie le code HTML du formulaire de login
function formulaire_login($mail, $mdp, $idprod) {
	$formulaire = "<div class=\"title_box\">Connectez-vous</div>\n
						<form action = \"index.php?action=login\" method = \"POST\" class=\"formulaire_div\"><p class=\"formtab\">\n
						<br>Votre email ou pseudo<br><input type = \"text\" value = \"$mail\" name = \"mailpseudo\" size = \"30\"><br>\n
						<br>Votre mot de passe<br><input type = \"password\" value = \"$mdp\" name = \"mdp\" size = \"30\"><br>\n
						<br><input value=\"$idprod\" name=\"idprod\" type=\"hidden\">
						<br><input type = \"submit\"  value = \"Se connecter\" class=\"form_button\">\n
						</p></form><br><br><br><br><br>\n";
						
	$formulaire .= "
		<div class=\"title_box\">Pas encore inscrit ?</div>
		<form action = \"index.php\" method = \"get\" class=\"formulaire_div\">
		<p class=\"formtab\"><input value=\"inscription\" name=\"action\" type=\"hidden\">
		<input type = \"submit\"  value = \"Inscrivez-vous\" class=\"form_button\">
		</p>";
	
	return $formulaire;
}



// PROFIL & MODIF
function tab_profil($tabl, $tab_etat, $note) {
		
	$id = $tabl[0]; 
	$nom = $tabl[1]; 
	$prenom = $tabl[2]; 
	$pseudo = $tabl[3]; 
	$mdp = $tabl[4]; 
	$mail = $tabl[5]; 
	$date = $tabl[6]; 
	$etat = $tabl[7]; 
	$photolvl = $tabl[8];
	
	$etatNom = etat_profil($etat, $tab_etat);
	$photo = CHEMIN_IMAGES_A . "user_" . $photolvl . "_max.png";
	
	$note_s = "";
	if ($note <> 0) {
		for ($s=0 ; $s < 5 ; $s++) {
			if ($s < $note)
				$note_s .= "<img src=\"".CHEMIN_IMAGES_A."star_mini.png\">";
			else
				$note_s .= "<img src=\"".CHEMIN_IMAGES_A."star_empty_mini.png\">";
		}
	} else {
		$note_s = "aucune cotation";
	}
	
	
	$tabres ="		
	
	   <div id=\"photo_profil\">
			<img src=\"$photo\" class=\"ico\">
		</div>
      <table>\n
       <tr><td>\n
         	<div class=\"title_box\">Vos informations profil :</div>\n
       </td></tr>\n
	   
	   	 <tr>
			<td class=\"main\"><br>pseudo : <br>adresse e-mail :<br></td>
			<td class=\"main\"><br>$pseudo <br>$mail<br></td>
        </tr>

		<tr>
			<td class=\"main\"><br>nom : <br> pr&eacute;nom :<br></td>
			<td class=\"main\"><br>$nom <br>$prenom<br></td>
        </tr>
		
		<tr>
			<td class=\"main\"><br>cote du vendeur : <br></td>
			<td class=\"main\"><br>$note_s</td>
        </tr>
		
		<tr>
			<td class=\"main\"><br>num&eacute;ro de membre : <br> date d'inscription :<br>statut compte : <br></td>
			<td class=\"main\"><br>n&ordm; $id <br>$date<br>$etatNom</td>
        </tr>
			
        </table>
		
		<br><br><br>
		<a href=\"index.php?action=mes_ventes\"><img src=\"images/animation/star_mini.png\" class=\"picture_mini\" ALT=\"-\"><span class=\"links_in_profil\"> Voir ma boutique</span></a>		
		<br><br>
		<a href=\"index.php?action=vendre\"><img src=\"images/animation/add_mini.png\" class=\"picture_mini\" ALT=\"-\"><span class=\"links_in_profil\"> Ajouter un nouveau produit &agrave; la vente</span></a>		
		<br><br>
		<a href=\"index.php?action=modif\"><img src=\"images/animation/option_mini.png\" class=\"picture_mini\" ALT=\"-\"><span class=\"links_in_profil\"> Modifier votre profil</span></a>
		
		\n"; 
	return $tabres;
}

function tab_vue_profil($tabl, $tab_etat, $note) {
		
	$id = $tabl[0]; 
	$nom = $tabl[1]; 
	$prenom = $tabl[2]; 
	$pseudo = $tabl[3]; 
	$mdp = $tabl[4]; 
	$mail = $tabl[5]; 
	$date = $tabl[6]; 
	$etat = $tabl[7]; 
	$photolvl = $tabl[8];
	
	$etatNom = etat_profil($etat, $tab_etat);
	$photo = CHEMIN_IMAGES_A . "user_" . $photolvl . "_max.png";
	$note_s = "";
	if ($note <> 0) {
		for ($s=0 ; $s < 5 ; $s++) {
			if ($s < $note)
				$note_s .= "<img src=\"".CHEMIN_IMAGES_A."star_mini.png\" ALT=\"X\">";
			else
				$note_s .= "<img src=\"".CHEMIN_IMAGES_A."star_empty_mini.png\" ALT=\"X\">";
		}
	} else {
		$note_s = "aucune cotation";
	}
	
	
	$tabres ="		

	   <div id=\"photo_profil\">
			<img src=\"$photo\" class=\"ico\" ALT=\"Erreur photo\">
		</div>
      <table>\n
       <tr><td>\n
         	<div class=\"title_box\">Profile de $pseudo :</div>\n
       </td></tr>\n
	   
	   	 <tr>
			<td class=\"main\"><br>pseudo :<br></td>
			<td class=\"main\"><br>$pseudo </td>
        </tr>
		
		<tr>
			<td class=\"main\"><br>num&eacute;ro de membre : <br> statut compte : <br></td>
			<td class=\"main\"><br>n&ordm; $id <br>$etatNom</td>
        </tr>
		
		<tr>
			<td class=\"main\"><br>cote du vendeur : <br></td>
			<td class=\"main\"><br>$note_s</td>
        </tr>
						
        </table>
		
		<br><br><br><br>";
		if (isset($_SESSION['connexion'])) {
		$tabres .="	
		<a href=\"index.php?action=ecrire&amp;idm=$id\"><img src=\"".CHEMIN_IMAGES_A."mail_mini.png\" class=\"picture_mini\" ALT=\"-\"><span class=\"links_in_profil\"> Envoyer un message &agrave; $pseudo</span></a>
		<br><br>";
		}
		$tabres .="	
		<a href=\"index.php?action=boutique&amp;id=$id\"><img src=\"".CHEMIN_IMAGES_A."star_mini.png\" class=\"picture_mini\" ALT=\"-\"><span class=\"links_in_profil\"> Voir la boutique de $pseudo</span></a>
		
		\n";		
	return $tabres;
}

function tab_modif_profil($tabl, $tab_etat) {

	$id = $tabl[0]; 
	$nom = $tabl[1]; 
	$prenom = $tabl[2]; 
	$pseudo = $tabl[3]; 
	$mdp = $tabl[4]; 
	$mail = $tabl[5]; 
	$date = $tabl[6]; 
	$etat = $tabl[7]; 
	$photolvl = $tabl[8];
	
	$etatNom = etat_profil($etat, $tab_etat);
	$photo1 = CHEMIN_IMAGES_A . "user_1.png";
	$photo2 = CHEMIN_IMAGES_A . "user_2.png";
	$photo3 = CHEMIN_IMAGES_A . "user_3.png";
	$photo4 = CHEMIN_IMAGES_A . "user_4.png";

	$dated = date("Y-m-d H:i:s");
	
	$tabres ="		
	 <form action=\"index.php?action=modif\" method=\"POST\">
		<div class=\"title_box\">Modifiez vos informations profil :</div>\n
	  
	  <table>\n

	   
	   	 <tr>
			<td class=\"main\"><br><img src=\"$photo1\" class=\"ico\"><br></td>
			<td class=\"main\"><br><img src=\"$photo2\" class=\"ico\"><br></td>
			<td class=\"main\"><br><img src=\"$photo3\" class=\"ico\"><br></td>
			<td class=\"main\"><br><img src=\"$photo4\" class=\"ico\"><br></td>";
        
	$tab_ventes = tab_mes_ventes($_SESSION['id']);
	$ventes_finies = 0;
	for ($i = 0 ; $i < sizeof($tab_ventes) ; $i++) {
		if ($tab_ventes[$i]['date_fin'] < $dated)
			$ventes_finies++;
	}
	
			// MIKE *
			$tabres .="</tr><tr class=\"center\"><td><br><label><input type=\"radio\" name=\"photo\" value=\"1\" class=\"radio\"";
					if ($photolvl == 1)
						$tabres .=" checked";
			$tabres .=">Mike</label></td><td><br><label><input type=\"radio\" name=\"photo\" value=\"2\" class=\"radio\"";
					if ($photolvl == 2)
						$tabres .=" checked";				
			// MELINDA *
			$tabres .=">Melinda</label></td>";
			if ($ventes_finies > 10 or $_SESSION['etat'] == 2) {		
				$tabres .= "<td><br><label>
				<input type=\"radio\" name=\"photo\" value=\"3\" class=\"radio\"";
						if ($photolvl == 3) $tabres .=" checked";
				$tabres .=">John</label></td>";
			} else {
				$tabres .= "<td><br><label>Bloqu&eacute; ($ventes_finies/10)</label></td>";
			}
			if ($ventes_finies > 25 or $_SESSION['etat'] == 2) {
				$tabres .="<td><br><label><input type=\"radio\" name=\"photo\" value=\"4\" class=\"radio\"";
					if ($photolvl == 4)
						$tabres .=" checked";
				$tabres .=">Mr. Boss</label></td>";
			} else {
				$tabres .= "<td><br><label>Bloqu&eacute; ($ventes_finies/25)</label></td>";
			}
	$tabres .="
		</tr>
		</table>
		<br><br><br>
		<table>
		
		 <tr>
			<td>num&eacute;ro de membre : </td>
			<td>n&ordm; $id</td>
        </tr>
	   	 <tr>
			<td>nom : </td>
			<td><input name=\"nom\" type=\"text\" size=\"40\" value=\"$nom\" class=\"smallform\">\n</td>
		</tr>
	   	 <tr>
			<td>prenom : </td>
			<td><input name=\"prenom\" type=\"text\" size=\"40\" value=\"$prenom\" class=\"smallform\">\n</td>
		</tr>
		<tr>
			<td>adresse email : </td>
			<td><input name=\"mail\" type=\"text\" size=\"40\" value=\"$mail\" class=\"smallform\" disabled=\"disabled\">\n</td>
		</tr>
		<tr>
			<td>pseudo : </td>
			<td><input name=\"pseudo\" type=\"text\" size=\"40\" value=\"$pseudo\" class=\"smallform\" disabled=\"disabled\">\n</td>
		</tr>
        </table>
		<br><br><br>
		<span class=\"submit\"><input name=\"modif\" type=\"submit\" class=\"form_button\" value=\"Sauver\"></span>
	</form>
	
			<br><br><br>		<br><br><br>
	
		 <form action=\"index.php?action=modif\" method=\"POST\">
		 <div class=\"title_box\">Modifiez votre mot de passe :</div>\n
		<table>
	   	 <tr>
			<td>mot de passe actuel : </td>
			<td><input name=\"pwd0\" type=\"password\" size=\"40\" value=\"\" class=\"smallform\">\n</td>
		</tr>
	   	 <tr>
			<td>nouveau mot de passe : </td>
			<td><input name=\"pwd1\" type=\"password\" size=\"40\" value=\"\" class=\"smallform\">\n</td>
		</tr>
	   	 <tr>
			<td>nouveau mot de passe (bis) : </td>
			<td><input name=\"pwd2\" type=\"password\" size=\"40\" value=\"\" class=\"smallform\">\n</td>
		</tr>
        </table>
		<br><br><br>
		<span class=\"submit\"><input name=\"modifmdp\" type=\"submit\" class=\"form_button\" value=\"Modifier\"></span>
	</form>
	

		\n"; 
	return $tabres;
}



// MES VENTES
function tab_mes_ventes_html($tab, $titre, $style) {
		
	$tabretour = "<div class=\"title_box\">$titre : ".sizeof($tab)."</div>";
		if ($style == 0)
			$s = "1";
		else if ($style == 1)
			$s = "0";
		$mod_loupe = loupe($style, "index.php?action=mes_ventes&amp;style=$s");
		$tabretour .= $mod_loupe;
		
	$dated = date("Y-m-d H:i:s");  
		
	if ($style == 1) {
		for ($i = 0; $i < sizeof($tab); $i ++) {
		
			$tabretour .= "	
			<div class=\"vue_detaillee\">
				<div id=\"panier_cover\">
					<a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\"><img src=\"".CHEMIN_IMAGES_C.$tab[$i]['cover']."\" class=\"panier_cover\" ALT=\"Erreur cover\"/></a>
				</div>
				<table style=\"width: 100%\">
					<tr>
						<td class=\"tab_panier\">titre :</td>
						<td><a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\">".$tab[$i]['titre']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">acheteur :</td>
						<td><a href=\"index.php?action=profil&amp;id=".$tab[$i]['id_acheteur']."\">".get_pseudo($tab[$i]['id_acheteur'])."</a></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">date de fin de l'ench&egrave;re :</td>
						<td>";
						
						if ($tab[$i]['date_fin'] > $dated)
							$tabretour .= "<span title=\"Fin de l'ench&egrave;re le : ".$tab[$i]['date_fin']."\">dans ".TimeToJourJ($tab[$i]['date_fin'])."</span>";
						else
							$tabretour .= "<span title=\"Fin de l'ench&egrave;re le : ".$tab[$i]['date_fin']."\">Pass&eacute;e</span>";
								
			$tabretour .= "</td>
					</tr>
					<tr>
						<td class=\"tab_panier\">prix enchere :<br></td>
						<td>".$tab[$i]['prix']." &euro;</td>
					</tr>
				</table>
			</div>";

		}
	} else {
		$tabretour .= "
				<table class=\"liste_dvd_tab\">
				
					<tr class=\"liste_dvd_ligne_titre\">
						<td class=\"liste_dvd_id\">n&ordm;</td>
						<td class=\"liste_dvd_titre\">Titre</td>
						<td class=\"liste_dvd_titre\">Acheteur</td>
						<td class=\"liste_dvd_genre\">Date de fin</td>
						<td class=\"liste_dvd_prix\">Prix (&euro;)</td>
					</tr>";
	
		for ($i = 0; $i < sizeof($tab); $i ++) {
				if ($i%2==0) {
					$tabretour .= "<tr class=\"liste_dvd_ligne\">";
				} else {
					$tabretour .= "<tr class=\"liste_dvd_ligne2\">";
				}
				$info = info_prod($tab[$i]['cover']);
				$tabretour .= "
								<td class=\"liste_dvd_id\">".$tab[$i]['id_produit']."</td>
								<td class=\"liste_dvd_titre\"><a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\" class=\"info\">".$tab[$i]['titre']."$info</a></td>
								<td class=\"liste_dvd_titre\"><a href=\"index.php?action=profil&amp;id=".$tab[$i]['id_acheteur']."\">".get_pseudo($tab[$i]['id_acheteur'])."</a></td>
								<td class=\"liste_dvd_genre\">";
								
								if ($tab[$i]['date_fin'] > $dated)
									$tabretour .= "<span title=\"Fin de l'ench&egrave;re le : ".$tab[$i]['date_fin']."\">dans ".TimeToJourJ($tab[$i]['date_fin'])."</span>";
								else
									$tabretour .= "<span title=\"Fin de l'ench&egrave;re le : ".$tab[$i]['date_fin']."\">Fini</span>";
								
								$tabretour .= "</td>
								<td class=\"liste_dvd_prix\">".$tab[$i]['prix']."</td>
								</tr>";
		}
		
		$tabretour .= "</table>";
	}
	return $tabretour;
	
}



// MES ACHATS
function tab_mes_achats_html($tab, $style) {
		
	$tabretour = "<div class=\"title_box\">Mes achats : ".sizeof($tab)."</div>";
		if ($style == 0)
			$s = "1";
		else if ($style == 1)
			$s = "0";
		$mod_loupe = loupe($style, "index.php?action=mes_achats&amp;style=$s");
		$tabretour .= $mod_loupe;

	$dated = date("Y-m-d H:i:s");  
	if ($style == 1) {
		for ($i = 0; $i < sizeof($tab); $i ++) {
		
			$tabretour .= "	
			<div class=\"vue_detaillee\">
				<div id=\"panier_cover\">
					<a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\"><img src=\"".CHEMIN_IMAGES_C.$tab[$i]['cover']."\" class=\"panier_cover\" ALT=\"Erreur cover\"/></a>
				</div>
				<table style=\"width: 100%\">
					<tr>
						<td class=\"tab_panier\">titre :</td>
						<td><a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\">".$tab[$i]['titre']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">vendeur :</td>
						<td><a href=\"index.php?action=profil&amp;id=".$tab[$i]['id_vendeur']."\">".get_pseudo($tab[$i]['id_vendeur'])."</a></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">ench&egrave;re gagn&eacute;e depuis :</td>
						<td><span TITLE=\"L'ench&egrave;re fini le : ".$tab[$i]['date_fin']."\">".TimeToJourJ($tab[$i]['date_fin'])."</span></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">prix enchere :<br></td>
						<td>".$tab[$i]['prix']." &euro;</td>
					</tr>
					<tr>
						<td class=\"tab_panier\">note<br></td>
						<td>";
						if ($tab[$i]['note'] > 0)
							$tabretour .= $tab[$i]['note']." / 5";
						else 
							$tabretour .= " - ";
					
					$tabretour .= "
					</td></tr>
				</table>
			</div>";

		}
	} else {
		$tabretour .= "		
			<table class=\"liste_dvd_tab\">
					
			<tr class=\"liste_dvd_ligne_titre\">
			<td class=\"liste_dvd_id\">n&ordm;</td>
			<td class=\"liste_dvd_titre\">Titre</td>
			<td class=\"liste_dvd_titre\">Vendeur</td>
			<td class=\"liste_dvd_genre\">Gagn&eacute; depuis</td>
			<td class=\"liste_dvd_prix\">Prix (&euro;)</td>
			<td class=\"liste_dvd_prix\">Note</td>
			</tr>";
		
		for ($i = 0; $i < sizeof($tab); $i ++) {
				if ($i%2==0) {
					$tabretour .= "<tr class=\"liste_dvd_ligne\">";
				} else {
					$tabretour .= "<tr class=\"liste_dvd_ligne2\">";
				}
				$info = info_prod($tab[$i]['cover']);
				$tabretour .= "
								<td class=\"liste_dvd_id\">".$tab[$i]['id_produit']."</td>
								<td class=\"liste_dvd_titre\"><a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\" class=\"info\">".$tab[$i]['titre']."$info</a></td>
								<td class=\"liste_dvd_titre\"><a href=\"index.php?action=profil&amp;id=".$tab[$i]['id_vendeur']."\">".get_pseudo($tab[$i]['id_vendeur'])."</a></td>
								<td class=\"liste_dvd_genre\">".TimeToJourJ($tab[$i]['date_fin'])."</td>
								<td class=\"liste_dvd_prix\">".$tab[$i]['prix']."</td>
								<td class=\"liste_dvd_prix\">";
								if ($tab[$i]['note'] == 0)
									$tabretour .= "-";
								else 
								$tabretour .= $tab[$i]['note']." / 5";
								$tabretour .= "</td></tr>";
		}
		
		$tabretour .= "</table>";
	}
	return $tabretour;
	
}



// MON PANIER
function tab_mon_panier_html($tab, $style) {
	$tabretour = "<div class=\"title_box\">Mon panier : ".sizeof($tab)."</div>";
		if ($style == 0)
			$s = "1";
		else if ($style == 1)
			$s = "0";
		$mod_loupe = loupe($style, "index.php?action=panier&amp;style=$s");
		$tabretour .= $mod_loupe;
	
	if ($style == 1) {
		for ($i = 0; $i < sizeof($tab); $i ++) {
		
			$tabretour .= "	
			<div class=\"vue_detaillee\">
				<div id=\"panier_cover\">
					<a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\"><img src=\"".CHEMIN_IMAGES_C.$tab[$i]['cover']."\" class=\"panier_cover\" ALT=\"Erreur cover\"/></a>
				</div>
				<table style=\"width: 100%\">
					<tr>
						<td class=\"tab_panier\">titre :</td>
						<td><a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\">".$tab[$i]['titre']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">vendeur :</td>
						<td><a href=\"index.php?action=profil&amp;id=".$tab[$i]['id_vendeur']."\">".$tab[$i]['pseudo_vendeur']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_panier\">prix initial :</td>
						<td>".$tab[$i]['prix_initial']."</td>
					</tr>
					<tr>
						<td class=\"tab_panier\">prix enchere :<br></td>
						<td>".$tab[$i]['prix_enchere']."</td>
					</tr>
					<tr>
						<td class=\"tab_panier\">ench&egrave;re en cours depuis :</td>
						<td>".TimeToJourJ($tab[$i]['date_debut'])."</td>
					</tr>
					<tr>
						<td class=\"tab_panier\">fin de l'ench&egrave;re dans</td>
						<td><span TITLE=\"L'ench&egrave;re fini le : ".$tab[$i]['date_fin']."\">".TimeToJourJ($tab[$i]['date_fin'])."</span></td>
					</tr>
				</table><br>";
				
			if($tab[$i]['dernier_encherisseur'])
				$tabretour .= "<img src=\"images/animation/ok_mini.png\" class=\"picture_mini\"><span class=\"links_in_profil\"> Vous &ecirc;tes le dernier ench&eacute;risseur</span></p>";
			else
				$tabretour .= "<img src=\"images/animation/error_mini.png\" class=\"picture_mini\"><span class=\"links_in_profil\"> Vous n'&ecirc;tes pas le dernier ench&eacute;risseur. <a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\"> Ench&eacute;rissez ! </a></span></p>";
			$tabretour .= "</div>";
		}
	} else {
		$tabretour .= "<table class=\"liste_dvd_tab\">
					<tr>
					<td class=\"liste_dvd_ligne_titre\">ndeg;</td>
					<td class=\"liste_dvd_ligne_titre\">Titre</td>
					<td class=\"liste_dvd_ligne_titre\">Vendeur</td>
					<td class=\"liste_dvd_ligne_titre\">Temps restant</td>
					<td class=\"liste_dvd_ligne_titre\">Etat</td>
					<td class=\"liste_dvd_ligne_titre\">Prix (&euro;)</td>
					</tr>";
		$couleur=true;
		
		for ($i = 0; $i < sizeof($tab); $i++) {
			if ($couleur) {
				$tabretour .= "<tr class=\"liste_dvd_ligne\">";
			} else {
				$tabretour .= "<tr class=\"liste_dvd_ligne2\">";
			}
			$info = info_prod($tab[$i]['cover']);
			$tabretour .= "
						<td class=\"liste_dvd_id\">".($i+1)."</td>
						<td class=\"liste_dvd_titre\"><a href=\"index.php?action=produit&amp;id=".$tab[$i]['id_produit']."\" class=\"info\">".$tab[$i]['titre']."$info</a></td>
						<td class=\"liste_dvd_titre\"><a href=\"index.php?action=profil&amp;id=".$tab[$i]['id_vendeur']."\">".$tab[$i]['pseudo_vendeur']."</a></td>
						<td class=\"liste_dvd_genre\"><span TITLE=\"L'ench&egrave;re fini le : ".$tab[$i]['date_fin']."\">".TimeToJourJ($tab[$i]['date_fin'])."</span></td>
						<td class=\"liste_dvd_prix\">";

					if($tab[$i]['dernier_encherisseur'])
						$tabretour .= "<img src=\"images/animation/ok_mini.png\" class=\"picture_mini\"><span class=\"links_in_profil\">";
					else
						$tabretour .= "<img src=\"images/animation/error_mini.png\" class=\"picture_mini\"><span class=\"links_in_profil\">";
						
			$tabretour .= "</td> 
						<td class=\"liste_dvd_prix\">".$tab[$i]['prix_enchere']."</td> 
						</tr>";
			$couleur = !$couleur;
		}
		$tabretour .= "</table>";
	}
	
	return $tabretour;
}



// PRODUIT
function produit_detail($tabl) {
		
	$dated = date("Y-m-d H:i:s");  
		
	$tabres = "";
	$tabres .="		
		<div class=\"title_box\">".$tabl['titre']."</div>\n
						
				<div id=\"produit_cover\">
					<img src=\"".CHEMIN_IMAGES_C.$tabl['cover']."\" class=\"produit_cover\" ALT=\"Erreur cover\"/>
				</div>
		<br>";
				
		
						if ($dated < $tabl['date_fin']) {
							$finE = "debut de l'ench&egrave;re il y a";
							$debE = "fin de l'ench&egrave;re dans ";
							$prix = "prix ench&egrave;re";
						} else {
							$debE = "ench&egrave;re finie depuis ";
							$finE = "d&eacute;but de l'ench&egrave;re il y &agrave;";
							$prix = "prix de vente";
						}	
		
					$tabres .= "	
				<table class=\"produit_info1\">
					<tr>
						<td class=\"tab_produit\">titre</td>
						<td><a href=\"index.php?action=produit&amp;id=".$tabl['id_produit']."\">".$tabl['titre']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_produit\">vendeur<br></td>
						<td><a href=\"index.php?action=profil&amp;id=".$tabl['id_vendeur']."\">".$tabl['pseudo_vendeur']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_produit\">genre</td>
						<td><a href=\"index.php?action=boutique&amp;genre=".$tabl['genre']."\">".$tabl['genre_nom']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_produit\">realisateur</td>
						<td><a href=\"index.php?action=boutique&amp;recherche=".$tabl['realisateurs']."\">".$tabl['realisateurs']."</a></td>						
					</tr>
					<tr>
						<td class=\"tab_produit\">acteurs</td>
						<td>".$tabl['acteurs']."</td>
					</tr>
					<tr>
						<td class=\"tab_produit\">duree</td>
						<td>".$tabl['duree']."</td>
					</tr>
					<tr>
						<td class=\"tab_produit\">support</td>
						<td><a href=\"index.php?action=boutique&amp;recherche=".$tabl['support']."\">".$tabl['support']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_produit\">langue</td>
						<td><a href=\"index.php?action=boutique&amp;recherche=".$tabl['langue']."\">".$tabl['langue']."</a></td>
					</tr>
					<tr>
						<td class=\"tab_produit\">prix initial</td>
						<td>".$tabl['prix_initial']." &euro;</td>
					</tr>
					<tr>
						<td class=\"tab_produit\">$prix<br></td>
						<td>".$tabl['prix_enchere']." &euro;</td>
					</tr>
					<tr>
						<td class=\"tab_produit\">$finE</td>
						<td><span TITLE=\"".$tabl['date_debut']."\">".TimeToJourJ($tabl['date_debut'])."</span></td>
					</tr>
					<tr>
						<td class=\"tab_produit\">$debE</td>
						<td><span TITLE=\"".$tabl['date_fin']."\">".TimeToJourJ($tabl['date_fin'])."</span></td>
					</tr>
				</table>
				<br><br><br>
				<p> Description : <br><br>".$tabl['description']."<br><br>";
	
	if ($dated < $tabl['date_fin'] && isset($_SESSION['id']) && $tabl['id_vendeur'] <> $_SESSION['id']) {
		$id_meilleur_encherisseur = verif_encherisseur($_SESSION['id'], $tabl['id_produit']);
		
		if ($id_meilleur_encherisseur) {
			$tabres .= "<br><br><p class=\"produit_info1\"><img src=\"images/animation/ok_mini.png\" class=\"picture_mini\"><span class=\"links_in_profil\">Vous &ecirc;tes le dernier ench&eacute;risseur</span></p>";
		} else {
			$tabres .= "
			<br><br><br><br>
				<div class=\"title_box\">Ench&eacute;rissez :</div>\n
						<span class=\"formtab\"><form action = \"index.php?action=produit&amp;id=".$tabl['id_produit']."\" method = \"POST\" class=\"formulaire_div\"><p>\n
						A combien voulez-vous ench&eacute;rir ?<br><input type = \"text\" value = \"\" name=\"somme\" size = \"30\" placeholder=\"".$tabl['prix_enchere']."\"><br>\n
						<br><input type = \"submit\"  value = \"Ench&eacute;rissez\" class=\"form_button\">\n
				</p></form></span><br>\n";
		}
	} else if ($dated < $tabl['date_fin'] && !isset($_SESSION['id'])) {
			$tabres .= "
			<br><br><br><br>
				<div class=\"title_box\">Ench&eacute;rissez</div>\n
						<span class=\"formtab\"><form action = \"index.php\" method = \"GET\" class=\"formulaire_div\"><p>\n
						A combien voulez-vous ench&eacute;rir ?
						<input value=\"login\" name=\"action\" type=\"hidden\">
						<input value=\"".$tabl['id_produit']."\" name=\"idprod\" type=\"hidden\">
						<br><input type = \"text\" value = \"\" name=\"somme\" size = \"30\" placeholder=\"".$tabl['prix_enchere']."\"><br>\n
						<br><input type = \"submit\"  value = \"Ench&eacute;rissez\" class=\"form_button\">\n			
				</p></form></span><br>\n";
	} 
	
	if ($dated > $tabl['date_fin'] && $tabl['id_vendeur'] == $_SESSION['id']) {
			$tabres .= "
			<br><br><br><br>
				<div class=\"title_box\">Nettoyer</div>\n
						<span class=\"formtab\"><form action = \"index.php?action=produit\" method = \"POST\" class=\"formulaire_div\"><p>\n
						Nettoyer les ench&egrave;res permet d'effacer de facon permanente les ench&egrave;res sur ce produit qui ne sont pas l'ench&egrave;re gagnante.<br>
						<input value=\"".$tabl['id_produit']."\" name=\"idprodDel\" type=\"hidden\">
						<br><input type = \"submit\"  value = \"Nettoyer les ench&egrave;res\" class=\"form_button\">\n			
				</p></form></span><br>\n";
	}
		$tabres .= "<br><br>";
		return $tabres;
}

function note_produit($tabl) {
	$tabretour = "
		<br><div class=\"title_box\">Notez la vente : </div>\n
				<span class=\"formtab\"><form action=\"index.php?action=produit&amp;id=".$tabl['id_produit']."\" method = \"POST\" class=\"formulaire_div\">\n
						<p><STRONG>F&eacute;licitation ! Vous avez gagn&eacute; cette ench&egrave;re.</STRONG><br><br>
						<a href=\"index.php?action=profil&amp;id=".$tabl['id_vendeur']."\">Rendez-vous sur le profil du vendeur pour prendre contact avec lui</a><br>
						<br>
						Vous pouvez cotez la qualit&eacute; de la vente, quelle note globale donneriez-vous &agrave; cette vente ? <br><br><i>(Ceci comprend la vente, la description, le delai d'envoi du produit, la communication avec le vendeur etc...)</i><br><br>
				<select name=\"note\">
				<option ";
				if ($tabl['note'] == 0)
					$tabretour .= "selected=\"selected\"";
				 $tabretour .= " value=\"NULL\">ne pas coter</option>
				<option ";
				if ($tabl['note'] == 1)
					$tabretour .= "selected=\"selected\"";
				 $tabretour .= " value=\"1\">1 / 5</option>
				<option ";
				if ($tabl['note'] == 2)
					$tabretour .= "selected=\"selected\"";
				 $tabretour .= " value=\"2\">2 / 5</option>
				<option ";
				if ($tabl['note'] == 3)
					$tabretour .= "selected=\"selected\"";
				 $tabretour .= " value=\"3\">3 / 5</option>
				<option ";
				if ($tabl['note'] == 4)
					$tabretour .= "selected=\"selected\"";
				 $tabretour .= " value=\"4\">4 / 5</option>
				<option ";
				if ($tabl['note'] == 5)
					$tabretour .= "selected=\"selected\"";
				 $tabretour .= " value=\"5\">5 / 5</option>
				</select><br>\n
				<br><input type = \"submit\"  value = \"Notez cette vente\" class=\"form_button\">\n
				</p></form></span><br><br>";
		
	return $tabretour;
}

function tab_encheres_html($tab_info_encheres) {

	$tabretour = "
		<div class=\"title_box\">Ench&egrave;res sur ce produit : ".sizeof($tab_info_encheres)."</div>\n
			<br>
				<table class=\"liste_dvd_tab\">
				
					<tr class=\"liste_dvd_ligne_titre\">
						<td class=\"liste_dvd_id\">n&ordm;</td>
						<td class=\"liste_dvd_titre\">Ench&eacute;risseur</td>
						<td class=\"liste_dvd_genre\">Ench&eacute;ri</td>
						<td class=\"liste_dvd_prix\">Prix (&euro;)</td>
					</tr>";
	
	for ($i = 0; $i < sizeof($tab_info_encheres); $i ++) {
			if ($i%2==0) {
				$tabretour .= "<tr class=\"liste_dvd_ligne\">";
			} else {
				$tabretour .= "<tr class=\"liste_dvd_ligne2\">";
			}
			$tabretour .= "
							<td class=\"liste_dvd_id\">".(sizeof($tab_info_encheres)-$i)."</td>
							<td class=\"liste_dvd_titre\"><a href=\"index.php?action=profil&amp;id=".$tab_info_encheres[$i]['id_utilisateur']."\">".get_pseudo($tab_info_encheres[$i]['id_utilisateur'])."</a></td>
							<td class=\"liste_dvd_titre\">il y a ".TimeToJourJ($tab_info_encheres[$i]['date'])."</td>
							<td class=\"liste_dvd_genre\">".$tab_info_encheres[$i]['montant']."</td>
							</tr>";
	}
	
	$tabretour .= "</table>";
	return $tabretour;

}

function nouveau_produit($tab_info, $tab_genres, $tab_format, $tab_langues) {

// id_produit -> auto_increment
// id_vendeur -> $_SESSION['id']
// note -> 0
// titre, genre, realisateur, acteurs, duree, description, support, langue, prix_initial, date_debut, date_fin, cover

	$tabres = "		
<div class=\"title_box\">Bienvenue dans le formulaire d'ajout d'un produit.</div>\n

<table class=\"formtab\">\n
  <tr> \n
    <td><p>\n
      <form enctype=\"multipart/form-data\" action=\"index.php?action=vendre\" method=\"POST\">\n
      <table>\n
       <tr><td>\n
       </td></tr>\n
		
        <tr><td>\n
          	<br>Le titre du film<br> \n
            <input name=\"titre\" type=\"text\" size=\"40\" value=\"".$tab_info['titre']."\">\n
        </td></tr>\n
		
        <tr><td>\n
          	<br>Le genre du film<br> \n
            <select name=\"genre\">";
				
			for ($i=0 ; $i < sizeof($tab_genres) ; $i++) {
				$tabres .= "<option ";
				if ($tab_info['genre'] == $i)
					$tabres .=  "selected=\"selected\"";
				 $tabres .= " value=\"$i\">".$tab_genres[$i]['nom']."</option>";
			}
			$tabres .= "</select>
        </td></tr>\n
                   
        <tr><td>\n
          	<br>Le r&eacute;alisateur<br> \n
            <input name=\"realisateur\" type=\"text\" size=\"40\" value=\"".$tab_info['realisateur']."\">\n
        </td></tr>\n

		<tr><td>\n
          	<br>Les acteurs principaux<br> \n
            <input name=\"acteurs\" type=\"text\" size=\"40\" value=\"".$tab_info['acteurs']."\">\n
        </td></tr>\n
		
		<tr><td>\n
          	<br>La dur&eacute;e du film (format HH:MM)<br> \n
            <input name=\"duree\" type=\"text\" size=\"8\" value=\"".$tab_info['duree']."\">\n
        </td></tr>\n
		
		<tr><td>\n
          	<br>La description<br> \n
			<br><a href=\"http://fr.wikipedia.org/wiki/Wikip%C3%A9dia:Accueil_principal\" target=\"_blank\">Rechercher une description (synopsis)</a><br><br>
			<textarea name=\"description\" cols=\"40\" rows=\"7\">".$tab_info['description']."</textarea>
        </td></tr>\n
		
        <tr><td>\n
          	<br>Quel support<br> \n
            <select name=\"support\">";
				
			for ($i=0 ; $i < sizeof($tab_format) ; $i++) {
				$tabres .= "<option ";
				if ($tab_info['support'] == $i)
					$tabres .=  "selected=\"selected\"";
				 $tabres .= " value=\"".$tab_format[$i]."\">".$tab_format[$i]."</option>";
			}
			$tabres .= "</select>
        </td></tr>\n	
		
		<tr><td>\n
          	<br>La langue<br> \n
			<select name=\"langue\">";
			for ($i=0 ; $i < sizeof($tab_langues) ; $i++) {
				$tabres .= "<option ";
				if ($tab_info['langue'] == $i)
					$tabres .=  "selected=\"selected\"";
				 $tabres .= " value=\"".$tab_langues[$i]."\">".$tab_langues[$i]."</option>";
			}
			$tabres .= "</select>
        </td></tr>\n		
		
		<tr><td>\n
          	<br>Fin de l'ench&egrave;re dans<br> \n
            <select name=\"duree_e_j\" class=\"submit_recherche2\">";
			for ($i=5 ; $i <= 20 ; $i++) {
				$tabres .= "<option ";
				if ($tab_info['duree_e_j'] == $i)
					$tabres .=  "selected=\"selected\"";
				 $tabres .= " value=\"$i\">$i jours</option>";
			}
			$tabres .= "</select>
			
			<select name=\"duree_e_h\" class=\"submit_recherche2\">";
			for ($i=1 ; $i <= 24 ; $i++) {
				$tabres .= "<option ";
				if ($tab_info['duree_e_h'] == $i)
					$tabres .=  "selected=\"selected\"";
				 $tabres .= " value=\"$i\">$i heures</option>";
			}
			$tabres .= "</select>
        </td></tr>\n
        </table>\n
        
		<tr><td>\n
          	<br>A quel prix voulez-vous commencer l'ench&egrave;re ? (en &euro;)<br> \n
            <input name=\"prix_initial\" type=\"text\" size=\"40\" value=\"".$tab_info['prix_initial']."\">\n
        </td></tr>\n	
		
		<tr><td>\n
          	<br>Ajouter une cover : <br> \n
			<br><a href=\"http://be.bing.com/images/search?q=cover&amp;go=&amp;qs=ds&amp;form=QBIR\" target=\"_blank\">Rechercher une cover</a><br><br>
            <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1000000\" />
			<input name=\"photo_produit\" type=\"file\" />
        </td></tr>\n	
		
		<tr><td>\n
        <p align=\"center\">\n
          	<br><br><input name=\"vendre\" type=\"submit\" class=\"form_button\" value=\"Ajouter un produit\"> \n
        </p>\n</td></tr>\n
		
      </form>\n
	   
  </td>\n
  </tr>\n
  </table>\n
  "; 
return $tabres;
}


// MESSAGES
function tab_msg_html($msg, $tab_to_print) {

	$tabretour = "
		<div class=\"title_box\">$msg</div>\n
	
				<table class=\"tab_bt_msg\">
					<tr>
						<td>				
							<form action=\"index.php\" method=\"GET\" class=\"formulaire_div\">
							<input type=\"submit\" value=\"Tous les messages\" class=\"msg_bt\">
							<input name=\"action\" type=\"hidden\" value=\"messages\">
							</form>
						</td>
						<td>
							<form action=\"index.php\" method=\"GET\" class=\"formulaire_div\">
							<input type=\"submit\" value=\"Boite de r&eacute;ception\" class=\"msg_bt\">
							<input name=\"action\" type=\"hidden\" value=\"messages\">
							<input name=\"re\" type=\"hidden\" value=\"recu\">
							</form>
						</td>
						<td>
							<form action=\"index.php\" method=\"GET\" class=\"formulaire_div\">
							<input type=\"submit\" value=\"Messages envoy&eacute;s\" class=\"msg_bt\">
							<input name=\"action\" type=\"hidden\" value=\"messages\">
							<input name=\"re\" type=\"hidden\" value=\"envoye\">
							</form>
						</td>
					</tr>
				</table>

				
				<table class=\"liste_dvd_tab\">
				
					<tr class=\"liste_dvd_ligne_titre\">
						<td class=\"liste_dvd_id\">n&ordm;</td>
						<td class=\"liste_dvd_titre\">Objet</td>";
					if($msg == "Messages envoy&eacute;s :"){
						$tabretour .= "<td class=\"liste_dvd_genre\">Receveur</td>";
					}else{
						$tabretour .= "<td class=\"liste_dvd_genre\">Exp&eacute;diteur</td>";
					}
						$tabretour .= "<td class=\"liste_dvd_prix\">etat</td>
					</tr>";
	
	for ($i = 0; $i < sizeof($tab_to_print); $i ++) {
			if ($i%2==0) {
				$tabretour .= "<tr class=\"liste_dvd_ligne\">";
			} else {
				$tabretour .= "<tr class=\"liste_dvd_ligne2\">";
			}
			if ($tab_to_print[$i]['lu'] == 1) {
			$tabretour .= "
							<td class=\"liste_dvd_id\">".($i+1)."</td>
							<td class=\"liste_dvd_titre\"><a href=\"index.php?action=message&amp;idm=".$tab_to_print[$i]['idm']."\">".$tab_to_print[$i]['objet']."</a></td>
							<td class=\"liste_dvd_genre\"><a href=\"index.php?action=messages&amp;idsource=".$tab_to_print[$i]['nosource']."\">".$tab_to_print[$i]['pseudo_source']."</a></td>
							<td class=\"liste_dvd_prix\"><img src=\"images/animation/mail_open.png\" class=\"ico\" ALT=\"lu\">";
			} else {
			$tabretour .= "
							<td class=\"liste_dvd_id\">".($i+1)."</td>
							<td class=\"liste_dvd_titre\"><a href=\"index.php?action=message&amp;idm=".$tab_to_print[$i]['idm']."\"><strong>".$tab_to_print[$i]['objet']."</strong></a></td>
							<td class=\"liste_dvd_genre\"><a href=\"index.php?action=messages&amp;idsource=".$tab_to_print[$i]['nosource']."\"><strong>".$tab_to_print[$i]['pseudo_source']."</strong></a></td>
							<td class=\"liste_dvd_prix\"><img src=\"images/animation/mail_close.png\" class=\"ico\" ALT=\"non lu\">";
			}
			$tabretour .= "</td></tr>";
	}
	
	$tabretour .= "</table>";
	return $tabretour;
}

function detail_msg_html($tab) {



	$aretourner = "
				<table class=\"tab_msg\">
						<tr>
							<td>Message envoy&eacute; de <a href=\"index.php?action=profil&amp;id=".$tab['id_envoyeur']."\"><strong>".$tab['envoyeur']."</strong></a> &agrave; <a href=\"index.php?action=profil&amp;id=".$tab['id_receveur']."\"><strong>".$tab['receveur']."</strong></a> le ".$tab['date']."</td>
						</tr>
				</table>
					<br>
				<table class=\"tab_msg\">
						<tr>
							<td>Objet : ".$tab['objet']."</td>
						</tr>
				</table>
					<br>
				<table class=\"tab_msg\">
						<tr>
							<td>message : ".$tab['message']."</td>
						</tr>
				</table><br><br>";
					
					if ($tab['id_receveur'] == $_SESSION['id']) {
						$aretourner .= "
							<form action=\"index.php\" method=\"GET\" class=\"formulaire_div\">
							<input type=\"submit\" value=\"r&eacute;pondre\" class=\"msg_bt\">
							<input name=\"action\" type=\"hidden\" value=\"ecrire\">
							<input name=\"idm\" type=\"hidden\" value=\"".$tab['id_envoyeur']."\">
							<input name=\"objet\" type=\"hidden\" value=\"".$tab['objet']."\">
							</form><br>";
					}
					
	$aretourner .= "
					<form action=\"index.php\" method=\"GET\" class=\"formulaire_div\">
					<input type=\"submit\" value=\"retour\" class=\"msg_bt\">
					<input name=\"action\" type=\"hidden\" value=\"messages\">
					</form>";
			
	return $aretourner;
}
// Fonction qui renvoie le code HTML du formulaire de contact
function formulaire_envoie_msg($pseudo_destinataire, $destinataire, $objet, $message) {
	$formulaire = "<div class=\"title_box\">Envoyer un message :</div>\n
						<span class=\"formtab\"><form action=\"\" method=\"POST\" class=\"formulaire_div\"><p>\n
						<br>Envoyer &agrave;<br><input type=\"text\" value=\"".$pseudo_destinataire."\" name=\"destinataire_pseudo\" size=\"30\" disabled=\"disabled\"><br>\n
						<br>Votre objet <br><input type=\"text\" value=\"".$objet."\" name=\"objet\" size =\"30\"><br>\n
						<br>Votre message <br><textarea name=\"message\" cols=\"70\" rows=\"10\">".$message."</textarea><br>\n
						<br><br><input type=\"submit\"  value=\"Envoyer\" class=\"form_button\">\n
						<input name=\"destinataire\" type=\"hidden\" value=\"".$destinataire."\">
						</p></form></span><br>\n";
	return $formulaire;
}



// ADMIN
function liste_utilisateur_html($tableau,$tab_etat) {

	$tabretour = "
		<div class=\"title_box\">Liste des membres : ".sizeof($tableau)."</div>\n
	
				<form action=\"index.php?action=a_liste_membre\" method=\"GET\" class=\"formulaire_div\">
				<input class=\"input_recherche\" name=\"recherche\" type=\"text\" placeholder=\"recherche\" size=\"200\"> <input class=\"submit\" name=\"action\" type=\"submit\" value=\"chercher\">
				<input name=\"action\" type=\"hidden\" value=\"a_liste_membre\">
				</form><br><br><br>
	
	
				<table class=\"liste_dvd_tab\">
				
					<tr class=\"liste_dvd_ligne_titre\">
						<td>n&ordm;</td>
						<td>pseudo / etat</td>
						<td>email / nom</td>
						<td>date d'inscription</td>
					</tr>";
	
	for ($i = 0; $i < sizeof($tableau); $i ++) {
			if ($i%2==0) {
				$tabretour .= "<tr class=\"liste_dvd_ligne\">";
			} else {
				$tabretour .= "<tr class=\"liste_dvd_ligne2\">";
			}
			$tabretour .= "
							<td>".$tableau[$i]['id_utilisateur']."</td>
							<td><a href=\"index.php?action=profil&amp;id=".$tableau[$i]['id_utilisateur']."\">".$tableau[$i]['pseudo']."</a></td>
							<td>".$tableau[$i]['email']."</td>
							<td>".$tableau[$i]['date_inscription']."</td>
							</tr>";
			if ($i%2==0) {
				$tabretour .= "<tr class=\"liste_dvd_ligne\">";
			} else {
				$tabretour .= "<tr class=\"liste_dvd_ligne2\">";
			}
			$tabretour .= "
							<td></td>
							<td>".$tab_etat[$tableau[$i]['etat']]."</td>
							<td>".$tableau[$i]['nom']." ".$tableau[$i]['prenom']."</td>
							<td></td>
							</tr>
							";
	}
	
	$tabretour .= "</table>";
	return $tabretour;

}

function tab_genre_html($tab_genres) {
	$tab = "<div class=\"title_box\">Liste des genres</div>\n";
	for ($i=0 ; $i<sizeof($tab_genres);$i++) {
		$tab .= "<p>".$tab_genres[$i]['nom']."<br></p>";
	}
	return $tab;
	
}

// formulaire d'ajout de genre
function formulaire_ajout_genre() {
	$formulaire = "<div class=\"title_box\">Ajouter un genre</div>\n
						<form action = \"index.php?action=a_genre\" method = \"POST\" class=\"formulaire_div\"><p class=\"formtab\">\n
						<br><input type = \"text\" name = \"nvgenre\" size = \"30\"><br>\n
						<br><input type = \"submit\"  value = \"Ajouter\" class=\"form_button\">\n
						</p></form><br><br>\n";
	return $formulaire;
}




// CONTACT
// Fonction qui renvoie le code HTML du formulaire de contact
function formulaire_contact($mail, $objet, $messagetxt) {
	$formulaire = "<div class=\"title_box\">Contactez-nous</div>\n
						<form action = \"\" method = \"POST\" class=\"formulaire_div\"><p class=\"formtab\">\n
						<br>Votre email <br><input type = \"text\" value = \"".$mail."\" name = \"monMail\" size = \"30\"><br>\n
						<br>Votre objet <br><input type = \"text\" value = \"".$objet."\" name = \"objet\" size = \"30\"><br>\n
						<br>Votre message <br><textarea name=\"text\" cols=\"70\" rows=\"10\">".$messagetxt."</textarea><br>\n
						<br><br><input type = \"submit\"  value = \"Envoyer\" class=\"form_button\">\n
						</p></form><br>\n";
	return $formulaire;
}



// AUTRE

function loupe($style, $link) {

	if ($style <> 1)
		$ico = "loupe_plus";
	else
		$ico = "loupe_moins";

	$retour = "<div id=\"loupe\">
				<a href=\"$link\"><img src=\"".CHEMIN_IMAGES_RG."$ico.png\" title=\"Changer de vue\"></a>
			</div>";
	return $retour;
}



?>
