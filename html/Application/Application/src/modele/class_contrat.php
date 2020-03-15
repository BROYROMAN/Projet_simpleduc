<?php

class Contrat{
    
    private $db;
    private $insert;
//    private $select;
    private $delete;
    private $update;
    private $selectById;
//    private $selectByIdResponsable;
    private $selectcontrat;

    
    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("insert into contrat(nom,datesignature,delaiproduction,coutglobal) values (:nom,:datesignature,:delaiproduction,:coutglobal)");    
//        $this->select = $db->prepare("select equipe.id, equipe.libelle, idResponsable, utilisateur.nom, utilisateur.prenom,utilisateur.id as idu from equipe left join utilisateur on equipe.idResponsable = utilisateur.id  order by libelle");
        $this->delete = $db->prepare("delete from contrat where contrat.id=:id");
        $this->update = $db->prepare("update contrat set contrat.nom=:nom, contrat.datesignature=:datesignature,contrat.delaiproduction=:delaiproduction,contrat.coutglobal=:coutglobal where contrat.id=:id"); 
        $this->selectById = $db->prepare("select contrat.id, contrat.nom, contrat.datesignature,contrat.delaiproduction,contrat.coutglobal from contrat  where contrat.id=:id order by nom");
//        $this->selectByIdResponsable = $db->prepare("select equipe.id, libelle, equipe.idResponsable from equipe where equipe.idResponsable=:idResponsable");
        $this->selectcontrat = $db->prepare("select * from contrat ");
    }
    
   
    
    public function selectcontrat(){
        $this->selectcontrat->execute();
        if ($this->selectcontrat->errorCode()!=0){
             print_r($this->selectcontrat->errorInfo());  
        }
        return $this->selectcontrat->fetchAll();
    }
     public function insert($nom, $datesignature,$delaiproduction,$coutglobal){
        $r = true;
        
      
        $this->insert->bindValue(':nom', $nom,PDO::PARAM_STR);  
        
        $this->insert->bindValue(':datesignature', $datesignature,PDO::PARAM_STR); 
        
        $this->insert->bindValue(':delaiproduction', $delaiproduction,PDO::PARAM_STR);  
        
        $this->insert->bindValue(':coutglobal', $coutglobal,PDO::PARAM_INT); 
        $this->insert->execute();
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
     public function update($id, $nom, $datesignature,$delaiproduction,$coutglobal){
        $r = true;
        
        $this->update->execute(array(':id'=>$id, ':nom'=>$nom, ':datesignature'=>$datesignature,':delaiproduction'=>$delaiproduction,':coutglobal'=>$coutglobal));
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



