<?php

function actionUtilisateur($twig, $db){
    $form = array(); 
    $utilisateur = new Utilisateur($db);
    
     if(isset($_GET['id'])){
        /* Nous vérifions que l'utilisateur n'est pas responsable d'une équipe
           Car nous n'avons pas souhaité faire un DELETE ON CASCADE  
         */ 
        $equipe = new Equipe($db);
        $liste = $equipe->selectByIdResponsable($_GET['id']);
        if($liste==null){
            $exec=$utilisateur->delete($_GET['id']);
            if (!$exec){
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table utilisateur';
            }
            else{
                $form['valide'] = true;
                $form['message'] = 'Utilisateur supprimé avec succès';
            }
        }
        else{
           $form['valide'] = false;
           $form['message'] = 'Impossible de supprimer l\'utilisateur, il est affecté à des équipes'; 
        }
       
     }
     $liste = $utilisateur->select();
     echo $twig->render('utilisateur.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionUtilisateurModif($twig, $db){
 $form = array();   
 if(isset($_GET['id'])){
    $utilisateur = new Utilisateur($db);
    $unUtilisateur = $utilisateur->selectByEmail($_GET['id']);  
    if ($unUtilisateur!=null){
      $form['utilisateur'] = $unUtilisateur;
      $role = new Role($db);
      $liste = $role->select();
      $form['roles']=$liste;
    }
    else{
      $form['message'] = 'Utilisateur incorrect';  
    }
 }
 else{
     if(isset($_POST['btModifier'])){
       $utilisateur = new Utilisateur($db);
       $nom = $_POST['nom'];
       $prenom = $_POST['prenom'];
       $role = $_POST['role'];
       $email = $_POST['email'];
       $exec=$utilisateur->update($email, $role, $nom, $prenom);
       if(!$exec){
         $form['valide'] = false;  
         $form['message'] = 'Echec de la modification des données. '; 
       }
       else{
         $form['valide'] = true;  
         $form['message'] = 'Modification des données réussie. ';  
       }
       if(!empty($_POST['inputPassword'])){
          $p1 = $_POST['inputPassword'];
          $p2 = $_POST['inputPassword2'];
          if ($p1==$p2){
             $p1 = password_hash($p1, PASSWORD_DEFAULT);
             $exec=$utilisateur->updateMdp($email, $p1);
             if(!$exec){
                $form['valide'] = false;  
                $form['message'] .= 'Echec de la modification du mot de passe'; 
             }
             else{
                $form['valide'] = true;  
                $form['message'] .= 'Modification réussie du mot de passe';  
             } 
          }
          else{
            $form['valide'] = false;  
            $form['message'] .= 'Echec de la modification du mot de passe';   
          }
          
       }
     }
     else{
       $form['message'] = 'Utilisateur non précisé';
     }  
 }
 echo $twig->render('utilisateur-modif.html.twig', array('form'=>$form));
}

function actionUtilisateurWS($twig, $db){
   $utilisateur = new Utilisateur($db);
   $liste = $utilisateur->select();
   for($i=0;$i<count($liste);$i++){
      $img_src = $liste[$i]['photo'];
      $imgbinary = fread(fopen('../src/private/'.$img_src, "r"), filesize('../src/private/'.$img_src)); 
      $liste[$i]['photo'] = base64_encode($imgbinary); 
   }
   $json = json_encode($liste); 
   echo $json; 
}


function actionUtilisateurPdf($twig, $db){
   $utilisateur = new Utilisateur($db); 
   $liste = $unProduit = $utilisateur->PDF();
   $html = $twig->render('listeUtilisateurPDF.html.twig', array('liste'=>$liste)); // Nous envoyons notre liste de produit dans le moteur de template TWIG.
   try { 
    ob_end_clean(); // Cette commande s'assure de ne pas envoyer de données avant le fichier PDF
    $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'fr'); // Création d'une page au format A4 de langue française orienté en mode portrait.
    $html2pdf->writeHTML($html); //Nous écrivons le résultat de twig dans la variable html2pdf
    $html2pdf->output('listeprojetparutilisateur.pdf'); // Nous écrivons dans un fichier PDF nommé listedesproduits
   } catch (Html2PdfException $e) {
            echo 'erreur '.$e;  
   } 
}
   

function actionListeUtilisateurPDF($twig, $db){
    $form = array(); 
    $utilisateur = new Utilisateur($db);
    
     if(isset($_GET['id'])){
        /* Nous vérifions que l'utilisateur n'est pas responsable d'une équipe
           Car nous n'avons pas souhaité faire un DELETE ON CASCADE  
         */ 
        $equipe = new Equipe($db);
        $liste = $equipe->selectByIdResponsable($_GET['id']);
        if($liste==null){
            $exec=$utilisateur->delete($_GET['id']);
            if (!$exec){
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table utilisateur';
            }
            else{
                $form['valide'] = true;
                $form['message'] = 'Utilisateur supprimé avec succès';
            }
        }
        else{
           $form['valide'] = false;
           $form['message'] = 'Impossible de supprimer l\'utilisateur, il est affecté à des équipes'; 
        }
       
     }
     $liste = $utilisateur->PDF();
     echo $twig->render('utilisateurlistepdf.html.twig', array('form'=>$form,'liste'=>$liste));
}

?>

