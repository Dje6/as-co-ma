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
        return $this->search(['departement' => $search,'status' => 'Actif'],'AND', $stripTags = true);
      }elseif(strlen($search) == 5){
        return $this->search(['code_postal' => $search,'status' => 'Actif'],'AND', $stripTags = true);
      }else{
        return 'Votre saisie est invalide';
      }
    }else{
      return 'Merci de saisir un numeros de departement ou un code postal';
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

    return $sth->fetchAll();
  }
}