<?php
namespace Model;

use \W\Model\ConnectionModel;

class AbonnesModel extends CustomModel
{
  //on precise a quel table on se connecte
  public function __construct()
  {
    $this->setTable('abonnes');
    $this->dbh = ConnectionModel::getDbh() ;
  }

  public function abonnes($id_orga,$orga)
  {
    $sql = "SELECT mail FROM $this->table WHERE id_$orga = :id_orga ";
    $sth = $this->dbh->prepare($sql);
    $sth->bindvalue(':id_orga',$id_orga);
    $sth->execute();
    $result = $sth->fetchAll();
    return $result;

  }
  public function findAbonne($mail,$id_orga,$orga)
  {
    $sql = "SELECT id FROM $this->table WHERE id_$orga = :id_orga AND mail = :mail ";
    $sth = $this->dbh->prepare($sql);
    $sth->bindvalue(':id_orga',$id_orga);
    $sth->bindvalue(':mail',$mail);
    $sth->execute();
    $result = $sth->fetchColumn();
    return $result;

  }

  public function deleteByOrga($id,$orga)
  {
    $sql = 'DELETE FROM ' . $this->table . ' WHERE id_'.$orga.' = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', $id);
    return $sth->execute();
  }

}
