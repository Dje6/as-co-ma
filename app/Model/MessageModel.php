<?php
namespace Model;

use \W\Model\ConnectionModel;

class MessageModel extends customModel
{
  //on defini la table dans la quel on veut chercher les resulta
  public function __construct($table)
  {
    $this->setTable($table);
    $this->dbh = ConnectionModel::getDbh() ;
  }
  //searchmessages recupere les message de la messagerie PERSONNEL d'un utilisateur identifier
  public function searchMessages(array $search, $operator = 'OR', $stripTags = true,$alias_table,$limit = null, $offset = null){
    // Sécurisation de l'opérateur
    $operator = strtoupper($operator);
    if($operator != 'OR' && $operator != 'AND'){
      die('Error: invalid operator param');
    }
      $sql = 'SELECT m.*,u.pseudo AS emeteur_pseudo,u.mail FROM ' . $this->table.' AS m
      LEFT JOIN users AS u ON m.emeteur = u.id WHERE';
      //bien verifier dans le foreach suivant l'alias du nom de colonne

    foreach($search as $key => $value){
      $sql .= " $alias_table`$key` LIKE :$key ";
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
    if(empty($sth->fetchAll())){
      return 'Aucun message';
    }else {
      return $sth->fetchAll();
    }
  }
  //searchMessagesOrga recupere les message d'un organisation
  //ciblé , aussi bien mairie que assoc que notre messagerie de superadmin
  public function searchMessagesOrga(array $search, $operator = 'OR', $stripTags = true,$limit = null, $offset = null){

    // Sécurisation de l'opérateur
    $operator = strtoupper($operator);
    if($operator != 'OR' && $operator != 'AND'){
      die('Error: invalid operator param');
    }

    $sql = 'SELECT * FROM ' . $this->table.' WHERE';

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
    if(empty($sth->fetchAll())){
      return 'Aucun message';
    }else {
      return $sth->fetchAll();
    }
  }
}
