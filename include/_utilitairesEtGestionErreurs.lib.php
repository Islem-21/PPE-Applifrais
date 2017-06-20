<?php
/** 
 * Regroupe les fonctions utilitaires et de gestion des erreurs.
 */

/** 
 * Affiche le libellé en français correspondant à un numéro de mois.                     
 *
 * Fournit le libellé français du mois de numéro $unNoMois.
 * Retourne une chaîne vide si le numéro n'est pas compris dans l'intervalle [1,12].
 */
function obtenirLibelleMois($unNoMois) {
    $tabLibelles = array(1=>"Janvier", 
                            "Février", "Mars", "Avril", "Mai", "Juin", "Juillet",
                            "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    $libelle="";
    if ( $unNoMois >=1 && $unNoMois <= 12 ) {
        $libelle = $tabLibelles[$unNoMois];
    }
    return $libelle;
}

/** 
 * Vérifie si une chaîne fournie est bien une date valide, au format JJ/MM/AAAA.                     
 * 
 * Retourne true si la chaîne $date est une date valide, au format JJ/MM/AAAA, false sinon.
 */ 
function estDate($date) {
	$tabDate = explode('/',$date);
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    elseif (!verifierEntiersPositifs($tabDate)) {
        $dateOK = false;
    }
    elseif (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
        $dateOK = false;
    }
    else {
        $dateOK = true;
    }
	return $dateOK;
}

/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
*/
function convertirDateFrancaisVersAnglais($date){
	@list($jour,$mois,$annee) = explode('/',$date);
	return date("Y-m-d", mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Conversion une date au format format anglais aaaa-mm-jj vers le format 
 * français jj/mm/aaaa
*/
function convertirDateAnglaisVersFrancais($date){
    @list($annee,$mois,$jour) = explode('-',$date);
	return date("d/m/Y", mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Verifie si une date est incluse ou non dans l'année écoulée.
 * 
 * Retourne true si la date $date est comprise entre la date du jour moins un an et la 
 * la date du jour, sinon False.
*/
function estDansAnneeEcoulee($date) {
	$dateAnglais = convertirDateFrancaisVersAnglais($date);
	$dateDuJourAnglais = date("Y-m-d");
	$dateDuJourMoinsUnAnAnglais = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1));
	return ($dateAnglais >= $dateDuJourMoinsUnAnAnglais) && ($dateAnglais <= $dateDuJourAnglais);
}

/** 
 * Vérifie si une chaîne est bien numérique avec chiffres positifs                     
 * 
 * Retourne true si la valeur transmise $valeur ne contient pas d'autres 
 * caractères que des chiffres, false sinon.
 */ 
function estEntierPositif($valeur) {
    return preg_match("/[^0-9]/", $valeur) == 0;
}

/** 
 * Vérifie que chaque valeur est bien renseignée et numérique avec des chiffres positifs.
 *  
 * Retourne true si toutes les valeurs sont bien renseignées et
 * numériques avec des chiffres positifs. Sinon false si au moins une de ces valeurs ne l'est pas.
 */ 
function verifierEntiersPositifs($lesValeurs){
    $ok = true;     
    foreach ( $lesValeurs as $val ) {
        if ($val=="" || ! estEntierPositif($val) ) {
            $ok = false;
        }
    }
    return $ok; 
}

/** 
 * Affiche la valeur d'une donnée transmise par la méthode get
 * 
 * Affiche la valeur de la donnée portant le nom $nomDonnee reçue dans l'url, 
 * $valDefaut si aucune donnée de nom $nomDonnee dans l'url 
 */ 
function lireDonneeUrl($nomDonnee, $valDefaut="") {
    if ( isset($_GET[$nomDonnee]) ) {
        $val = $_GET[$nomDonnee];
    }
    else {
        $val = $valDefaut;
    }
    return $val;
}

/** 
 * Affiche la valeur d'une donnée transmise par la méthode post                    
 * 
 * Affiche la valeur de la donnée portant le nom $nomDonnee reçue dans le corps de la requête http, 
 * $valDefaut si aucune donnée de nom $nomDonnee dans le corps de requête
 */ 
function lireDonneePost($nomDonnee, $valDefaut="") {
    if ( isset($_POST[$nomDonnee]) ) {
        $val = $_POST[$nomDonnee];
    }
    else {
        $val = $valDefaut;
    }
    return $val;
}

/** 
 * Affiche la valeur d'une donnée transmise par la méthode get ou post
 * 
 * Affiche la valeur de la donnée portant le nom $nomDonnee reçue dans l'url ou corps de requête, 
 * $valDefaut si aucune donnée de nom $nomDonnee ni dans l'url, ni dans corps.
 * Si le même nom a été transmis à la fois dans l'url et le corps de la requête,
 * c'est la valeur transmise par l'url qui est retournée.
 */ 
function lireDonnee($nomDonnee, $valDefaut="") {
    if ( isset($_GET[$nomDonnee]) ) {
        $val = $_GET[$nomDonnee];
    }
    elseif ( isset($_POST[$nomDonnee]) ) {
        $val = $_POST[$nomDonnee];
    }
    else {
        $val = $valDefaut;
    }
    return $val;
}

/**
 * Ajoute un message d'erreurs.
 *
 * Ajoute le message $msg en fin de tableau $tabErr. Ce tableau est passé par 
 * référence afin que les modifications sur ce tableau soient visibles de l'appelant.
 */
function ajouterErreur(&$tabErr,$msg) {
    $tabErr[count($tabErr)]=$msg;
}

/** 
 * Affiche le nombre de messages d'erreurs enregistrés.                    
 * 
 * Affiche le nombre de messages d'erreurs enregistrés dans le tableau $tabErr.
 */ 
function nbErreurs($tabErr) {
    return count($tabErr);
}
 
/** 
 * Affiche les messages d'erreurs sous forme d'une liste à puces HTML.                    
 * 
 * Affiche le source HTML, division contenant une liste à puces, d'après les
 * messages d'erreurs contenus dans le tableau des messages d'erreurs $tabErr.
 */ 
function toStringErreurs($tabErr) {
    $str = '<div class="erreur">';
    $str .= '<ul>';
    foreach($tabErr as $erreur){
        $str .= '<li>' . $erreur . '</li>';
	}
    $str .= '</ul>';
    $str .= '</div>';
    return $str;
} 

/** 
 * Filtre les caractères considérés spéciaux en HTML par les entités HTML correspondantes.
 *  
 * Renvoie une copie de la chaîne $str à laquelle les caractères considérés spéciaux
 * en HTML (tq la quote simple, le guillemet double, les chevrons), auront été
 * remplacés par les entités HTML correspondantes.
 */ 
function filtrerChainePourNavig($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/** 
 * Vérifie la validité des données d'une ligne de frais hors forfait.
 *  
 * Renseigne le tableau des messages d'erreurs d'après les erreurs rencontrées
 * sur chaque donnée d'une ligne de frais hors forfait : vérifie que chaque 
 * donnée est bien renseignée, le montant est numérique positif, la date valide
 * et dans l'année écoulée.
 */ 
function verifierLigneFraisHF($date, $libelle, $montant, &$tabErrs) {
    // vérification du libellé 
    if ($libelle == "") {
		ajouterErreur($tabErrs, "Le libellé doit être renseigné.");
	}
	// vérification du montant
	if ($montant == "") {
		ajouterErreur($tabErrs, "Le montant doit être renseigné.");
	}
	elseif ( !is_numeric($montant) || $montant < 0 ) {
        ajouterErreur($tabErrs, "Le montant doit être numérique positif.");
    }
    // vérification de la date d'engagement
	if ($date == "") {
		ajouterErreur($tabErrs, "La date d'engagement doit être renseignée.");
	}
	elseif (!estDate($date)) {
		ajouterErreur($tabErrs, "La date d'engagement doit être valide au format JJ/MM/AAAA");
	}	
	elseif (!estDansAnneeEcoulee($date)) {
	    ajouterErreur($tabErrs,"La date d'engagement doit se situer dans l'année écoulée");
    }
}
?>