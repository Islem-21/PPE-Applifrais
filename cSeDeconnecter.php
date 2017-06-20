<?php  
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Se déconnecter"
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  
  deconnecterVisiteur() ;  
  header("Location:cSeConnecter.php");
  
?>