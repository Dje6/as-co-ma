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

}
