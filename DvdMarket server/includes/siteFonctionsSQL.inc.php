<?php

// Fonction de connexion à la base de donnée.
function connexion() {
$dbh = new PDO('mysql:host=localhost;dbname=projet','root','');
return $dbh;
}




// LOGIN
// Fonction qui vérifie l'utilisateur et le mot de passe associé (Login, modif)
function connexion_login($log, $mdp) {
	$dbh = connexion();
	$query = 'SELECT pseudo, email, mdp FROM utilisateurs WHERE pseudo='. $dbh->quote($log).' or email= '. $dbh->quote($log);
	$result = $dbh->query($query); 

	$verifie = false;
	if ($result->rowcount()!=0) {
		while (!$verifie && ($row = $result->fetch(PDO::FETCH_ASSOC))) {
			if (($log==$row['pseudo'] || $log==$row['email']) & sha1($mdp)==$row['mdp']) {
				$verifie = true;
			}
		}
	}	
	
	$dbh = null;
	return $verifie;
}

// Fonction qui renvoie l'id de l'utilisateur en recevant son adresse mail OU son pseudo. Sert lors de la connexion. (profil, modif)
function get_info_user($mailpseudo) {
	$dbh = connexion();
	$query = 'SELECT id_utilisateur, pseudo, email, etat FROM utilisateurs WHERE pseudo='.$dbh->quote($mailpseudo).' or email= '.$dbh->quote($mailpseudo);
	$result = $dbh->query($query); 

	$tab_info = array();	
	
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if ($mailpseudo==$row['pseudo'] || $mailpseudo==$row['email']) {
				$tab_info['id'] = $row['id_utilisateur'];
				$tab_info['pseudo'] = $row['pseudo'];
				$tab_info['mail'] = $row['email'];
				$tab_info['etat'] = $row['etat'];
			}
		}
	}	
	$dbh = null;
	return $tab_info;
}

// Fonction qui permet de récupérer le pseudo d'un membre
function get_pseudo($id) {
	$dbh = connexion();
	$query = 'SELECT id_utilisateur, pseudo FROM utilisateurs WHERE id_utilisateur='.$dbh->quote($id);
	$result = $dbh->query($query); 

	$pseudo = "";	
	
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if ($id==$row['id_utilisateur']) {
				$pseudo =  $row['pseudo'];
			}
		}
	}	
	$dbh = null;
	return $pseudo;
}

// Fonction qui vérifie si le paramètre a déjà été enregistré comme pseudo. (modif & inscription)
function deja_present_pseudo($pseudo) {
	$dbh = connexion();
	$query = 'SELECT pseudo FROM utilisateurs WHERE pseudo='. $dbh->quote($pseudo);
	$result = $dbh->query($query); 

	$verifie = false;
	if ($result->rowcount()!=0) 
		$verifie = true;
	else
		$verifie = false;
	$dbh = null;
	return $verifie;
}

// Fonction qui vérifie si le paramètre a déjà été enregistré comme adresse mail. (modif & inscription)
function deja_present_email($mail) {
	$dbh = connexion();
	$query = 'SELECT email FROM utilisateurs WHERE email='. $dbh->quote($mail);
	$result = $dbh->query($query); 

	$verifie = false;
	if ($result->rowcount()!=0) 
		$verifie = true;
	else
		$verifie = false;
	$dbh = null;
	return $verifie;
}

// Fonction qui renvoie true si l'utilisateur en paramètre a bien activé son compte (login)
function confirme($pseudomail) {
	$dbh = connexion();
	$query = 'SELECT email, pseudo, etat FROM utilisateurs WHERE pseudo='. $dbh->quote($pseudomail).' or email= '. $dbh->quote($pseudomail);
	$result = $dbh->query($query); 

	$verifie = false;
	if ($result->rowcount()!=0) {
		while (!$verifie && ($row = $result->fetch(PDO::FETCH_ASSOC))) {
			if ($row['etat']<>0 && ($pseudomail==$row['pseudo'] or $pseudomail==$row['email'])) {
				$verifie = true;
			}
		}
	}	
	$dbh = null;
	return $verifie;
}




