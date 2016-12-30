<?php
namespace Model;

use \W\Model\Model;
use \W\Model\ConnectionModel;

class PicturesModel extends CustomModel
{
  public function __construct()
  {
    $this->setTable('pictures');
    $this->dbh = ConnectionModel::getDbh() ;
  }
}
