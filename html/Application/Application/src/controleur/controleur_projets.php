<?php

function actionProjet($twig, $db){
    $form = array(); 
    $projet = new Projet($db);
     $equipe = new Equipe($db);
    $contrat= new Contrat($db);
    $utilisateur= new Utilisateur($db);
    if(isset($_GET['codeResponsable'])){
        $exec=$projet->delete($_GET['codeResponsable']);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table projet';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] = 'Projet supprimé avec succès';
     }
    
    $liste = $projet->select();
    
    $liste2=$contrat->selectcontrat();
     $liste3=$equipe->select();
     $liste4=$utilisateur->select();
     
    echo $twig->render('projets.html.twig', array('form'=>$form,'liste'=>$liste,'liste2'=>$liste2,'liste3'=>$liste3,'liste4'=>$liste4));
}

function actionProjetAjout($twig, $db){
    $form = array(); 
    if (isset($_POST['btAjouter'])){
        $nom = $_POST['nom'];
      $inputnbdev = $_POST['inputnbdev'];
      $inputbudget = $_POST['inputbudget']; 
      $inputcahierdescharges = $_POST['inputcahierdescharges']; 
       $inputidcontrat = $_POST['inputidcontrat'];
      $inputidutil = $_POST['inputidutil']; 
      $inputidequip = $_POST['inputidequip']; 
      $form['valide'] = true;
      $projet = new Projet($db); 
      $exec = $projet->insert($nom,$inputnbdev, $inputbudget,$inputcahierdescharges,$inputidcontrat,$inputidutil,$inputidequip);
      
      if (!$exec){
        $form['valide'] = false;  
        $form['message'] = 'Problème d\'insertion dans la table équipe ';  
      }
    }
    else{
        $projet = new Projet($db);
        $liste = $projet->select();
        $form['liste'] = $liste;

        
         $contrat = new Contrat($db);
        $liste2 = $contrat->selectcontrat();
        $form['liste2'] = $liste2;
        
        
         $equipe = new Equipe($db);
        $liste3 = $equipe->select();
        $form['liste3'] = $liste3;
        
        $utilisateur = new Utilisateur($db);
        $liste4 = $utilisateur->select();
        $form['liste4'] = $liste4;
        
    }
 
    echo $twig->render('projets-ajout.html.twig', array('form'=>$form)); 
}

function actionProjetModif($twig, $db){
    $form = array();   
    if(isset($_GET['codeResponsable'])){
        $projet = new Projet($db);
        $uneProjet = $projet->selectById($_GET['codeResponsable']);  
        
        if ($uneProjet!=null){
            $form['projet'] = $uneProjet;
           
            $projet = new Projet($db);
            $liste = $projet->select();
            $form['liste'] = $liste;
            
         $contrat = new Contrat($db);
        $liste2 = $contrat->selectcontrat();
        $form['liste2'] = $liste2;
        
        
         $equipe = new Equipe($db);
        $liste3 = $equipe->select();
        $form['liste3'] = $liste3;
        
        $utilisateur = new Utilisateur($db);
        $liste4 = $utilisateur->select();
        $form['liste4'] = $liste4;
        }
        else{
            $form['message'] = 'Projet incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
            
          $id = $_POST['codeResponsable']; 
          $nom=$_POST['nom']; 
        $inputnbdev = $_POST['inputnbdev'];
        $inputbudget = $_POST['inputbudget']; 
        $inputcahierdescharges = $_POST['inputcahierdescharges']; 
        $inputidcontrat = $_POST['inputidcontrat'];
      $inputidutil = $_POST['inputidutil']; 
      $inputidequip = $_POST['inputidequip']; 
          $projet = new Projet($db);
          $exec = $projet->update($id,$nom,$inputnbdev,$inputbudget,$inputcahierdescharges,$inputidcontrat,$inputidutil,$inputidequip);
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
    
    echo $twig->render('projets-modif.html.twig', array('form'=>$form));
}


// WebService
function actionProjetWS($twig, $db){
   $equipe = new Equipe($db);
   $json = json_encode($liste = $equipe->select()); 
   echo $json; 
}


function actionProjetPdf($twig, $db){
   $projet = new Projet($db); 
   $liste = $uneProjet = $projet->selectByProjet($_GET['nom']);
   $html = $twig->render('listeProjetPDF.html.twig', array('liste'=>$liste)); // Nous envoyons notre liste de produit dans le moteur de template TWIG.
   try { 
    ob_end_clean(); // Cette commande s'assure de ne pas envoyer de données avant le fichier PDF
    $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'fr'); // Création d'une page au format A4 de langue française orienté en mode portrait.
    $html2pdf->writeHTML($html); //Nous écrivons le résultat de twig dans la variable html2pdf
    $html2pdf->output('listeprojetchoisiparutilisateur.pdf'); // Nous écrivons dans un fichier PDF nommé listedesproduits
   } catch (Html2PdfException $e) {
            echo 'erreur '.$e;  
   } 
}
   

function actionListeProjetPDF($twig, $db){
    $form = array(); 
    $projet = new Projet($db);
    
     
         if(isset($_POST['btChoisir'])){
          $id = $_POST['nom']; 
           
          $uneProjet = $projet->selectByProjet($_POST['nom']);
          $liste = $projet->selectByProjet($_POST['nom']);
         }
        else{
            $liste=null;
            $id=null;
            $form['message'] = 'Projet incorrecte';  
        }
         
     
     
     $liste2 = $projet->select();
      $form['liste2'] = $liste2;
    //  var_dump($liste);
      
     echo $twig->render('projetlistepdf.html.twig', array('form'=>$form,'liste'=>$liste,'liste2'=>$liste2,'nom'=>$id));
}


function actionTachePdf($twig, $db){
   $projet = new Projet($db); 
 $liste=$projet->selectByTache($_GET['nom'],$_GET['libelle']);
 
   $html = $twig->render('listeTachePDF.html.twig', array('liste'=>$liste)); // Nous envoyons notre liste de produit dans le moteur de template TWIG.
   try { 
    ob_end_clean(); // Cette commande s'assure de ne pas envoyer de données avant le fichier PDF
    $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'fr'); // Création d'une page au format A4 de langue française orienté en mode portrait.
    $html2pdf->writeHTML($html); //Nous écrivons le résultat de twig dans la variable html2pdf
    $html2pdf->output('listeprojetchoisiparutilisateur.pdf'); // Nous écrivons dans un fichier PDF nommé listedesproduits
   } catch (Html2PdfException $e) {
            echo 'erreur '.$e;  
   } 
}
   

