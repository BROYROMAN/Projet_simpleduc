<?php

function actionUpdateE($twig, $db){
   
     $equipe = new Developpeur($db); 
    $equipe->update1($_POST['iddev'],$_POST['idequipe']);
    
}