// PROFIL
// Fonction qui renvoie un tableau avec toute les informations d'un utilisateur (profil)
function info_profil($id) {
// renvoye un  tableau des informations utilisateur
	$dbh = connexion();	
	$query = 'SELECT * FROM utilisateurs WHERE id_utilisateur='. $dbh->quote($id);
	$result = $dbh->query($query); 

	$tableau = array();	
	
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if ($id==$row['id_utilisateur']) {
				$tableau = array($row['id_utilisateur'],$row['nom'],$row['prenom'],$row['pseudo'],$row['mdp'],$row['email'],$row['date_inscription'],$row['etat'],$row['photo']);
			}
		}
	}	
	$dbh = null;
	return $tableau;
}

// Fonction qui mets à jour le mot de passe. (modif)
function set_pwd($psw, $id) {
	$dbh = connexion();
	$mdp = sha1($psw);
		
	$query = "UPDATE utilisateurs SET mdp =".$dbh->quote($mdp)." WHERE id_utilisateur=".$dbh->quote($id)." LIMIT 1";
	$dbh->prepare($query)->execute();
	$sol = $dbh;
	$dbh = null;
}

// Fonction qui met-à-jour les informations relatives à l'utilisateur courrant. (modif)
function modif_profil($nom, $prenom, $photo, $id) {
	$dbh = connexion();
	$query = "UPDATE utilisateurs SET nom =".$dbh->quote($nom).", prenom =".$dbh->quote($prenom).", photo =".$dbh->quote($photo)." WHERE id_utilisateur=".$dbh->quote($id)." LIMIT 1";
	$dbh->prepare($query)->execute();
	$sol = $dbh;
	$dbh = null;
}




// BOUTIQUE
// Fonction qui renvoie un tableau des produits soumis à la recherche. (boutique)
function get_boutique($recherche_genre, $recherche) {
	$dbh = connexion();
	
	$datex = date("Y-m-d H:i:s");  
	
	if ($recherche_genre <> "" ) {
		$query = "SELECT * FROM produits WHERE genre='$recherche_genre' AND (titre like '%$recherche%' OR realisateurs like '%$recherche%') AND date_fin >= '$datex' ORDER BY date_fin";
	} elseif ($recherche <> "" ) {
		$query = "SELECT * FROM produits WHERE date_fin >= '$datex' AND (titre like '%$recherche%' OR realisateurs like '%$recherche%' OR acteurs like '%$recherche%' OR support like '%$recherche%' OR langue like '%$recherche%' OR id_produit like '%$recherche%') ORDER BY date_fin";
	}else {
		$query = "SELECT * FROM produits WHERE date_fin >= '$datex' ORDER BY date_fin";
	}
	$result = $dbh->query($query); 
	
	$tableau = array();
	$i = 0;

	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			
			$tableau[$i] = array();
			$tableau[$i]['id_produit']=$row['id_produit'];
			$tableau[$i]['titre']=$row['titre'];
			$tableau[$i]['id_genre']=$row['genre'];
			$tableau[$i]['date_fin']=$row['date_fin'];
			$tableau[$i]['prix'] = get_prix_produit($row['id_produit']);
			$tableau[$i]['cover']=$row['cover'];
			$tableau[$i]['realisateurs']=$row['realisateurs'];
			$tableau[$i]['langue']=$row['langue'];
			$tableau[$i]['support']=$row['support'];
			$tableau[$i]['description']=$row['description'];
			$i++;
		}
	}	
	# pour debug : affichage ici possible de l'array à l'aide de print_r($tableau);
	# print_r($tableau);
	
	$dbh = null;
	return $tableau;
}

