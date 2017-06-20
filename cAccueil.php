<?php
/** 
 * Page d'accueil AppliFrais
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if ( ! estVisiteurConnecte() ) 
  {
        header("Location: cSeConnecter.php");  
  }
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
?>

  <div id="contenu">
      <h2>Bienvenue sur l'intranet GSB pour les visiteurs</h2>
  </div>
<?php        
  
  require($repInclude . "_fin.inc.php");
?>
