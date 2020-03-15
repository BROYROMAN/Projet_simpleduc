<?php

class Equipe{
    
    private $db;
    private $insert;
    private $select;
    private $delete;
    private $update;
    private $selectById;
    private $selectByIdResponsable;
    private $selectByEquipe;
    
    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("insert into equipe(libelle, idResponsable) values (:libelle, :idResponsable)");    
        $this->select = $db->prepare("select equipe.id, equipe.libelle, idResponsable, developpeur.nom, developpeur.prenom,developpeur.codedev as idu from equipe left join developpeur on equipe.idResponsable = developpeur.codedev  order by libelle");
        $this->delete = $db->prepare("delete from equipe where equipe.id=:id");
        $this->update = $db->prepare("update equipe set equipe.libelle=:libelle, equipe.idResponsable=:idResponsable where equipe.id=:id"); 
        $this->selectById = $db->prepare("select equipe.id, equipe.libelle, equipe.idResponsable from equipe  where equipe.id=:id order by libelle");
         $this->selectByEquipe = $db->prepare("select * from equipe e,developpeur d where  e.id=:id and d.idEquipe=e.id");
        $this->selectByIdResponsable = $db->prepare("select equipe.id, libelle, equipe.idResponsable from equipe where equipe.idResponsable=:idResponsable");
    }
    
    public function insert($libelle, $idResponsable){
        $r = true;
        if($idResponsable=="non"){
          $idResponsable=null;  
        }
      
        $this->insert->bindValue(':idResponsable', $idResponsable,PDO::PARAM_STR);  
        
        $this->insert->bindValue(':libelle', $libelle,PDO::PARAM_STR); 
        $this->insert->execute();
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    public function selectByEquipe($libelle){
        $this->selectByEquipe->execute(array(':id'=>$libelle));
        if ($this->selectByEquipe->errorCode()!=0){
             print_r($this->selectByEquipe->errorInfo());  
        }
        return $this->selectByEquipe->fetchAll();
    }
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function selectByIdResponsable($idResponsable){
        $this->selectByIdResponsable->execute(array(':idResponsable'=>$idResponsable));
        if ($this->selectByIdResponsable->errorCode()!=0){
             print_r($this->selectByIdResponsable->errorInfo());  
        }
        return $this->selectByIdResponsable->fetchAll();
    }
    
    public function update($id, $libelle, $idResponsable){
        $r = true;
        if($idResponsable=="non"){
          $idResponsable=null;  
        }
        $this->update->execute(array(':id'=>$id, ':libelle'=>$libelle, ':idResponsable'=>$idResponsable));
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