// Fonction qui rnevoie le tableau des produits d'un membre
function get_boutique_membre($id) {
	$dbh = connexion();
	
	$datex = date("Y-m-d H:i:s");  

	$query = "SELECT * FROM produits WHERE id_vendeur='$id' AND date_fin >= '$datex' ORDER BY date_fin";

	$result = $dbh->query($query); 
	
	$tableau = array();
	$i = 0;

	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			
			$tableau[$i] = array();
			$tableau[$i]['id_produit']=$row['id_produit'];
			$tableau[$i]['titre']=$row['titre'];
			$tableau[$i]['id_genre']=$row['genre'];
			$tableau[$i]['date_fin']=$row['date_fin'];
			$tableau[$i]['cover']=$row['cover'];
			$tableau[$i]['langue']=$row['langue'];
			$tableau[$i]['support']=$row['support'];
			$tableau[$i]['prix'] = get_prix_produit($row['id_produit']);
			$i++;
		}
	}	
	# pour debug : affichage ici possible de l'array à l'aide de print_r($tableau);
	# print_r($tableau);
	
	$dbh = null;
	return $tableau;
}




// GENRES
// Foncion qui renvoie un tableau des genres de films ainsi que des informations relatives. (index (menu))
function get_genres() {
	$dbh = connexion();
	
	$datex = date("Y-m-d H:i:s");  
	
	// $query = "SELECT * FROM genres";
	$query = "SELECT g.id_genre, g.nom, count(p.id_produit) FROM genres g, produits p WHERE p.genre = g.id_genre AND p.date_fin >= '$datex' GROUP BY 1,2";
	$result = $dbh->query($query); 
	
	$tableau = array();
	$i = 0;

	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$tableau[$i] = array();
			$tableau[$i]['id_genre']=$row['id_genre'];
			$tableau[$i]['nom']=$row['nom'];	
			$tableau[$i]['nb']=$row['count(p.id_produit)'];
			$i++;
		}
	}		
		
	$dbh = null;
	return $tableau;
}

// Fonction qui renvoie un tableau de tous les genres de films et leurs détails.
function get_all_genres() {
	$dbh = connexion();
	$query = "SELECT * FROM genres";
	$result = $dbh->query($query); 
	
	$tableau = array();
	$i = 0;

	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$tableau[$i] = array();
			$tableau[$i]['id_genre']=$row['id_genre'];
			$tableau[$i]['nom']=$row['nom'];	
			$i++;
		}
	}		
		
	$dbh = null;
	return $tableau;
}

// Fonction qui renvoie un tableau des differents noms de genre de films.
function get_tab_genres() {
	$dbh = connexion();
	$query = "SELECT * FROM genres";
	$result = $dbh->query($query); 
		
	$tab = "";
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$tab[$i] = array();
			$tab[$i]['nom'] = $row['nom'];
			$i++;
		}
	}		
	$dbh = null;
	return $tab;
}




// PANIER, MES_VENTES, MES_ACHATS
// Fonction qui renvoie un tableau de tous les produits présents dans le panier. (panier)
function get_panier($id_membre) {
	$dbh = connexion();
	
	$datex = date("Y-m-d H:i:s");
	
	$query = "SELECT p.* FROM produits p WHERE p.date_fin > '$datex' AND p.id_produit IN (SELECT e.id_produit FROM encheres e WHERE e.id_utilisateur='$id_membre') ORDER BY date_fin";
	$result = $dbh->query($query); 
	
	$tableau = array();	
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$tableau[$i] = array();
			
				$tableau[$i]['id_produit'] = $row['id_produit'];
				$tableau[$i]['id_vendeur'] = $row['id_vendeur'];
				$tableau[$i]['pseudo_vendeur'] = get_pseudo($row['id_vendeur']);
				$tableau[$i]['titre'] = $row['titre'];
				
				$tableau[$i]['prix_initial'] = $row['prix_initial'];
				$tableau[$i]['prix_enchere'] = get_prix_produit($row['id_produit']);
				
				if ($tableau[$i]['prix_enchere'] < $tableau[$i]['prix_initial'])
					$tableau[$i]['prix_enchere'] = $tableau[$i]['prix_initial'];
					
				$tableau[$i]['date_debut'] = $row['date_debut'];
				$tableau[$i]['date_fin'] = $row['date_fin'];
				$tableau[$i]['cover'] = $row['cover'];
				$i++;
		}
	}	
	$dbh = null;
	return $tableau;
}

