<?php  
/** 
 * Script de contr�le et d'affichage du cas d'utilisation "Se d�connecter"
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  
  deconnecterVisiteur() ;  
  header("Location:cSeConnecter.php");
  
?>