<?php
// Démarrage de la session, elles doivent etre les première du fichier
session_start();
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Consulter une fiche de frais"
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if ( ! estVisiteurConnecte() ) {
      header("Location: cSeConnecter.php");  
  }
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaireC.inc.php");
                     
?>
<html>
<body>
<div name="gauche" style="clear:left:;float:left;width:18%; background-color:white; height:100%;">
<div name="coin" style="height:10%;text-align:center;"></div>

</div>
<div name="droite" style="float:left;width:80%;">
  <div name="haut" style="margin: 2 2 2 2 ;height:10%;float:left;"><h1>Validation des Frais</h1></div>  
  <div name="bas" style="margin : 10 2 2 2;clear:left;background-color:EE8844;color:black;height:88%;">

    <h1> Validation des frais par comptables </h1>

<?php

// Si le jour est supérieur à 8 de la date actuelle
if(date("d") > 8){
// Récupération de la date du mois précédent dans la variable $date
  $m = date("m") - 1; 
  $dateCloture =  date("Y") . "0" . $m;
  // On rajoute un 0 car le 0 s'enleve automatiquement quand on enleve 1 à $m.
// Envoie la requete pour cloturé les fiches du mois précédents
  $requeteCloture = "Update fichefrais Set idEtat = 'CL' where mois = '$dateCloture' AND idEtat = 'CR' "; 
  $reponseCloture = mysql_query($requeteCloture);
}

// ----------------------------------------------------------------------------------
?>

<!-- Formulaire du choix du visiteur -->
<form method="post" action="">
<!-- Liste déroulante avec le choix du visiteur dans un formulaire sans bouton-->
    <label class="titre">Choisir le visiteur :</label>
      <select name="lstVisiteur" class="zone">

        <?php
        // ----------REQUETE POUR AFFICHER LA LISTE DEROULANTE DES VISITEURS---------

        $requete = "Select * From visiteur Where type='1'";
        $reponse = mysql_query($requete);
        while($donnees = mysql_fetch_assoc($reponse)){
          echo "<option value =" . $donnees['id'] . ">" . $donnees['nom']  . "</option>";
        }

        // --------------------------------------------------------------------------

        ?>

    </select>
    <input type="submit" name="Choix" value="Choix un visiteur"/>
</form>

 <?php 
 // -------RECUPERATION DE LA DATE DANS UNE VARIABLE POUR LES REQUETES--------

  // Récupération de la date actuelle 
    $m = date("m");
    $date =  date("Y") .$m;

  // -------------------------------------------------------------------------

?>

<label class="titre">Mois :</label> <input class="zone" type="text" name="dateValid" size="12" value="<?php echo $date; ?>"/>
<form method="post" action="">