// Fonction booleenne qui vérifie si l'utilisateur en paramètre est le dernier enrichisseur d'un produit. (mes_encheres)
function verif_encherisseur($id, $id_produit) {
	
	$dbh = connexion();
	$datex = date("Y:m:j");
	
	$query = "SELECT id_utilisateur FROM encheres WHERE id_produit='$id_produit'
		AND id_encheres=(SELECT MAX(id_encheres) FROM encheres WHERE id_produit='$id_produit')";
	
	$result = $dbh->query($query); 
	
	$sol = false;
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
//			echo $row['id_utilisateur'] . ", " . $row['maxi'] . " ";
			if ($id==$row['id_utilisateur'])
				$sol = true; 
		}
	}	
	$dbh = null;
	return $sol;

}

// Fonction qui renvoie le nombre d'encheres gagnees d'un utiulisateur
function nb_encheres_gagnees($id) {
	$tab = array();
	$tab['enchere_gagnante'] = 0;
	$tab['enchere_total'] = 0;

	$dated = date("Y-m-d H:i:s");  
	
	$dbh = connexion();
	//$query = "SELECT DISTINCT id_produit FROM encheres WHERE id_utilisateur='$id'";
	//$query = "SELECT DISTINCT id_produit FROM encheres WHERE id_utilisateur='$id' in (SELECT id_produit FROM produits WHERE date_fin > '$dated'";
	
	$query = "SELECT DISTINCT id_produit FROM encheres WHERE id_utilisateur='$id' AND id_produit in (SELECT id_produit FROM produits WHERE date_fin > '$dated')";
	$result = $dbh->query($query); 

	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if (get_acheteur($row['id_produit']) == $id)
				$tab['enchere_gagnante'] = ($tab['enchere_gagnante'] +1);
			$tab['enchere_total'] = ($tab['enchere_total'] +1);
		}
	}
		
	$dbh = null;
	return $tab;
}

// Fonction qui renvoye un  tableau des informations d'achat d'un utilisateur (mes_achats)
function tab_mes_achats($id_membre) {
	$dbh = connexion();
	
	$datex = date("Y-m-d H:i:s");
	
	$query = "SELECT * FROM produits WHERE date_fin < '$datex'";
	$result = $dbh->query($query); 
	
	$tableau = array();	
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if ($_SESSION['id'] == get_acheteur($row['id_produit'])) {
				$tableau[$i] = array();
				$tableau[$i]['id_produit']=$row['id_produit'];
				$tableau[$i]['titre']=$row['titre'];
				$tableau[$i]['date_fin']=$row['date_fin'];
				$tableau[$i]['prix'] = get_prix_produit($row['id_produit']);
				$tableau[$i]['id_vendeur'] = $row['id_vendeur'];
				$tableau[$i]['note'] = $row['note'];
				$tableau[$i]['cover']=$row['cover'];
				$i++;
			}
		}
	}	
	
	
	$dbh = null;
	return $tableau;
}

// Fonction qui renvoye un  tableau des informations de vente d'un utilisateur (mes_ventes)
function tab_mes_ventes($id_membre) {
	$dbh = connexion();
	$query = "SELECT * FROM produits WHERE id_vendeur='$id_membre' ORDER BY date_fin DESC";
	$result = $dbh->query($query); 
	
	$tableau = array();	
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
				$tableau[$i] = array();
				$tableau[$i]['id_produit']=$row['id_produit'];
				$tableau[$i]['titre']=$row['titre'];
				$tableau[$i]['date_fin']=$row['date_fin'];
				$tableau[$i]['prix'] = get_prix_produit($row['id_produit']);
				$tableau[$i]['id_acheteur'] = get_acheteur($row['id_produit']);
				$tableau[$i]['cover']=$row['cover'];
				$i++;
		}
	}	
	
	$dbh = null;
	return $tableau;
}




// MESSAGE(S)
// Fonction qui permet de rendre un message "lu"
function modif_etat_msg($idsession, $idmess) {

	$dbh = connexion();
	$query = "SELECT * FROM messages WHERE id_message = '$idmess'";
	$result = $dbh->query($query); 

	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if ($row['id_receveur'] == $idsession) {
					$query = "UPDATE messages SET lu='1' WHERE id_message='$idmess' LIMIT 1";
					$dbh->prepare($query)->execute();
			}
			
		}
	}		
		
	$dbh = null;
}