function actionListeTachePDF($twig, $db){
    $form = array(); 
    $projet = new Projet($db);
    $tache = new Tache($db);
   $libelle=null;
   $nom=null;
         if(isset($_POST['btChoisir'])){// si on appuie due le bt1 alors 
          $id = $_POST['nom'];
             $form['valide'] = true;  
            $form['message'] = 'Vous avez choisi le projet :'.$_POST['nom'].' !';  
           
          $uneProjet = $projet->selectTacheByProjet($_POST['nom']);
          $liste = $projet->selectTacheByProjet($_POST['nom']);
         }
         elseif( isset($_POST['btChoisir2'])){
             $id = $_POST['nom'];
             $libelle=$_POST['libelle'];
            $liste=$projet->selectByTache($_POST['nom'],$_POST['libelle']);
//            
            $form['valide'] = true;  
           $form['message'] = ' vous avez choisi le projet : '.$_POST['nom'].' et la tache :'.$_POST['libelle'].' voici la liste qui vous montre le nom du projet, la tache, son heure prévue la date de début et ainsi la date de fin si connu !';  
        }elseif ($id = $_POST['nom']==0) { // sinon on lui dit de choisir un prochet
             $liste=null;
              $id=null;
             $form['valide'] = false;  
            $form['message'] = 'Veuillez choisir un projet en premier merci !';  
         }
       
         
     
     
     $liste2 = $projet->select();
      $form['liste2'] = $liste2;
      
    //  var_dump($liste);
      
     echo $twig->render('tachelistepdf.html.twig', array('form'=>$form,'liste'=>$liste,'liste2'=>$liste2,'nom'=>$id,'libelle'=>$libelle));
}


function actionListeTacheProjetPDF($twig, $db){
    $form = array(); 
    $projet = new Projet($db);
    
   
         if(isset($_POST['btChoisir'])){
          $id = $_POST['nom']; 
           
          $uneProjet = $projet->selectTacheProjet($_POST['nom']);
          $liste = $projet->selectTacheProjet($_POST['nom']);
         }
        else{
            $liste=null;
            $id=null;
            $form['message'] = 'Projet incorrecte';  
        }
         
     
     
     $liste2 = $projet->select();
      $form['liste2'] = $liste2;
    //  var_dump($liste);
      
     echo $twig->render('listetacheprojetpdf.html.twig', array('form'=>$form,'liste'=>$liste,'liste2'=>$liste2,'nom'=>$id));
}


function actionTacheProjetPdf($twig, $db){
   $projet = new Projet($db); 
   $liste = $uneProjet = $projet->selectTacheProjet($_GET['nom']);
   $html = $twig->render('listetacheprojet.html.twig', array('liste'=>$liste)); // Nous envoyons notre liste de produit dans le moteur de template TWIG.
   try { 
    ob_end_clean(); // Cette commande s'assure de ne pas envoyer de données avant le fichier PDF
    $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'fr'); // Création d'une page au format A4 de langue française orienté en mode portrait.
    $html2pdf->writeHTML($html); //Nous écrivons le résultat de twig dans la variable html2pdf
    $html2pdf->output('listetacheprojet.pdf'); // Nous écrivons dans un fichier PDF nommé listedesproduits
   } catch (Html2PdfException $e) {
            echo 'erreur '.$e;  
   } 
}
?>