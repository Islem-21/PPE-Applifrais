<?php
/** 
 * Page d'accueil de l'application web AppliFrais
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");

  // page inaccessible si comptable non connecté
  if ( ! estVisiteurConnecte() ) 
  {
        header("Location: cSeConnecter.php");  
  }
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaireC.inc.php");
?>
  <div id="contenu">
      <h2>Bienvenue sur l'intranet GSB pour les comptables</h2>
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?>