// Fonction qui permet d'enregistrer un nouveau message
function envoyer_msg($expediteur, $destinataire, $objet, $message) {

	$dbh = connexion();
	$dated = date("Y-m-d H:i:s");  
	# Solution d'INSERT avec quote
	$query = "INSERT INTO messages (id_message, id_receveur, id_envoyeur, objet, message, lu, date) 
					values ('NULL','$destinataire','$expediteur','$objet','$message','0','$dated')";
	$dbh->prepare($query)->execute();
	
	# ou Solution d'INSERT avec bindValue
	/*
	$query = 'insert into livres (titre, auteur) 
	          values (:titre,:auteur)';
	$qp = $dbh->prepare($query);
	$qp->bindValue(':titre',$titre);
	$qp->bindValue(':auteur',$auteur);
	$qp->execute();
	*/
	
	$dbh = null;	
}

// Fonction qui renvoie un tableau contennat le nombre de messages d'un utilisateur et le nombre de messages non lu parmi ceux-ci.
function messages_nonlu($id) {
	$tab = array();

	$dbh = connexion();
	$query = "SELECT count(id_message) FROM messages WHERE id_receveur = '$id' AND lu='false'";
	$result = $dbh->query($query); 

	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$tab['nonlu']=$row['count(id_message)'];
		}
	}		
		
	$query2 = "SELECT count(id_message) FROM messages WHERE id_receveur = '$id'";
	$result2 = $dbh->query($query2); 

	if ($result2->rowcount()!=0) {
		while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
			$tab['nbmsg']=$row2['count(id_message)'];
		}
	}		
		
	$dbh = null;
	return $tab;
}

// Fonction qui renvoie un tableau des messages d'un utilisateur
function tab_msg($id) {
	$tab = array();

	$dbh = connexion();
	$query = "SELECT * FROM messages WHERE id_receveur = '$id' or id_envoyeur = '$id' ORDER BY date";
	$result = $dbh->query($query); 

		$i = 0;
		
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			
			$tab[$i] = array();
			
			$tab[$i]['idm'] = $row['id_message'];
			$tab[$i]['id_receveur'] = $row['id_receveur'];
			$tab[$i]['objet'] = $row['objet'];		
			$tab[$i]['id_envoyeur'] = $row['id_envoyeur'];
			$tab[$i]['message'] = $row['message'];
			$tab[$i]['lu'] = $row['lu'];

			$i++;
		}
	}		
	
	$dbh = null;
	return $tab;
}

// Fonction qui renvoie les détails d'un message
function tab_info_msg($id) {

	$tab = array();

	$dbh = connexion();
	$query = "SELECT * FROM messages WHERE id_message='$id'";
	$result = $dbh->query($query); 
		
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				
			$tab['idm'] = $row['id_message'];
			$tab['id_receveur'] = $row['id_receveur'];
			$tab['id_envoyeur'] = $row['id_envoyeur'];
			$tab['objet'] = $row['objet'];		
			$tab['message'] = $row['message'];
			$tab['lu'] = $row['lu'];
			$tab['date'] = $row['date'];
		}
	}		
	
	$dbh = null;
	return $tab;
}




// INSCRIPTION
// Fonction qui permet d'enregistrer un nouveau utilisateur
function inscription($nom, $prenom, $pseudo, $mail, $codeacti, $mdpcrypte, $date) {

	$dbh = connexion();
			$query = "INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `pseudo`, `mdp`, `email`, `date_inscription`, `etat`, `activation`) 
						VALUES ('NULL', '$nom', '$prenom', '$pseudo', '$mdpcrypte', '$mail', '$date', '0', '$codeacti') " ;
			$result = $dbh->query($query); 

	$dbh = null;
	return true;
}

