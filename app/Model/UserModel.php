<?php
namespace Model;

use \Model\UsersCustomModel;
use \W\Model\ConnectionModel;

class UserModel extends UsersCustomModel
{
  public function __construct()
  {
    $this->setTable('users');
    $this->dbh = ConnectionModel::getDbh() ;
  }
  public function FindElementByElement($search,$colone,$where)
  {
    $sql = 'SELECT '.$search.' FROM '.$this->table.' WHERE '.$colone.' = :where ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':where', $where);
    if($sth->execute()){
      $foundUser = $sth->fetchColumn();
      if(!empty($foundUser)){
        return $foundUser ;
      }else{
        return false;
      }
    }
  }
  public function FindIdByMail($mail)
  {
    $sql = 'SELECT id FROM '.$this->table.' WHERE mail = :mail ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':mail', $mail);
    if($sth->execute()){
      $foundUser = $sth->fetchColumn();
      if(!empty($foundUser)){
          return $foundUser ;
      }else{
        return false;
      }
    }
  }
  public function FindMailById($id)
  {
    $sql = 'SELECT mail FROM '.$this->table.' WHERE id = :id ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', $mail);
    if($sth->execute()){
      $foundUser = $sth->fetchColumn();
      if(!empty($foundUser)){
          return $foundUser ;
      }else{
        return false;
      }
    }
  }
  public function FindPseudoByMail($mail)
  {
    $sql = 'SELECT pseudo FROM '.$this->table.' WHERE mail = :mail ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':mail', $mail);
    if($sth->execute()){
      $foundUser = $sth->fetchColumn();
      if(!empty($foundUser)){
          return $foundUser ;
      }else{
        return false;
      }
    }
  }
}
