<?php

function actionTache($twig, $db){
    $form = array(); 
    $tache = new Tache($db);
    
    if(isset($_GET['id'])){
        $exec=$tache->delete($_GET['id']);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table équipe';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] = 'Tache supprimée avec succès';
     }
    $projet = new Projet($db);
    $liste = $tache->select();
     $liste2 = $projet->select();
    
    echo $twig->render('tache.html.twig', array('form'=>$form,'liste'=>$liste,'liste2'=>$liste2));
}

function actionTacheAjout($twig, $db){
    $form = array(); 
    if (isset($_POST['btAjouter'])){
      $libelle = $_POST['libelle'];
      $heureprevue = $_POST['heureprevue']; 
      $nom = $_POST['idP']; 
      $cout = $_POST['cout']; 

      $form['valide'] = true;
      $tache = new Tache($db); 
      $exec = $tache->insert($libelle, $heureprevue,$nom,$cout);
      var_dump($libelle, $heureprevue,$nom,$cout);
      if (!$exec){
        $form['valide'] = false;  
        $form['message'] = 'Problème d\'insertion dans la table équipe ';  
      }
    }
    else{
        $utilisateur = new Projet($db);
        $liste = $utilisateur->select();
        $form['liste'] = $liste;
        
    }
 
    echo $twig->render('tache-ajout.html.twig', array('form'=>$form)); 
}

function actionTacheModif($twig, $db){
    $form = array();   
    if(isset($_GET['id'])){
        $tache = new Tache($db);
        $uneEquipe = $tache->selectById($_GET['id']);  
        
        if ($uneEquipe!=null){
            $form['tache'] = $uneEquipe;
           
            $utilisateur = new Projet($db);
            $liste = $utilisateur->select();
            $form['liste'] = $liste;
            
        }
        else{
            $form['message'] = 'Tache incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
          $id = $_POST['id'];  
          $libelle = $_POST['libelle'];  
          $heureprevue = $_POST['heureprevue'];
           $nom = $_POST['idp'];
           $cout = $_POST['cout'];
          $tache = new Tache($db);
          $exec = $tache->update($id,$libelle, $heureprevue,$nom,$cout);
          if(!$exec){
                $form['valide'] = false;  
                $form['message'] .= 'Echec de la modification de tache'; 
          }
          else{
            $form['valide'] = true;  
            $form['message'] = 'Modification réussie';  
          } 
          
        }
        else{
            $form['message'] = 'Utilisateur non précisé';
        }    
     
    }
    
    echo $twig->render('tache-modif.html.twig', array('form'=>$form));
}


// WebService
function actionTacheWS($twig, $db){
   $equipe = new Equipe($db);
   $json = json_encode($liste = $equipe->select()); 
   echo $json; 
}

?>