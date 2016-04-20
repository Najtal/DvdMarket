<?php

// Valide une adresse mail
function valider($email) {
	if (preg_match('/^([a-zA-Z0-9]+(([\.\-\_]?[a-zA-Z0-9]+)+)?)\@(([a-zA-Z0-9]+[\.\-\_])+[a-zA-Z]{2,4})$/', $email)) {
		return true;
	}
	return false;
}	

// valide si un texte n'est pas trop long
function valider_text($text) {
	if(strlen($text) > 254){
		return false;
	}
	if (preg_match('/^(([a-zA-Z0-9]+)[\,\.\"\'\:\ ]*)+$/', $text)) {
		return true;
	}
	return false;
}	

// valide si une description est "correctement" &eacute;crite
/*function valider_description($text){
if(strlen($text) > 4096){
		return false;
	}
	if (preg_match('/^([a-zA-Z0-9\?\,\.\"\'\:\ \;\/\\\+\-\*\(\)\é\à\è\ê\ë\ï\ö\ç\î\ô]+)$/', $text)) {
		return true;
	}
	return false;
}*/

function valider_description($text){
	if(strlen($text) > 4096){
		return false;
	}
		return true;
}

// valide si le format d'une dur&eacute;e est correctement entr&eacute;
function valider_duree($duree) {
	if (preg_match('/^([0-9]{1,2}\:[0-5]{1,1}[0-9]{1,1})|([0-9]{1,2}\:[0-6]{1,1}[0-9]{1,1}\:[0-9]{0,2})$/', $duree)) {
		return true;
	}
	return false;
}	

// enlève les \ de 
//function reload_description($description)

//valide une entr&eacute;e chiffr&eacute;e pour ench&eacute;rir
function valider_chiffre($chiffre){

	if (preg_match('/^([1-9]+)([0-9]*)$|(^[0]{1,1}$)/',$chiffre)){
		return $chiffre;
	}
	if (preg_match('/(^[0-9]+)([\,\.]{1,1})([0-9]{0,2})$/', $chiffre)) {
		if(preg_match('/^([0-9]*)\,([0-9]{1,2})$/',$chiffre,$result)){
			$chiffre = "".$result[1].".".$result[2]."";
			return $chiffre;
		}
		return $chiffre;
	}
	return false;
}

//recupère l'extension du nom d'un fichier
function extension_de($string){
	if (preg_match('/^([a-zA-Z0-9\?\,\!\"\'\:\_\ \+\-\*\é\à\è\ê\ë\ï\ö\ç\î\ô]+)([\.]{1,1})([a-zA-Z]{3,4})$/', $string,$result)) {
		if(extension_valide($result[3])){
			return $result[3];
		}
	}
	return "probleme";
}

// v&eacute;rifie si l'extension de l'image est correcte
function extension_valide($extension){
	$tabExtension = array('jpeg','jpg','gif','jfif','bmp','png','dib','jpe','tif','tiff');
	for($i=0; $i < sizeof($tabExtension); $i++){
		if($extension == $tabExtension[$i])
			return true;
	}
	return false;
}

// Renvoie l'&eacute;tat (String) du compte.
function etat_profil($num, $tab_etat) {
	if ($num < 3 && $num >= 0)
		return $tab_etat[$num];
	return "erreur";
}


// Recherche une adresse URL de recherche d'un cover de film
/*function get_url_search_cover($titre){
	$titre = valider_text($titre);
	$url = "http://be.bing.com/images/search?q=cover";
	if(preg_match('/^(([a-zA-Z0-9]*)([\ ])+)$/',$titre,$result)){
			for($i=1; $i< rowcount($result); $i++){
				$url .= "+".$result[$i];
			}
		
	}
	$url .= "&qs=ds&form=QBLH&filt=all#x0y0";
	return $url;
	
}*/

// FONCTIONS QUI CALCULE LE TEMPS RESTANT

function Date_ConvertSqlTab($date_sql) {
    $jour = substr($date_sql, 8, 2);
    $mois = substr($date_sql, 5, 2);
    $annee = substr($date_sql, 0, 4);
    $heure = substr($date_sql, 11, 2);
    $minute = substr($date_sql, 14, 2);
    $seconde = substr($date_sql, 17, 2);
    
    $key = array('annee', 'mois', 'jour', 'heure', 'minute', 'seconde');
    $value = array($annee, $mois, $jour, $heure, $minute, $seconde);
    
    $tab_retour = array_combine($key, $value);
    
    return $tab_retour;
}

function AuPluriel($chiffre) {
    if($chiffre>1) {
        return 's';
    };
}

function TimeToJourJ($date_sql) {
    $tab_date = Date_ConvertSqlTab($date_sql);
    $mkt_jourj = mktime($tab_date['heure'],
                    $tab_date['minute'],
                    $tab_date['seconde'],
                    $tab_date['mois'],
                    $tab_date['jour'],
                    $tab_date['annee']);

    $mkt_now = time();
    
    $diff = $mkt_jourj - $mkt_now;
    
    $unjour = 3600 * 24;
    
    if($diff>=$unjour) {
        // EN JOUR
        $calcul = $diff / $unjour;
        return ceil($calcul).' jour'.AuPluriel($calcul);

    } elseif($diff<$unjour && $diff>=0 && $diff>=3600) {
        // EN HEURE
        $calcul = $diff / 3600;
        return ceil($calcul).' heure'.AuPluriel($calcul);

    } elseif($diff<$unjour && $diff>=0 && $diff<3600) {
        // EN MINUTES
        $calcul = $diff / 60;
        return ceil($calcul).' minute'.AuPluriel($calcul);

    } elseif($diff<0 && abs($diff)<3600) {
        // DEPUIS EN MINUTES
        $calcul = abs($diff) / 60;
        return ceil($calcul).' minute'.AuPluriel($calcul);

    } elseif($diff<0 && abs($diff)<=3600) {
        // DEPUIS EN HEURES
        $calcul = abs($diff) / 3600;
        return ceil($calcul).' heure'.AuPluriel($calcul);        

    } else {
        // DEPUIS EN JOUR
        $calcul = abs($diff) / $unjour;
        return ceil($calcul).' jour'.AuPluriel($calcul);

    }
}

?>
