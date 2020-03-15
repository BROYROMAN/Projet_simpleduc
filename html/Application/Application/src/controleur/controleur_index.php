<?php

function actionAccueil($twig, $db){
    $form = array(); 
    $form['valide'] = true;
    if (isset($_POST['btConnecter'])){
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];  
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->connect($inputEmail);
        if ($unUtilisateur!=null){
          if(!password_verify($inputPassword,$unUtilisateur['mdp'])){
              $form['valide'] = false;
              $form['message'] = 'Login ou mot de passe incorrect';
          }  
          else{
           $_SESSION['login'] = $inputEmail;     
           $_SESSION['role'] = $unUtilisateur['idRole'];
           header("Location:index.php");
          } 
        }
        else{
           $form['valide'] = false;
           $form['message'] = 'Login ou mot de passe incorrect';
          
        }
    }
    echo $twig->render('index.html.twig', array('form'=>$form));
}

function actionConnexion($twig, $db){
    $form = array(); 
    $form['valide'] = true;
    if (isset($_POST['btConnecter'])){
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];  
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->connect($inputEmail);
        if ($unUtilisateur!=null){
          if(!password_verify($inputPassword,$unUtilisateur['mdp'])){
              $form['valide'] = false;
              $form['message'] = 'Login ou mot de passe incorrect';
          }  
          else{
           $_SESSION['login'] = $inputEmail;     
           $_SESSION['role'] = $unUtilisateur['idRole'];
           header("Location:index.php");
          } 
        }
        else{
           $form['valide'] = false;
           $form['message'] = 'Login ou mot de passe incorrect';
          
        }
    }
    echo $twig->render('connexion.html.twig', array('form'=>$form));
}

function actionDeconnexion($twig){
    session_unset();
    session_destroy();
    header("Location:index.php");
}

function actionInscrire($twig, $db){
    $form = array(); 
    if (isset($_POST['btInscrire'])){
      $inputEmail = $_POST['inputEmail'];
      $inputPassword = $_POST['inputPassword']; 
      $inputPassword2 =$_POST['inputPassword2']; 
      $nom = $_POST['nom']; 
      $prenom =$_POST['prenom']; 
      $cp =$_POST['cp']; 
      $ville =$_POST['ville']; 
       
      $role = 2; // Signifie que par défaut, une personne est un simple utilisateur
      $form['valide'] = true;
      $utilisateur = new Utilisateur($db); 
      if ($inputPassword!=$inputPassword2){
        $form['valide'] = false;  
        $form['message'] = 'Les mots de passe sont différents';
      }
      
                         if(!empty($_FILES['images']['name'])){

					  //Cette ligne teste si la variable fichier qui se nomme «images» existe en mémoire
    $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
    		 //Cette ligne indique les extensions des fichiers que nous autoriserons. Nous les mettons dans un tableau.
    $taille_max = 500000;
$dest_dossier = '../src/private/';
//Il faudra donner des droits au répertoire qui accueillera vos images.
     if( !in_array( substr(strrchr($_FILES['images']['name'], '.'), 1), $extensions_ok ) ){
		 //La ligne regarde si dans le nom de la photo nous avons bien une extension autorisée.
         echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
              }
     else{
           if( file_exists($_FILES['images']['tmp_name'])&& (filesize($_FILES['images']['tmp_name'])) >$taille_max){
               echo 'Votre fichier doit faire moins de 500Ko !';
          }
          else{
              // copie du fichier
             $dest_fichier = basename($_FILES['images']['name']);
              // formatage nom fichier
              // enlever les accents
				$dest_fichier=strtr($dest_fichier,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
              // remplacer les caractères autres que lettres, chiffres et point par _
              $dest_fichier = preg_replace('/([^.a-z0-9]+)/i', '_', $dest_fichier);
              // copie du fichier
                $dest_fichier=$email.".".substr(strrchr($_FILES['images']['name'], '.'), 1);
              move_uploaded_file($_FILES['images']['tmp_name'], $dest_dossier . $dest_fichier);

                  $nb = $utilisateur->insert($inputEmail,password_hash($inputPassword, PASSWORD_DEFAULT),$role,$nom,$prenom,$cp,$ville,$dest_fichier);
                  if ($nb!=1){
                      echo 'Erreur lors de l\'insertion';
                  }else{
                      echo 'Insertion réussie';
                  }

          }
      }
}else {
	$nb = $utilisateur->insert($inputEmail,password_hash($inputPassword, PASSWORD_DEFAULT),$role,$nom,$prenom,$cp,$ville,'default.png');
         if ($nb!=1){
                      echo 'Erreur lors de l\'insertion';
                  }else{
                      echo 'Insertion réussie';
                  }
}
//      else{
//        $utilisateur = new Utilisateur($db); 
//        $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword, PASSWORD_DEFAULT), $role, $nom, $prenom);
//        if (!$exec){
//          $form['valide'] = false;  
//          $form['message'] = 'Problème d\'insertion dans la table utilisateur '; 
//       
//        }
//      }
      
      $form['email'] = $inputEmail;
      $form['role'] = $role;
      
    }
    echo $twig->render('inscrire.html.twig', array('form'=>$form));
}

function actionMentions($twig){
    echo $twig->render('mentions.html.twig', array());
}

function actionApropos($twig){
    echo $twig->render('apropos.html.twig', array());
}

function actionMaintenance($twig){
    echo $twig->render('maintenance.html.twig', array());
}
?>
