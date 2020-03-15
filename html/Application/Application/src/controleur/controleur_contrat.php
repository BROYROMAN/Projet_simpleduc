<?php

function actionContrat($twig, $db){
    $form = array(); 
    $contrat = new Contrat($db);
    
    if(isset($_GET['id'])){
        $exec=$contrat->delete($_GET['id']);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table équipe';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] = 'Equipe supprimée avec succès';
     }
    
    $liste = $contrat->selectcontrat();
    
    echo $twig->render('contrat.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionContratAjout($twig, $db){
    $form = array(); 
    if (isset($_POST['btAjouter'])){
      $nom = $_POST['nom'];
      $datesignature = $_POST['datesignature']; 
      $delaiproduction = $_POST['delaiproduction'];
      $coutglobal = $_POST['coutglobal']; 
      $form['valide'] = true;
      $contrat = new Contrat($db); 
      $exec = $contrat->insert($nom, $datesignature,$delaiproduction,$coutglobal);
      if (!$exec){
        $form['valide'] = false;  
        $form['message'] = 'Problème d\'insertion dans la table outils ';  
      }
    }
    else{
        $contrat = new Contrat($db);
        $liste = $contrat->selectcontrat();
        $form['liste'] = $liste;
    }
 
    echo $twig->render('contrat-ajout.html.twig', array('form'=>$form)); 
}

function actionContratModif($twig, $db){
    $form = array();   
    if(isset($_GET['id'])){
        $contrat = new Contrat($db);
        $uneEquipe = $contrat->selectById($_GET['id']);  
        
        if ($uneEquipe!=null){
            $form['contrat'] = $uneEquipe;
           
            $contrat = new Contrat($db);
            $liste = $contrat->selectcontrat();
            $form['liste'] = $liste;
            
        }
        else{
            $form['message'] = 'Equipe incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
       $id=$_POST['id'];
      $nom = $_POST['nom'];
      $datesignature = $_POST['datesignature']; 
      $delaiproduction = $_POST['delaiproduction'];
      $coutglobal = $_POST['coutglobal']; 
          $contrat = new Contrat($db);
          $exec = $contrat->update($id,$nom, $datesignature,$delaiproduction,$coutglobal);
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
    
    echo $twig->render('contrat-modif.html.twig', array('form'=>$form));
}


// WebService
function actionContratWS($twig, $db){
   $equipe = new Equipe($db);
   $json = json_encode($liste = $equipe->select()); 
   echo $json; 
}

?>