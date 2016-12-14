<?php
namespace Model\admin;

use \Model\UsersCustomModel;
use \W\Model\ConnectionModel;

class UserModel extends UsersCustomModel
{
  public function __construct()
  {
    $this->setTable('users');
    $this->dbh = ConnectionModel::getDbh() ;
  }
}
