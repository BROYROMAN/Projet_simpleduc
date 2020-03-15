<?php
function getPage($db){

// Inscrire vos contrôleurs ici    
$lesPages['accueil'] = "actionAccueil;0";
$lesPages['inscrire'] = "actionInscrire;0";
$lesPages['mentions'] = "actionMentions;0";
$lesPages['connexion'] = "actionConnexion;0";
$lesPages['deconnexion'] = "actionDeconnexion;0";
$lesPages['apropos'] = "actionApropos;0";
$lesPages['maintenance'] = "actionMaintenance;0";
$lesPages['utilisateur'] = "actionUtilisateur;1";
$lesPages['utilisateurmodif'] = "actionUtilisateurModif;1";
$lesPages['equipe'] = "actionEquipe;1";
$lesPages['equipedev'] = "actionEquipeDev;1";
$lesPages['equipeajout'] = "actionEquipeAjout;1";
$lesPages['equipemodif'] = "actionEquipeModif;1";
$lesPages['equipews'] = "actionEquipeWS;0";
$lesPages['utilisateurws']="actionUtilisateurWS;0";
$lesPages['projets'] = "actionProjet;0";
$lesPages['projetsajout'] = "actionProjetAjout;0";
$lesPages['projetsmodif'] = "actionProjetModif;0";
$lesPages['developpeurs'] = "actionDeveloppeur;0";
$lesPages['developpeursajout'] = "actionDeveloppeurAjout;0";
$lesPages['developpeursmodif'] = "actionDeveloppeurModif;0";
$lesPages['outils'] = "actionOutils;0";
$lesPages['outilsmodif'] = "actionOutilsModif;0";
$lesPages['outilsajout'] = "actionOutilsAjout;0";
$lesPages['contrat'] = "actionContrat;0";
$lesPages['contratmodif'] = "actionContratModif;0";
$lesPages['contratajout'] = "actionContratAjout;0";
$lesPages['tache'] = "actionTache;0";
$lesPages['tachemodif'] = "actionTacheModif;0";
$lesPages['tacheajout'] = "actionTacheAjout;0";
$lesPages['traiter'] = "actionTraiter;0";
$lesPages['traitermodif'] = "actionTraiterModif;0";
$lesPages['traiterajout'] = "actionTraiterAjout;0";
$lesPages['utilisateurpdf'] = "actionUtilisateurPdf;1";
$lesPages['listeutilisateurpdf'] = "actionListeUtilisateurPDF;0";
$lesPages['projetpdf'] = "actionProjetPdf;1";
$lesPages['listeprojetpdf'] = "actionListeProjetPDF;0";
$lesPages['listetachepdf'] = "actionListeTachePDF;0";
$lesPages['tachepdf'] = "actionTachePdf;1";
$lesPages['listetacheprojetpdf'] = "actionListeTacheProjetPDF;0";
$lesPages['tacheprojetpdf'] = "actionTacheProjetPdf;1";
$lesPages['loadEquipe'] = "actionLoadEquipe;1";
$lesPages['updateE'] = "actionUpdateE;1";
$lesPages['maitrise'] = "actionMaitrise;1";
$lesPages['loadOutils'] = "actionLoadOutils;1";
if ($db!=null){
  if(isset($_GET['page'])){
    // Nous mettons dans la variable $page, la valeur qui a été passée dans le lien
    $page = $_GET['page']; }
  else{
    // S'il n'y a rien en mémoire, nous lui donnons la valeur « accueil » afin de lui afficher une page
    //par défaut
    $page = 'accueil';
  }

  if (!isset($lesPages[$page])){
    // Nous rentrons ici si cela n'existe pas, ainsi nous redirigeons l'utilisateur sur la page d'accueil
    $page = 'accueil'; 
  }
  
  $explose = explode(";",$lesPages[$page]);
  $role = $explose[1];
  
  // Si le rôle nécessite de contrôler les droits
  if ($role != 0){
      // Nous vérifions que la personne est connectée
      if(isset($_SESSION['login'])){
        //Nous vérifions qu'elle a un rôle
        if(isset($_SESSION['role'])){
            
            if($role!=$_SESSION['role']){
               //Nous redigeons la personne vers la page d'acccueil car elle n'a pas le bon rôle 
               $contenu = 'actionAccueil';  
            }
            else{
               // La personne est autorisée à récupérer  
               $contenu = $explose[0]; 
            }
        }
        else{
           // Dans la session le rôle n'existe pas donc on va sur la page d'accueil 
           $contenu = 'actionAccueil'; 
        }
      }
      else{
        // La personne n'est pas connectée, donc on va sur la page d'accueil  
        $contenu = 'actionAccueil';  
      }
    }else{
      // Nous donnons du contenu non protégé  
      $contenu = $explose[0];   
    }
}
else{
   // La base de données n'est pas accessible
   $contenu = 'actionMaintenance';
}
// La fonction envoie le contenu
return $contenu; 

}
?>