// Fonction qui permet d'activer un scompte
function activer_compte($code, $mail) {
	$dbh = connexion();
		
	$query = "SELECT * FROM utilisateurs WHERE email=".$dbh->quote($mail);
	$result = $dbh->query($query); 

	$tableau = array();	
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if ($row['activation'] == $code && $row['email'] == $mail) {
				$dbh2 = connexion();
				$query2 = "UPDATE utilisateurs SET etat =".$dbh2->quote(1)." WHERE email=".$dbh2->quote($mail)." LIMIT 1";
				$dbh2->prepare($query2)->execute();
				$dbh3 = connexion();
				$dated = date("Y-m-d H:i:s");
				$objet = "Bienvenue sur DvdMarket !";
				$message = "Felicitations, vous venez de vous inscrire avec succes sur le site DvdMarket.";
				$query3 = "INSERT INTO messages (id_message, id_receveur, id_envoyeur, objet, message, lu, date) 
					values ('NULL','".$row['id_utilisateur']."','".$row['id_utilisateur']."','$objet','$message','0','$dated')"; 
				$dbh3->prepare($query3)->execute();
				$dbh = null;
				$dbh2 = null;
				$dbh3 = null;
				return true;
			}
		}
	}

	$dbh = null;
	$dbh2 = null;
	return false;
}




// ACCUEIL
// Fonction qui renvoie un tableau des produits se finissant dans pans peu de temps
function tab_lm() {

	$datex = date("Y-m-d H:i:s");

	$dbh = connexion();
	$query = "SELECT * FROM produits WHERE date_fin > '$datex' ORDER BY date_fin";
	$result = $dbh->query($query); 

	$tableau = array();	
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$tableau[$i] = array();
				$tableau[$i]['id_produit'] = $row['id_produit'];
				$tableau[$i]['id_vendeur'] = $row['id_vendeur'];
				$tableau[$i]['titre'] = $row['titre'];
				$tableau[$i]['genre'] = $row['genre'];
				$tableau[$i]['realisateurs'] = $row['realisateurs'];
				$tableau[$i]['acteurs'] = $row['acteurs'];
				$tableau[$i]['duree'] = $row['duree'];
				$tableau[$i]['description'] = $row['description'];
				$tableau[$i]['support'] = $row['support'];
				$tableau[$i]['langue'] = $row['langue'];
				$tableau[$i]['prix'] = get_prix($row['id_produit']);
				$tableau[$i]['date_debut'] = $row['date_debut'];
				$tableau[$i]['date_fin'] = $row['date_fin'];
				$tableau[$i]['cover'] = $row['cover'];
				$i++;
		}
	}
	
	$dbh = null;
	return $tableau;
}

// Fonction qui renvoie un tableau des dernières produits ajoutée
function tab_derniers() {

	$datex = date("Y-m-d H:i:s");

	$dbh = connexion();
	$query = "SELECT * FROM produits WHERE date_fin > '$datex' ORDER BY date_debut DESC";
	$result = $dbh->query($query); 

	$tableau = array();	
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$tableau[$i] = array();
				$tableau[$i]['id_produit'] = $row['id_produit'];
				$tableau[$i]['id_vendeur'] = $row['id_vendeur'];
				$tableau[$i]['titre'] = $row['titre'];
				$tableau[$i]['genre'] = $row['genre'];
				$tableau[$i]['realisateurs'] = $row['realisateurs'];
				$tableau[$i]['acteurs'] = $row['acteurs'];
				$tableau[$i]['duree'] = $row['duree'];
				$tableau[$i]['description'] = $row['description'];
				$tableau[$i]['support'] = $row['support'];
				$tableau[$i]['langue'] = $row['langue'];
				$tableau[$i]['prix'] =get_prix($row['id_produit']);
				$tableau[$i]['date_debut'] = $row['date_debut'];
				$tableau[$i]['date_fin'] = $row['date_fin'];
				$tableau[$i]['cover'] = $row['cover'];
				$i++;
		}
	}
	
	$dbh = null;
	return $tableau;
}




// PRODUIT
// Fonction qui permet d'enregistrer une nouvelle enchère sur un produit.
function encherir($id_produit, $somme, $id_membre) {

	$dated = date("Y-m-d H:i:s");  
	$dbh1 = connexion();
	$query1 = "INSERT INTO encheres (id_encheres, id_utilisateur, id_produit, montant, date_enchere) 
					values ('NULL','$id_membre','$id_produit','$somme','$dated')";
	$dbh1->prepare($query1)->execute();
	$dbh1 = null;
}

