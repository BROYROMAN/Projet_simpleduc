<?php

class Traiter{
    
    private $db;
    private $insert;
//    private $select;
    private $delete;
    private $update;
    private $selectById;
//    private $selectByIdResponsable;
    private $select;

    
    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("insert into traiter(idTache,idDev,nbheure) values (:idTache,:idDev,:nbheure)");    
//        $this->select = $db->prepare("select equipe.id, equipe.libelle, idResponsable, utilisateur.nom, utilisateur.prenom,utilisateur.id as idu from equipe left join utilisateur on equipe.idResponsable = utilisateur.id  order by libelle");
        $this->delete = $db->prepare("delete from traiter where traiter.id=:id");
        $this->update = $db->prepare("update traiter set traiter.idTache=:idTache, traiter.idDev=:idDev,traiter.nbheure=:nbheure where traiter.id=:id"); 
        $this->selectById = $db->prepare("select traiter.id,traiter.idTache,traiter.idDev,traiter.nbheure from traiter  where traiter.id=:id order by id");
//        $this->selectByIdResponsable = $db->prepare("select equipe.id, libelle, equipe.idResponsable from equipe where equipe.idResponsable=:idResponsable");
        $this->select = $db->prepare("select traiter.id as idtrait, traiter.idTache, traiter.idDev,traiter.nbheure, developpeur.nom as nomd,developpeur.prenom as prenomd,tache.libelle as libellet,tache.id as idtach,developpeur.codedev from traiter,tache,developpeur where traiter.idTache=tache.id and traiter.idDev=developpeur.codedev   order by libelle");
    }
    
   
    
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
     public function insert($tache,$dev,$nbheure){
        $r = true;
        
      
        $this->insert->bindValue(':idTache', $tache,PDO::PARAM_INT);  
        
        $this->insert->bindValue(':idDev', $dev,PDO::PARAM_INT); 
        
        $this->insert->bindValue(':nbheure', $nbheure,PDO::PARAM_INT);  
        
        
        $this->insert->execute();
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
     public function update($id,$tache,$dev,$nbheure){
        $r = true;
        
        $this->update->execute(array(':id'=>$id,':idTache'=>$tache,':idDev'=>$dev,':nbheure'=>$nbheure));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function selectById($id){ 
        $this->selectById->execute(array(':id'=>$id)); 
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo()); 
            
        }
        return $this->selectById->fetch(); 
    }
    public function delete($id){
        $r = true;
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
}

?>



