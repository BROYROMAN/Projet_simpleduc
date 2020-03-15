<?php

function actionEquipe($twig, $db){
    $form = array(); 
    $equipe = new Equipe($db);
    
   
    if(isset($_POST['btSupprimer'])){
        
        $cocher = $_POST['check'];
        $form['valide'] = true;
        foreach ( $cocher as $id){
          $exec=$equipe->delete($id); 
          if (!$exec){
             $form['valide'] = false;  
             $form['message'] = 'Problème de suppression dans la table equipe';   
          }
        }
    }
     if(isset($_GET['id'])){
        $exec=$equipe->delete($_GET['id']);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table équipe';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] = 'Equipe supprimée avec succès';
     }
    $liste = $equipe->select();
    
    echo $twig->render('equipe.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionEquipeAjout($twig, $db){
    $form = array(); 
    if (isset($_POST['btAjouter'])){
      $inputLibelle = $_POST['inputLibelle'];
      $inputIdResponsable = $_POST['inputIdResponsable']; 
      $form['valide'] = true;
      $equipe = new Equipe($db); 
      $exec = $equipe->insert($inputLibelle, $inputIdResponsable);
      if (!$exec){
        $form['valide'] = false;  
        $form['message'] = 'Problème d\'insertion dans la table équipe ';  
      }
    }
    else{
        $utilisateur = new Developpeur($db);
        $liste = $utilisateur->select();
        $form['liste'] = $liste;
    }
 
    echo $twig->render('equipe-ajout.html.twig', array('form'=>$form)); 
}

function actionEquipeModif($twig, $db){
    $form = array();   
    if(isset($_GET['id'])){
        $equipe = new Equipe($db);
        $uneEquipe = $equipe->selectById($_GET['id']);  
        
        if ($uneEquipe!=null){
            $form['equipe'] = $uneEquipe;
           
            $utilisateur = new Developpeur($db);
            $liste = $utilisateur->select();
            $form['liste'] = $liste;
            
        }
        else{
            $form['message'] = 'Equipe incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
          $id = $_POST['id'];  
          $libelle = $_POST['inputLibelle'];  
          $idResponsable = $_POST['inputIdResponsable'];
          $equipe = new Equipe($db);
          $exec = $equipe->update($id, $libelle, $idResponsable);
          if(!$exec){
                $form['valide'] = false;  
                $form['message'] .= 'Echec de la modification del\'équipe'; 
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
    
    echo $twig->render('equipe-modif.html.twig', array('form'=>$form));
}


// WebService
function actionEquipeWS($twig, $db){
   $equipe = new Equipe($db);
   $json = json_encode($liste = $equipe->select()); 
   echo $json; 
}


function actionEquipeDev($twig, $db){
    $form = array(); 
    $dev = new Developpeur($db);
     $equipe = new Equipe($db);
     $liste3=null;
     $libelle=null;
    if (isset($_POST['btAjouter'])){
     
      $libelle = $_POST['id']; 
      
      $equipe = new Equipe($db); 
      $exec = $equipe->selectByEquipe($libelle);
      $liste3=$equipe->selectByEquipe($libelle);
      
      if (!$exec){
        $form['valide'] = false;  
        $form['message'] = 'Problème d\'insertion dans la table équipe ';  
      }
    }elseif (isset($_POST['BtEnvoyer'])){     
       $tabl= print_r($_POST['nom']);
        
        var_dump($_POST['test2']);
       
// limite négative (depuis PHP 5.1)
       // print_r(explode('|', $tabl));    
       }
    else{
//        $utilisateur = new Equipe($db);
//        $liste = $utilisateur->select();
//        $form['liste'] = $liste;
    }
    
    
    $liste = $dev->selectByDev();
    $liste2=$equipe->select();
    echo $twig->render('equipedev.html.twig', array('form'=>$form,'liste'=>$liste,'liste2'=>$liste2,'liste3'=>$liste3,'id'=>$libelle));
}