// Fonction qui renvoie un tableau avec toute les enchères relatives à un produit.
function tab_encheres($id_produit) {
	$tab = array();

	$dbh = connexion();
	$query = "SELECT * FROM encheres WHERE id_produit='$id_produit' ORDER BY 1 DESC";
	$result = $dbh->query($query); 

	$i = 0;	
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$tab[$i] = array();
			$tab[$i]['id_utilisateur'] = $row['id_utilisateur'];
			$tab[$i]['montant'] = $row['montant'];		
			$tab[$i]['date'] = $row['date_enchere'];
			$i++;
		}
	}		
	
	$dbh = null;
	return $tab;
}

// Fonction qui permet de donner une note à u produit
function noter_produit($id_produit, $note) {
	$dbh = connexion();
		
	$query = "UPDATE produits SET note =".$dbh->quote($note)." WHERE id_produit=".$dbh->quote($id_produit)." LIMIT 1";
	$dbh->prepare($query)->execute();
	$sol = $dbh;
	$dbh = null;
}

// Fonction qui permet d'ajouter un film.
function ajouter_film($tab_info, $id) {
	$dated = date("Y-m-d H:i:s");  

	$dbh = connexion();
			$query = "INSERT INTO `produits` (`id_produit`, `id_vendeur`, `titre`, `genre`, `realisateurs`, `acteurs`, `duree`, `description`, `support`, `langue`, `prix_initial`, `date_debut`, `date_fin`, `cover`, `note`) 
									VALUES ('NULL', '$id', '".$tab_info['titre']."', '".$tab_info['genre']."', '".$tab_info['realisateur']."', '".$tab_info['acteurs']."', '".$tab_info['duree']."', '".$tab_info['description']."', '".$tab_info['support']."', '".$tab_info['langue']."', '".$tab_info['prix_initial']."', '$dated', '".$tab_info['date_fin']."', '".$tab_info['cover']."', '0')";
			$result = $dbh->query($query); 

	$dbh = null;
}

// Fonction qui renvoye un  tableau des informations du produit en paramètre. (produit)
function get_produit_detail($id) {
	$dbh = connexion();
	$query = 'SELECT * FROM produits WHERE id_produit='. $dbh->quote($id);
	$result = $dbh->query($query); 

	$tableau = array();	
	$i=0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if ($id==$row['id_produit']) {
				$tableau['id_produit'] = $row['id_produit'];
				$tableau['id_vendeur'] = $row['id_vendeur'];
				$tableau['pseudo_vendeur'] = get_pseudo($row['id_vendeur']);
				$tableau['titre'] = $row['titre'];
				$tableau['genre'] = $row['genre'];
				$tableau['realisateurs'] = $row['realisateurs'];
				$tableau['acteurs'] = $row['acteurs'];
				$tableau['duree'] = $row['duree'];
				$tableau['description'] = $row['description'];
				$tableau['support'] = $row['support'];
				$tableau['langue'] = $row['langue'];
				$tableau['note'] = $row['note'];
				$tableau['prix_initial'] = $row['prix_initial'];
				$tableau['prix_enchere'] = get_prix_produit($id);
				
				if ($tableau['prix_enchere'] < $tableau['prix_initial'])
					$tableau['prix_enchere'] = $tableau['prix_initial'];
				
				$tableau['date_debut'] = $row['date_debut'];
				$tableau['date_fin'] = $row['date_fin'];
				$tableau['cover'] = $row['cover'];
				$i++;
			}
		}
	}	
	
	$dbh = null;
	return $tableau;
}




