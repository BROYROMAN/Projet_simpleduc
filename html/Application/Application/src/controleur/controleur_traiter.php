<?php

function actionTraiter($twig, $db){
    $form = array(); 
    $traiter = new Traiter($db);
    $dev = new Developpeur($db);
    if(isset($_GET['id'])){
        $exec=$traiter->delete($_GET['id']);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table équipe';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] = 'Tache supprimée avec succès';
     }
    
    $liste = $traiter->select();
    $liste2 = $dev->select();
     
    
    echo $twig->render('traiter.html.twig', array('form'=>$form,'liste'=>$liste,'liste2'=>$liste2));
}

function actionTraiterAjout($twig, $db){
    $form = array(); 
    if (isset($_POST['btAjouter'])){
      $tache = $_POST['tache'];
      $dev = $_POST['dev']; 
      $nbheure = $_POST['nbheure']; 
      $form['valide'] = true;
      $traiter = new Traiter($db); 
      $exec = $traiter->insert($tache,$dev,$nbheure);
      var_dump($tache, $dev,$nbheure);
      if (!$exec){
        $form['valide'] = false;  
        $form['message'] = 'Problème d\'insertion dans la table équipe ';  
      }
    }
    else{
        $utilisateur = new Tache($db);
        $liste = $utilisateur->select();
        $form['liste'] = $liste;
        
        
        $dev = new Developpeur($db);
        $liste2 = $dev->select();
        $form['liste2'] = $liste2;
        
           
        
    }
 
    echo $twig->render('traiter-ajout.html.twig', array('form'=>$form)); 
}

function actionTraiterModif($twig, $db){
    $form = array();   
    if(isset($_GET['id'])){
        $traiter = new Traiter($db);
        $uneEquipe = $traiter->selectById($_GET['id']);  
        
        if ($uneEquipe!=null){
            $form['traiter'] = $uneEquipe;
           
            $utilisateur = new Tache($db);
            $liste = $utilisateur->select();
            $form['liste'] = $liste;
            
            
        $dev = new Developpeur($db);
        $liste2 = $dev->select();
        $form['liste2'] = $liste2;
        
        
        }
        else{
            $form['message'] = 'Traitements incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
      $id = $_POST['id'];  
      $tache = $_POST['tache'];
      $dev = $_POST['dev']; 
      $nbheure = $_POST['nbheure']; 
      $traiter = new Traiter($db);
          $exec = $traiter->update($id,$tache,$dev,$nbheure);
          if(!$exec){
                $form['valide'] = false;  
                $form['message'] = 'Echec de la modification de tache'; 
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
    
    echo $twig->render('traiter-modif.html.twig', array('form'=>$form));
}


// WebService
function actionTraiterWS($twig, $db){
   $equipe = new Equipe($db);
   $json = json_encode($liste = $equipe->select()); 
   echo $json; 
}

?>