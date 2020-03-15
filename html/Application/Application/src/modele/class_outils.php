<?php

class Outils{
    
   private $db;
    private $insert;
//    private $select;
//    private $delete;
//    private $update;
//    private $selectById;
//    private $selectByIdResponsable;
    private $selectoutils;
    private $selectOutilsByDev;

    
    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("insert into outils(libelle, version) values (:libelle, :version)");    
//        $this->select = $db->prepare("select equipe.id, equipe.libelle, idResponsable, utilisateur.nom, utilisateur.prenom,utilisateur.id as idu from equipe left join utilisateur on equipe.idResponsable = utilisateur.id  order by libelle");
        $this->delete = $db->prepare("delete from outils where outils.id=:id");
        $this->update = $db->prepare("update outils set outils.libelle=:libelle, outils.version=:version where outils.id=:id"); 
        $this->selectById = $db->prepare("select outils.id, outils.libelle, outils.version from outils  where outils.id=:id order by libelle");
//        $this->selectByIdResponsable = $db->prepare("select equipe.id, libelle, equipe.idResponsable from equipe where equipe.idResponsable=:idResponsable");
        $this->selectoutils = $db->prepare("select * from outils ");
        $this->selectOutilsByDev = $db->prepare("select outils.libelle,outils.version from outils,developpeur,maitrise  where developpeur.codedev=:id and outils.id=maitrise.idOutils and maitrise.idDev=developpeur.codedev");
    }
    
   
    
    public function selectoutils(){
        $this->selectoutils->execute();
        if ($this->selectoutils->errorCode()!=0){
             print_r($this->selectoutils->errorInfo());  
        }
        return $this->selectoutils->fetchAll();
    }
    
    public function insert($libelle, $version){
        $r = true;
        
      
        $this->insert->bindValue(':libelle', $libelle,PDO::PARAM_STR);  
        
        $this->insert->bindValue(':version', $version,PDO::PARAM_STR); 
        $this->insert->execute();
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
     public function update($id, $libelle, $version){
        $r = true;
        
        $this->update->execute(array(':id'=>$id, ':libelle'=>$libelle, ':version'=>$version));
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
    
    public function selectOutilsByDev($id){ 
        $this->selectOutilsByDev->execute(array(':id'=>$id)); 
        if ($this->selectOutilsByDev->errorCode()!=0){
            print_r($this->selectOutilsByDev->errorInfo()); 
            
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