// ADMIN
// Fonction qui renvoie un tableau avec les informations des membres
function liste_membre($recherche) {

	$dbh = connexion();
	if (!empty($recherche)) {
		$query = "SELECT * FROM utilisateurs WHERE pseudo like '%$recherche%'";
	} else {
		$query = "SELECT * FROM utilisateurs ORDER BY pseudo";
	}
	
	$result = $dbh->query($query); 

	$tableau = array();	
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$tableau[$i] = array();
				$tableau[$i]['id_utilisateur'] = $row['id_utilisateur'];
				$tableau[$i]['pseudo'] = $row['pseudo'];
				$tableau[$i]['nom'] = $row['nom'];
				$tableau[$i]['prenom'] = $row['prenom'];
				$tableau[$i]['email'] = $row['email'];
				$tableau[$i]['date_inscription'] = $row['date_inscription'];
				$tableau[$i]['etat'] = $row['etat'];
				$i++;
		}	
	}

	return $tableau;
}

// Permet d'ajouter un nouveau genre
function ajout_genre($nom) {
	$dbh = connexion();
			$query = "INSERT INTO `genres` (`id_genre`, `nom`) 
						VALUES ('NULL', '$nom')";
			$result = $dbh->query($query); 
	$dbh = null;
}




// AUTRE
// Renvoie le montant de la dernière enchère sur un produit.
function get_prix($id_produit) {
	$dbh = connexion();
	$query = "SELECT MAX(montant) FROM encheres WHERE id_produit='$id_produit'";
	$result = $dbh->query($query); 
		
	$prix = "";
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$prix = $row['MAX(montant)'];
		}
	
		if ($prix == null){
		$query = "SELECT prix_initial FROM produits WHERE id_produit='$id_produit'";
		$result = $dbh->query($query); 
		
		$prix = "";
		if ($result->rowcount()!=0) {
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$prix = $row['prix_initial'];
			}
		}
	}
	
	}

	return $prix;
}

// Renvoie l'id du membre qui a encheri le plus haut montant sur un produit.
function get_acheteur($id_produit) {
	$dbh = connexion();
	$query = "SELECT id_utilisateur FROM encheres WHERE id_produit='$id_produit' AND montant in (SELECT MAX(montant) FROM encheres WHERE id_produit='$id_produit')";
	$result = $dbh->query($query); 
		
	$id_acheteur = "";
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$id_acheteur = $row['id_utilisateur'];
		}
	}
	return $id_acheteur;
}

// Renvoie la montant max des enchères sur un produit en paramètre
function get_prix_produit($id_produit) {
	$dbh = connexion();
	$query = "SELECT MAX(montant) FROM encheres WHERE id_produit='$id_produit'";
	$result = $dbh->query($query); 
		
	$prix = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$prix = $row['MAX(montant)'];
		}
	} 
	
	if ($prix == "") {
		
		$query2 = "SELECT prix_initial FROM produits WHERE id_produit='$id_produit'";
		$result2 = $dbh->query($query2); 
		while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
			$prix = $row2['prix_initial'];
		}
	}
	$dbh = null;
	return $prix;
}

// Renvoie la note du compte en paramètre
function get_note_generale($id_membre) {

	$dbh = connexion();
	$query = "SELECT AVG(note) FROM produits WHERE id_vendeur='$id_membre' AND note<>'0'";
	$result = $dbh->query($query); 

	$note = 0;
	
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$note = $row['AVG(note)'];
		}
	}	
	$dbh = null;
	return $note;

}

// Renvoie le code de la prochaine cover qu'on peut ajouter.
function get_cover_code() {
	$dbh = connexion();
	$query = "SELECT MAX(id_produit) FROM produits";
	$result = $dbh->query($query); 

	$max = 0;
	
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$max = $row['MAX(id_produit)'];
		}
	}	
	$dbh = null;
	return ($max+1);

}

// Supprime les enchères non gagnantes
function delete_prod($id) {
	
	$dbh = connexion();
	$query = "SELECT id_encheres FROM encheres WHERE id_produit='$id' AND montant NOT IN (SELECT MAX(montant) FROM encheres WHERE id_produit='$id')";
	$result = $dbh->query($query); 
		
	$i = 0;
	if ($result->rowcount()!=0) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$idx = $row['id_encheres'];
			$dbh2 = connexion();
			$query2 = "DELETE FROM encheres WHERE id_encheres='$idx'";
			$dbh2->prepare($query2)->execute();
			$dbh2 = null;
			$i++;
		}
	}
	
	$dbh = null;
	return $i;
}

?>













