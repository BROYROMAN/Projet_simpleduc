<?php

function actionLoadEquipe($twig, $db){
   
     $equipe = new Equipe($db); 
      $listedev = $equipe->selectByEquipe($_POST['id']);
    echo $twig->render('loadEquipe.html.twig', array('liste'=>$listedev));
}