<?php

function actionLoadOutils($twig, $db){
   
     $equipe = new Outils($db); 
      $listedev = $equipe->selectOutilsByDev($_POST['id']);
    echo $twig->render('loadOutils.html.twig', array('liste'=>$listedev));
}