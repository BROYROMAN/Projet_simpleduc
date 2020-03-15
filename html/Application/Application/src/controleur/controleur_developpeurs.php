<?php

function actionDeveloppeur($twig, $db){
    $form = array(); 
    $dev = new Developpeur($db);
     $outils = new Outils($db);
     $equipe = new Equipe($db);
    if(isset($_GET['codedev'])){
        $exec=$dev->delete($_GET['codedev']);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table projet';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] = 'Projet supprimée avec succès';
     }
    
    $liste = $dev->select();
    
    $liste2=$outils->selectoutils();
    $liste3=$equipe->select();
    echo $twig->render('developpeurs.html.twig', array('form'=>$form,'liste'=>$liste,'liste2'=>$liste2,'liste3'=>$liste3));
}

function actionMaitrise($twig, $db){
   
    $dev = new Outils($db);
    $liste=$dev->selectoutils(); 
    
     $dev1 = new Developpeur($db); 
      $listedev = $dev1->select();
        
    echo $twig->render('maitrise.html.twig', array('liste'=>$liste,'liste2'=>$listedev));
}

function actionDeveloppeurAjout($twig, $db){
    $form = array(); 
    if (isset($_POST['btAjouter'])){
      $nom = $_POST['nom'];
      $prenom = $_POST['prenom']; 
      $datenaissance = $_POST['datenaissance']; 
      $tel = $_POST['tel']; 
      $adresse = $_POST['adresse']; 
      $remuneration = $_POST['remuneration']; 
      $couthoraire = $_POST['couthoraire']; 
      $equipe = $_POST['idEquipe']; 
      
      $form['valide'] = true;
      $dev = new Developpeur($db); 
      $exec = $dev->insert($nom,$prenom,$datenaissance,$tel,$adresse,$remuneration,$couthoraire,$equipe);
     //$dev->insert($nom, $ prenom, $datenaissance, $tel, $adresse, $remuneration, $couthoraire, $equipe, $outils);
      
      if (!$exec){
        $form['valide'] = false;  
        $form['message'] = 'Problème d\'insertion dans la table équipe ';  
      }
    }
    else{
        $dev = new Developpeur($db);
        $liste = $dev->select();
        $form['liste'] = $liste;
        
        $outils = new Outils($db);
        $liste2 = $outils->selectoutils();
        $form['liste2'] = $liste2;
        
        
        $equipe = new Equipe($db);
        $liste3 = $equipe->select();
        $form['liste3'] = $liste3;
    }
 
    echo $twig->render('developpeurs-ajout.html.twig', array('form'=>$form)); 
}

function actionDeveloppeurModif($twig, $db){
    $form = array();   
    if(isset($_GET['codedev'])){
        $dev = new Developpeur($db);
        $uneProjet = $dev->selectById($_GET['codedev']);  
        
        if ($uneProjet!=null){
            $form['developpeur'] = $uneProjet;
           
            $dev = new Developpeur($db);
            $liste = $dev->select();
            $form['liste'] = $liste;
            
        
        $outils = new Outils($db);
        $liste2 = $outils->selectoutils();
        $form['liste2'] = $liste2;
        
        
        $equipe = new Equipe($db);
        $liste3 = $equipe->select();
        $form['liste3'] = $liste3;
        }
        else{
            $form['message'] = 'Projet incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
            $id = $_POST['codedev'];  
           $nom = $_POST['nom'];
      $prenom = $_POST['prenom']; 
      $datenaissance = $_POST['datenaissance']; 
      $tel = $_POST['tel']; 
      $adresse = $_POST['adresse']; 
      $remuneration = $_POST['remuneration']; 
      $couthoraire = $_POST['couthoraire']; 
      $equipe = $_POST['idEquipe']; 
      $outils = $_POST['idOutils']; 
          $developpeur = new Developpeur($db);
          $exec = $developpeur->update($id,$nom,$prenom,$datenaissance,$tel,$adresse,$remuneration,$couthoraire,$equipe,$outils);
          
          if(!$exec){
                $form['valide'] = false;  
                $form['message'] = 'Echec de la modification du dev'; 
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
    
    echo $twig->render('developpeurs-modif.html.twig', array('form'=>$form));
}


// WebService
function actionDeveloppeursWS($twig, $db){
   $equipe = new Equipe($db);
   $json = json_encode($liste = $equipe->select()); 
   echo $json; 
}

?>