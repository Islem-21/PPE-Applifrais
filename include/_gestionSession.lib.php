<?php
/** 
 * Regroupe les fonctions de gestion d'une session utilisateur.
 */

/** 
 * Nouvelle session.
 *
 */
function initSession() {
    session_start();
}

/** 
 * Affiche l'identifiant du visiteur connecté.                     
 *
 * Retourne l'id du visiteur connecté, une chaîne vide si pas de visiteur connecté.
 */
function obtenirIdUserConnecte() {
    $ident="";
    if ( isset($_SESSION["loginUser"]) ) {
        $ident = (isset($_SESSION["idUser"])) ? $_SESSION["idUser"] : '';   
    }  
    return $ident ;
}

/**
 * Conserve en variables session les informations du visiteur connecté
 * 
 * Conserve en variables session l'id $id et le login $login du visiteur connecté
 */
function affecterInfosConnecte($id, $login) {
    $_SESSION["idUser"] = $id;
    $_SESSION["loginUser"] = $login;
}

/** 
 * Déconnecte le visiteur qui s'est identifié sur le site.
 */
function deconnecterVisiteur() {
    unset($_SESSION["idUser"]);
    unset($_SESSION["loginUser"]);
}

/** 
 * Vérifie si un visiteur s'est connecté sur le site.                     
 *
 * Si un visiteur s'est identifié sur le site retourner true, sinon false .
 */
function estVisiteurConnecte() {
    // actuellement il n'y a que les visiteurs qui se connectent
    return isset($_SESSION["loginUser"]);
}
?>