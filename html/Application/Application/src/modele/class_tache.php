<?php

class Tache{
    
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
        $this->insert = $db->prepare("insert into tache(libelle,heureprevue,idProjet,cout) values (:libelle,:heureprevue,:idProjet,:cout)");    
//        $this->select = $db->prepare("select equipe.id, equipe.libelle, idResponsable, utilisateur.nom, utilisateur.prenom,utilisateur.id as idu from equipe left join utilisateur on equipe.idResponsable = utilisateur.id  order by libelle");
        $this->delete = $db->prepare("delete from tache where tache.id=:id");
        $this->update = $db->prepare("update tache set tache.libelle=:libelle, tache.heureprevue=:heureprevue,tache.idProjet=:idProjet,tache.cout=:cout where tache.id=:id"); 
        $this->selectById = $db->prepare("select tache.id,tache.libelle,tache.heureprevue,tache.idProjet,tache.cout from tache  where tache.id=:id order by cout");
//        $this->selectByIdResponsable = $db->prepare("select equipe.id, libelle, equipe.idResponsable from equipe where equipe.idResponsable=:idResponsable");
        $this->select = $db->prepare("select tache.id, tache.libelle,tache.cout, tache.heureprevue,tache.idProjet, projet.nom from tache left join projet on tache.idProjet = projet.codeResponsable  order by cout desc");
    }
    
   
    
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
     public function insert($libelle, $heureprevue,$nom,$cout){
        $r = true;
        
      
        $this->insert->bindValue(':idProjet', $nom,PDO::PARAM_INT);  
        
        $this->insert->bindValue(':heureprevue', $heureprevue,PDO::PARAM_INT); 
        
        $this->insert->bindValue(':libelle', $libelle,PDO::PARAM_STR);  
        
        $this->insert->bindValue(':cout', $cout,PDO::PARAM_INT);  
        
        $this->insert->execute();
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
     public function update($id,$libelle,$heureprevue,$nom,$cout){
        $r = true;
        
        $this->update->execute(array(':id'=>$id,':idProjet'=>$nom,':heureprevue'=>$heureprevue,':libelle'=>$libelle,':cout'=>$cout));
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



