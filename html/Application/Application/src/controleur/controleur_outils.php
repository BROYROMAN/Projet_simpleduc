<?php

function actionOutils($twig, $db){
    $form = array(); 
    $outils = new Outils($db);
    
    if(isset($_GET['id'])){
        $exec=$outils->delete($_GET['id']);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table équipe';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] = 'Equipe supprimée avec succès';
     }
    
    $liste = $outils->selectoutils();
    
    echo $twig->render('outils.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionOutilsAjout($twig, $db){
    $form = array(); 
    if (isset($_POST['btAjouter'])){
      $libelle = $_POST['libelle'];
      $version = $_POST['version']; 
      $form['valide'] = true;
      $outils = new Outils($db); 
      $exec = $outils->insert($libelle, $version);
      if (!$exec){
        $form['valide'] = false;  
        $form['message'] = 'Problème d\'insertion dans la table outils ';  
      }
    }
    else{
        $outils = new Outils($db);
        $liste = $outils->selectoutils();
        $form['liste'] = $liste;
    }
 
    echo $twig->render('outils-ajout.html.twig', array('form'=>$form)); 
}

function actionOutilsModif($twig, $db){
    $form = array();   
    if(isset($_GET['id'])){
        $outils = new Outils($db);
        $uneEquipe = $outils->selectById($_GET['id']);  
        
        if ($uneEquipe!=null){
            $form['outils'] = $uneEquipe;
           
            $outils = new Outils($db);
            $liste = $outils->selectoutils();
            $form['liste'] = $liste;
            
        }
        else{
            $form['message'] = 'Equipe incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
          $id = $_POST['id'];  
          $libelle = $_POST['libelle'];  
          $version = $_POST['version'];
          $outils = new Outils($db);
          $exec = $outils->update($id, $libelle, $version);
          if(!$exec){
                $form['valide'] = false;  
                $form['message'] .= 'Echec de la modification de outils'; 
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
    
    echo $twig->render('outils-modif.html.twig', array('form'=>$form));
}


// WebService
function actionOutilsWS($twig, $db){
   $equipe = new Equipe($db);
   $json = json_encode($liste = $equipe->select()); 
   echo $json; 
}

