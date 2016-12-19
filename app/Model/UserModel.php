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
  public function FinIdByMail($mail)
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
  public function FinPseudoByMail($mail)
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
