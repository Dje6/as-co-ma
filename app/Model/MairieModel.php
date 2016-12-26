<?php
namespace Model;

use \W\Model\ConnectionModel;

class MairieModel extends customModel
{
  public function __construct()
  {
    $this->setTable('mairie');
    $this->dbh = ConnectionModel::getDbh() ;
  }
  //preprar la requete pour la recherche en base de donnee , selon si on recherche
  //la mairie dans un departement ou par code postal
  public function searchMairie($search)
  {
    if(is_numeric($search)){
      $this->setTable('mairie');
      $this->dbh = ConnectionModel::getDbh() ;
      if(strlen($search) == 2 || strlen($search) == 3){
        $result = $this->search(['departement' => $search,'status' => 'Actif'],'AND', $stripTags = true);
        if(!$result){
          return 'Aucune Mairie enregistrée dans ce département.';
        }else {
          return $result;
        }
      }elseif(strlen($search) == 5){
        $result = $this->search(['code_postal' => $search,'status' => 'Actif'],'AND', $stripTags = true);
        if(!$result){
          return 'Aucune Mairie enregistrée avec ce code postal.';
        }else {
          return $result;
        }
      }else{
        return 'Votre saisie est invalide.';
      }
    }else{
      return 'Merci de saisir un numéro de département ou un code postal';
    }
  }
// retourne la liste des association present dans une mairie avec le slug de la mairie
//meme si on pourai pencer quil serai plus logique de placer ceci dan le model assoc ,
// les info sont demander et retourner par le controleur de la mairie
  public function findListe($slug)
  {

    $sql = 'SELECT * FROM assoc WHERE id_mairie = (SELECT id FROM ' . $this->table . ' WHERE slug = :slug)';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':slug', $slug);
    $sth->execute();
    $donnee = $sth->fetchAll();
    if(!is_array($donnee)){
      return 'Aucune association n\'est enregistrée auprès de cette mairie.';
    }else{
      return $donnee;
    }
  }

  public function findAll()
  {
    $sql = 'SELECT id,slug,nom,code_postal,departement,status FROM '.$this->table ;
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $donnee = $sth->fetchAll();
    if(!is_array($donnee)){
      return 'Aucune Mairie n\'est encore enregistrée sur le site.';
    }else{
      return $donnee;
    }
  }
}