<?php
// Si on appui sur le bouton Choisir un visiteur
if(isset($_POST["Choix"])){

  // Récupération de l'ID du visiteur qu'à choisi l'utilisateur
  $choix = $_POST["lstVisiteur"];
  $_SESSION['id_du_Visiteur'] = $choix;


// ---------PARTIE REQUETE POUR LES FRAIS EN FORFAIT----------------

  // Requete pour afficher les repas qui ne sont pas validé c'est a dire les fiches Cloturé ou en cours de saisie
  // $requete2 = "Select * from lignefraisforfait where idVisiteur = '$choix' AND mois = $date AND idFraisForfait = 'REP' "; 
  $requete2 = "Select * from lignefraisforfait, fichefrais, Visiteur
                where Visiteur.id = fichefrais.idVisiteur
                AND fichefrais.idVisiteur = lignefraisforfait.idVisiteur
                AND fichefrais.idVisiteur = '$choix'
                AND lignefraisforfait.mois = $date
                AND lignefraisforfait.idFraisForfait = 'REP'
                AND fichefrais.idEtat = 'CR' OR 'CL' ";
  $reponse2 = mysql_query($requete2);
  $donnees2 = mysql_fetch_assoc($reponse2);

   // Requete pour afficher les Nuitée
  // $requete3 = "Select * from lignefraisforfait where idVisiteur = '$choix' AND mois = $date AND idFraisForfait = 'NUI' "; 
    $requete3 = "Select * from lignefraisforfait, fichefrais, Visiteur
                where Visiteur.id = fichefrais.idVisiteur
                AND fichefrais.idVisiteur = lignefraisforfait.idVisiteur
                AND fichefrais.idVisiteur = '$choix'
                AND lignefraisforfait.mois = $date
                AND lignefraisforfait.idFraisForfait = 'NUI'
                AND fichefrais.idEtat = 'CR' OR 'CL' ";
  $reponse3 = mysql_query($requete3);
  $donnees3 = mysql_fetch_assoc($reponse3);

   // Requete pour afficher les Etape
  // $requete4 = "Select * from lignefraisforfait where idVisiteur = '$choix' AND mois = $date AND idFraisForfait = 'ETP' "; 
    $requete4 = "Select * from lignefraisforfait, fichefrais, Visiteur
                where Visiteur.id = fichefrais.idVisiteur
                AND fichefrais.idVisiteur = lignefraisforfait.idVisiteur
                AND fichefrais.idVisiteur = '$choix'
                AND lignefraisforfait.mois = $date
                AND lignefraisforfait.idFraisForfait = 'ETP'
                AND fichefrais.idEtat = 'CR' OR 'CL' ";
  $reponse4 = mysql_query($requete4);
  $donnees4 = mysql_fetch_assoc($reponse4);

   // Requete pour afficher les Km
  // $requete5 = "Select * from lignefraisforfait where idVisiteur = '$choix' AND mois = $date AND idFraisForfait = 'KM' "; 
    $requete5 = "Select * from lignefraisforfait, fichefrais, Visiteur
                where Visiteur.id = fichefrais.idVisiteur
                AND fichefrais.idVisiteur = lignefraisforfait.idVisiteur
                AND fichefrais.idVisiteur = '$choix'
                AND lignefraisforfait.mois = $date
                AND lignefraisforfait.idFraisForfait = 'KM'
                AND fichefrais.idEtat = 'CR' OR 'CL' ";
  $reponse5 = mysql_query($requete5);
  $donnees5 = mysql_fetch_assoc($reponse5);


// Si les requetes pour les frais sont vides
  // IMPORTANT On imagine dans ce cas que si les frais ne sont pas entrer alors les hors forfait ne le sont pas aussi.
if($donnees2["quantite"] == "" & $donnees3["quantite"] == "" & $donnees4["quantite"] == "" & $donnees5["quantite"] == ""){

// Affiche un message pour informer qu'il n'y a pas de fiches
  echo "<br>Aucune fiche présente pour ce visiteur ou la fiche à déjà été validée.";
}else{

?>

    <p class="titre" />
    <div style="clear:left;"><h2>Frais au forfait </h2></div>
    <table style="color:black;" border="1">
      <tr><th>Repas midi</th><th>Nuitée </th><th>Etape</th><th>Km </th><th>Situation</th></tr>

      <tr align="center">
 

        <td width="80" ><input type="text" size="3" name="repas" value="<?php echo $donnees2['quantite'] ?>"/></td>
        <td width="80"><input type="text" size="3" name="nuitee" value = "<?php echo $donnees3['quantite'] ?>"/></td> 
        <td width="80"> <input type="text" size="3" name="etape" value = "<?php echo $donnees4['quantite'] ?>"/></td>
        <td width="80"> <input type="text" size="3" name="km" value = "<?php echo $donnees5['quantite'] ?>"/></td>
        <td width="80"> 


          <select size="3" name="situ">
            <option value="V">Valider</option>
            <option value="R">Refuser</option>
          </select></td>
        </tr>
    </table>


<?php
// -----------PARTIE POUR LES REQUETES HORS FORFAIT DES VISITEURS ET AFFICHAGE------------------

  // Requete pour afficher les hors forfait
  $requete6 = "Select * from lignefraishorsforfait where idVisiteur = '$choix' AND mois = '$date' "; 
  $reponse6 = mysql_query($requete6);
  //Récupération du résultat des fiches hors forfait
  $donnees6 = mysql_fetch_assoc($reponse6);
  //Variable vide pour tester en phase de validation
  $ValidationFicheHorsForfait = false;

  if(!empty($donnees6["libelle"])){

    echo "<p class='titre' /><div style='clear:left;'><h2>Hors Forfait</h2></div>
    <table style='color:black;' border='1'>
      <tr><th>Date</th><th>Libellé </th><th>Montant</th><th>Situation</th></tr>";


		 $i= 0;
		  $Tableau = array(); //Déclaration du tableau
		  $Lib = array();


		  // Tant qu'il y a des lignes à affiché
		  while($donnees6 = mysql_fetch_assoc($reponse6)){

		    $Lib[$i] = $donnees6["libelle"];

		    echo '<tr align="center"><td width="100" ><input type="text" size="12" name="hfDate1" value ="'.$donnees6['date'].'"/></td>';
		    echo '<td width="220"><input type="text" size="30" name="hfLib1" value ="'.$Lib[$i].'"/></td> ';
		    echo '<td width="90"> <input type="text" size="10" name="hfMont1" value ="'.$donnees6["montant"].'"/></td>';
		    echo ' <td width="80"> ';

		    echo '<select size="3" name="$Tableau[$i]">
		          <option value="V">Valider</option>
		          <option value="R">Refuser</option>
		          </select></td>
		        </tr>';

		    $i= $i + 1;
		
}
$ValidationFicheHorsForfait = true;
  		
  }else{
  		
  }



// ---------------------------------------------------------------------------------------------
?>
    </table>    

    <p class="titre"></p>
    <div class="titre">Nb Justificatifs</div><input type="text" class="zone" size="4" name="hcMontant"/>  
    <p class="titre" /><label class="titre">&nbsp;</label><input class="zone"type="reset" value="Effacer" />
    <input class="zone"type="submit" name="Valider" value="Valider" />
  </form>

<?php
}//Fin du else pour les frais


?>

<?php


}//Fin du IF

