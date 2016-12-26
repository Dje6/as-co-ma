<?php
namespace Model;

use \W\Model\ConnectionModel;

class NewsModel extends customModel
{
  //on precise a quel table on se connecte
  public function __construct()
  {
    $this->setTable('articles');
    $this->dbh = ConnectionModel::getDbh() ;
  }

  public function FindNewsById($id)
  {
    $sql = 'SELECT * FROM '.$this->table.' WHERE id = :id ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', $id);
    if($sth->execute()){
      $foundMessage = $sth->fetch();
      if(!empty($foundMessage)){
        return $foundMessage ;
      }else{
        return false;
      }
    }
  }

  public function FindAllNews($id_orga,$orga,$limit = 1, $offset = 0,$activer = false)
  {
    if($activer){
      $status = 'AND status = \'Activer\' ';
    }else {
      $status ='AND (status = \'Activer\' OR status = \'Desactiver\') ';
    }
    $sql = 'SELECT * FROM '.$this->table.' WHERE id_orga = :id_orga AND orga = :orga '.$status.'
    ORDER BY created_at DESC LIMIT ' . $limit.' OFFSET ' . $offset;

    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id_orga', $id_orga);
    $sth->bindValue(':orga', $orga);
    if($sth->execute()){
      $foundMessage = $sth->fetchAll();
      if(!empty($foundMessage)){
        return $foundMessage ;
      }else{
        return 'Aucunes News';
      }
    }
  }


}
