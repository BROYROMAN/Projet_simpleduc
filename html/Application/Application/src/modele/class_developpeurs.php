<?php

class Developpeur{
    
    private $db;
    private $insert;
     private $insertm;
    private $select;
    private $delete;
    private $update;
    private $update1;
    private $selectById;
    private $selectByIdResponsable;
    private $selectByDev;

    
    public function __construct($db){
        $this->db = $db;
        $this->insertm = $db->prepare("insert into maitrise(idDev,idOutils) values (:idDev,:idOutils)");
        $this->insert = $db->prepare("insert into developpeur(nom,prenom,date_naiss,tel,adresse,remuneration,couthoraire,idEquipe) values (:nom,:prenom,:date_naiss,:tel,:adresse,:remuneration,:couthoraire,:idEquipe)");    
        $this->select = $db->prepare("select d.codedev,d.nom,d.prenom,d.date_naiss,d.tel,d.adresse,d.remuneration,d.couthoraire,d.idEquipe,e.id as ide,e.libelle as libelleequipe   from developpeur d right join equipe e on d.idEquipe=e.id or d.idEquipe is NULL ");
        $this->delete = $db->prepare("delete from developpeur where developpeur.codedev=:codedev");
        $this->update = $db->prepare("update developpeur set developpeur.nom=:nom,developpeur.prenom=:prenom,developpeur.date_naiss=:date_naiss,developpeur.tel=:tel,developpeur.adresse=:adresse,developpeur.remuneration=:remuneration,developpeur.couthoraire=:couthoraire,developpeur.idEquipe=:idEquipe,developpeur.idOutils=:idOutils where developpeur.codedev=:codedev"); 
        $this->selectById = $db->prepare("select developpeur.codedev,developpeur.nom,developpeur.prenom,developpeur.date_naiss,developpeur.tel,developpeur.adresse,developpeur.remuneration,developpeur.couthoraire,developpeur.idEquipe,developpeur.idOutils from developpeur  where developpeur.codedev=:codedev order by nom");
        $this->selectByDev = $db->prepare("select * from developpeur where developpeur.idEquipe=33");
        $this->selectByIdResponsable = $db->prepare("select developpeur.codedev, nom,prenom,date_naiss,tel,adresse,remuneration,couthoraire,idEquipe,idOutils  from developpeur where developpeur.codedev=:codedev");
        $this->update1 = $db->prepare("update developpeur set idEquipe=:idEquipe where codedev=:codedev"); 
    }
    
    public function insert($nom,$prenom,$datenaissance,$tel,$adresse,$remuneration,$couthoraire,$equipe){
         $r = true;
         
      $this->insert->bindValue(':nom', $nom,PDO::PARAM_INT);  
        
        $this->insert->bindValue(':prenom', $prenom,PDO::PARAM_INT); 
        
        $this->insert->bindValue(':date_naiss', $datenaissance,PDO::PARAM_STR); 
        
        $this->insert->bindValue(':tel', $tel,PDO::PARAM_INT);  
        
        $this->insert->bindValue(':adresse', $adresse,PDO::PARAM_INT); 
        
        $this->insert->bindValue(':remuneration', $remuneration,PDO::PARAM_INT); 
        
         $this->insert->bindValue(':couthoraire', $couthoraire,PDO::PARAM_INT);  
        
        $this->insert->bindValue(':idEquipe', $equipe,PDO::PARAM_INT); 
        
       
        $this->insert->execute();
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
    
    
    public function insertm($idDev,$idOutils){
         $r = true;
         
      $this->insertm->bindValue(':idDev', $nom,PDO::PARAM_INT);  
        
        $this->insertm->bindValue(':idOutils', $prenom,PDO::PARAM_INT);
       
        $this->insert->execute();
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    
    public function selectByDev(){
        $this->selectByDev->execute();
        if ($this->selectByDev->errorCode()!=0){
             print_r($this->selectByDev->errorInfo());  
        }
        return $this->selectByDev->fetchAll();
    }
    
    public function selectByIdResponsable($idResponsable){
        $this->selectByIdResponsable->execute(array(':codedev'=>$idResponsable));
        if ($this->selectByIdResponsable->errorCode()!=0){
             print_r($this->selectByIdResponsable->errorInfo());  
        }
        return $this->selectByIdResponsable->fetchAll();
    }
    
    public function update($id,$nom,$prenom,$datenaissance,$tel,$adresse,$remuneration,$couthoraire,$equipe,$outils){
        $r = true;
        
        $this->update->execute(array(':codedev'=>$id,':nom'=>$nom, ':prenom'=>$prenom, ':date_naiss'=>$datenaissance,':tel'=>$tel,':adresse'=>$adresse,':remuneration'=>$remuneration,':couthoraire'=>$couthoraire,':idEquipe'=>$equipe,':idOutils'=>$outils));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
    public function update1($iddev,$idEquipe){
        $r = true;
        
        $this->update1->execute(array(':codedev'=>$iddev,':idEquipe'=>$idEquipe));
        if ($this->update1->errorCode()!=0){
             print_r($this->update1->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function selectById($id){ 
        $this->selectById->execute(array(':codedev'=>$id)); 
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo()); 
            
        }
        return $this->selectById->fetch(); 
    }
    public function delete($id){
        $r = true;
        $this->delete->execute(array(':codedev'=>$id));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
}

?>