if(ISSET($_POST["Valider"])){
  $Resultat_Frais_Forfait = $_POST["situ"];


  foreach ($Tableau as $key => $value) {

      if($value == "R"){

        $Lib[$key] = "REFUSER" . $Lib[$key];

          // $requeteUpdt = "Update lignefraishorsforfait set libelle = '$Lib[$key]' "; 
          // $reponseUpdt = mysql_query($requeteUpdt);

      }
  
  }

// -----------PARTIE DES DIFFERENTS AFFICHAGE EN FONCTION DU CHOIX DU COMPTABLE-------------

if($Resultat_Frais_Forfait == "V" && $Resultat_Frais_Hors_Forfait == "V"){
  $validation =  $_SESSION['id_du_Visiteur'];
  $requete7 = "Update fichefrais Set idEtat = 'VA' where idVisiteur = '$validation' AND mois = '$date' "; 
  $reponse7 = mysql_query($requete7);
  

  echo "<br>La fiche du visiteur n°$validation à été validé.";
}
if($Resultat_Frais_Forfait == "V" && $Resultat_Frais_Hors_Forfait == "R"){
  echo "<br>Toutes les fiches hors forfait ne sont pas validés. Impossible de validés la fiche du visiteur n° $validation.";

}
if($Resultat_Frais_Forfait == "R" && $Resultat_Frais_Hors_Forfait == "V"){
  echo "<br>La fiche forfait n'est pas validés. Impossible de validés la fiche du visiteur n° $validation.";
}
if($Resultat_Frais_Forfait == "" && $Resultat_Frais_Hors_Forfait == "" && $ValidationFicheHorsForfait == true){
  echo "<br>Aucune n'est validée ni refusée, veuillez recommencez.";

}

if($Resultat_Frais_Forfait == "V" && $Resultat_Frais_Hors_Forfait == "" && $ValidationFicheHorsForfait == true){
  echo "<br>Les frais hors forfait n'ont pas de valeur, veuillez recommencez.";

}

if($Resultat_Frais_Forfait == "R" && $Resultat_Frais_Hors_Forfait == "" && $ValidationFicheHorsForfait == true){
  echo "<br>Les frais hors forfait n'ont pas de valeur, veuillez recommencez.";

}


if($Resultat_Frais_Forfait == "V" && $Resultat_Frais_Hors_Forfait == "" && $ValidationFicheHorsForfait == false){
$validation =  $_SESSION['id_du_Visiteur'];
  $requete7 = "Update fichefrais Set idEtat = 'VA' where idVisiteur = '$validation' AND mois = '$date' "; 
  $reponse7 = mysql_query($requete7);

  $destinataire= 'zacchero@hotmail.fr';
  $message= 'salut';
  
if (mail($destinataire, 'test', $message)) // Envoi du message
{
    echo 'Votre message a bien été envoyé ';
}
else // Non envoyé
{
    echo "Votre message n'a pas pu être envoyé";
}

  
  echo "<br>La fiche du visiteur n°$validation à été validé.";

}

if($Resultat_Frais_Forfait == "R" && $Resultat_Frais_Hors_Forfait == "" && $ValidationFicheHorsForfait == false){
$validation =  $_SESSION['id_du_Visiteur'];
  $requete7 = "Update fichefrais Set idEtat = 'VA' where idVisiteur = '$validation' AND mois = '$date' "; 
  $reponse7 = mysql_query($requete7);

  $destinataire= 'zacchero@hotmail.fr';
  $message= 'salut';
  $objet = 'Test'; 
  $messagefutur= mysql_query($requete7);
  
if (mail($destinataire, $objet, $message)) // Envoi du message
{
    echo 'Votre message a bien été envoyé ';
}
else // Non envoyé
{
    echo "Votre message n'a pas pu être envoyé";
}
  
  echo "<br>La fiche du visiteur n°$validation à été validé.";

}


if($Resultat_Frais_Forfait == "" && $Resultat_Frais_Hors_Forfait == "V"){
  echo "<br>Les frais en forfait n'ont pas de valeur, veuillez recommencez.";

}

if($Resultat_Frais_Forfait == "" && $Resultat_Frais_Hors_Forfait == "R"){
  echo "<br>Les frais en forfait n'ont pas de valeur, veuillez recommencez.";

}


// ----------------------------------------------------------------------------------------

}

?>

</div>
</div>
</body>
</html>
  <!-- Fin de la division principal -->

<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?> 
