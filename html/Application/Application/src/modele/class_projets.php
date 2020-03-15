<?php

class Projet{
    
    private $db;
    private $insert;
    private $select;
    private $selectcontrat;
    private $delete;
    private $update;
    private $selectById;
    private $selectByIdResponsable;
    private $selectByProjet;
    private $selectByTache;
    private $selectTacheByProjet;
    private $selectTacheProjet;



    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("insert into projet(nom,nbdev, budget,cahierdescharges,idContrat,idUtil,idEquip) values (:nom,:nbdev, :budget,:cahierdescharges,:idContrat,:idUtil,:idEquip)");    
        $this->select = $db->prepare("select p.nom,p.codeResponsable,p.nbdev,p.budget,p.cahierdescharges,c.nom as nomc,c.id as idc,e.id as ide,e.libelle as libelleequipe,u.id as idu, u.nom as nomu,u.prenom as prenomu  from projet p, contrat c,utilisateur u, equipe e where p.idContrat=c.id and p.idUtil=u.id and p.idEquip= e.id");
        $this->delete = $db->prepare("delete from projet where  projet.codeResponsable=:codeResponsable");
        $this->update = $db->prepare("update projet set projet.nom=:nom,projet.nbdev=:nbdev, projet.budget=:budget, projet.cahierdescharges=:cahierdescharges,projet.idContrat=:idContrat,projet.idUtil=:idUtil,projet.idEquip=:idEquip where projet.codeResponsable=:codeResponsable"); 
        $this->selectById = $db->prepare("select projet.codeResponsable,projet.nom,projet.nbdev, projet.budget,projet.cahierdescharges from projet  where projet.codeResponsable=:codeResponsable order by budget");
        $this->selectByIdResponsable = $db->prepare("select projet.codeResponsable, projet.nom,projet.nbdev, projet.budget,projet.cahierdescharges from projet where projet.codeResponsable=:codeResponsable");
        $this->selectByProjet = $db->prepare("select projet.nom,projet.budget,tache.libelle,tache.id,tache.heureprevue,tache.cout from projet, tache where projet.nom=:nom and projet.codeResponsable=tache.idProjet");
        $this->selectByTache = $db->prepare("select equipe.libelle as NOM_EQUIPE,equipe.id as IdE,projet.nom as NOM_PROJET,tache.id as idT,tache.libelle as NOM_TACHE,tache.heureprevue,developpeur.nom,developpeur.prenom,contrat.datesignature,contrat.delaiproduction, GROUP_CONCAT(developpeur.nom,'  ',developpeur.prenom ORDER BY developpeur.nom DESC SEPARATOR '--') AS developpeurs from equipe,contrat,developpeur,tache,projet where contrat.id=projet.idContrat and tache.idProjet=projet.codeResponsable and equipe.id=projet.idEquip and tache.libelle=:libelle and projet.nom=:nom and developpeur.idEquipe=equipe.id");
         $this->selectTacheByProjet = $db->prepare("select projet.codeResponsable,projet.nom,tache.libelle from projet,tache where tache.idProjet=projet.codeResponsable and projet.nom=:nom");
        $this->selectTacheProjet = $db->prepare ("select equipe.libelle as NOM_EQUIPE,equipe.id as IdE,projet.nom as NOM_PROJET,tache.id as idT,tache.libelle as NOM_TACHE,tache.heureprevue,contrat.datesignature,contrat.delaiproduction,   GROUP_CONCAT(developpeur.nom,'  ',developpeur.prenom ORDER BY developpeur.nom DESC SEPARATOR '--') AS developpeurs from equipe,contrat,developpeur,tache,projet where contrat.id=projet.idContrat and tache.idProjet=projet.codeResponsable and equipe.id=projet.idEquip  and projet.nom=:nom and equipe.id=developpeur.idEquipe group by tache.libelle");
    }
    
    public function insert($nom,$inputnbdev, $inputbudget,$inputcahierdescharges,$inputidcontrat,$inputidutil,$inputidequip){
        $r = true;
       
      
        $this->insert->bindValue(':nbdev', $inputnbdev,PDO::PARAM_INT);  
        
        $this->insert->bindValue(':budget', $inputbudget,PDO::PARAM_INT); 
        
        $this->insert->bindValue(':nom', $nom,PDO::PARAM_STR); 
        
        $this->insert->bindValue(':cahierdescharges', $inputcahierdescharges,PDO::PARAM_STR); 
        
        $this->insert->bindValue(':idContrat', $inputidcontrat,PDO::PARAM_INT);  
        
        $this->insert->bindValue(':idUtil', $inputidutil,PDO::PARAM_INT); 
        
        $this->insert->bindValue(':idEquip', $inputidequip,PDO::PARAM_INT); 
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
    
    public function selectcontrat(){
        $this->selectcontrat->execute();
        if ($this->selectcontrat->errorCode()!=0){
             print_r($this->selectcontrat->errorInfo());  
        }
        return $this->selectcontrat->fetchAll();
    }
    
   public function selectByIdResponsable($idResponsable){
        $this->selectByIdResponsable->execute(array(':codeResponsable'=>$idResponsable));
        if ($this->selectByIdResponsable->errorCode()!=0){
             print_r($this->selectByIdResponsable->errorInfo());  
        }
        return $this->selectByIdResponsable->fetchAll();
    }
    
    public function selectByProjet($projet){
        $this->selectByProjet->execute(array(':nom'=>$projet));
        if ($this->selectByProjet->errorCode()!=0){
             print_r($this->selectByProjet->errorInfo());  
        }
        return $this->selectByProjet->fetchAll();
    }
    
    public function selectByTache($projet,$tache){
        $this->selectByTache->execute(array(':nom'=>$projet,':libelle'=>$tache));
        if ($this->selectByTache->errorCode()!=0){
             print_r($this->selectByTache->errorInfo());  
        }
        return $this->selectByTache->fetchAll();
    }
    
      public function selectTacheByProjet($projet){
        $this->selectTacheByProjet->execute(array(':nom'=>$projet));
        if ($this->selectTacheByProjet->errorCode()!=0){
             print_r($this->selectTacheByProjet->errorInfo());  
        }
        return $this->selectTacheByProjet->fetchAll();
    }
    
     public function selectTacheProjet($projet){
        $this->selectTacheProjet->execute(array(':nom'=>$projet));
        if ($this->selectTacheProjet->errorCode()!=0){
             print_r($this->selectTacheProjet->errorInfo());  
        }
        return $this->selectTacheProjet->fetchAll();
    }
    
    public function update($id,$nom,$inputnbdev, $inputbudget,$inputcahierdescharges,$inputidcontrat,$inputidutil,$inputidequip){
        $r = true;
        
        $this->update->execute(array(':codeResponsable'=>$id,':nom'=>$nom, ':nbdev'=>$inputnbdev, ':budget'=>$inputbudget,':cahierdescharges'=>$inputcahierdescharges,':idContrat'=>$inputidcontrat,':idUtil'=>$inputidutil,':idEquip'=>$inputidequip));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function selectById($id){ 
        $this->selectById->execute(array(':codeResponsable'=>$id)); 
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo()); 
            
        }
        return $this->selectById->fetch(); 
    }
    public function delete($id){
        $r = true;
        $this->delete->execute(array(':codeResponsable'=>$id));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
   
    
    
}

?>



