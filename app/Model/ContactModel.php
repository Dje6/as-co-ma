<?php
namespace Model;

use \W\Model\ConnectionModel;

class ContactModel extends customModel
{
  public function __construct()
  {
    $this->setTable('contact');
    $this->dbh = ConnectionModel::getDbh() ;
  }
  //searchMessagesOrga recupere les message d'un organisation
  //ciblé , aussi bien mairie que assoc que notre messagerie de superadmin
  public function searchMessagesOrga(array $search, $operator = 'OR', $stripTags = true,$limit = null, $offset = null){

    // Sécurisation de l'opérateur
    $operator = strtoupper($operator);
    if($operator != 'OR' && $operator != 'AND'){
      die('Error: invalid operator param');
    }

    $sql = 'SELECT * FROM ' . $this->table.' WHERE ';

    foreach($search as $key => $value){
      $sql .= "`$key` LIKE :$key ";
      $sql .= $operator;
    }
    // Supprime les caractères superflus en fin de requète
    if($operator == 'OR') {
      $sql = substr($sql, 0, -3);
    }
    elseif($operator == 'AND') {
      $sql = substr($sql, 0, -4);
    }
    $sql .= ' ORDER BY date_envoi DESC';

    if($limit){
      $sql .= ' LIMIT '.$limit;
      if($offset){
        $sql .= ' OFFSET '.$offset;
      }
    }
    $sth = $this->dbh->prepare($sql);

    foreach($search as $key => $value){
      $value = ($stripTags) ? strip_tags($value) : $value;
      $sth->bindValue(':'.$key, '%'.$value.'%');
    }
    if(!$sth->execute()){
      return false;
    }
    $donnee = $sth->fetchAll();
    if(!is_array($donnee)){
      return 'Aucun message';
    }else {
      return $donnee;
    }
  }

}
