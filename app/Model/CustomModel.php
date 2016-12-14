<?php
namespace Model;
use \W\Model\ConnectionModel;
use \W\Model\Model;


class CustomModel extends Model
{
  //cherche et retourne les infos trouver en base de donnee avec les parametre de slug et de status
  public function info($slug){
      return $this->search(['slug' => $slug,'status' => 'Actif'],'AND', $stripTags = true);
  }
  //retourne les resulat d'une recherche par slug , avec plusieur argument , les argument doivent toujour
  //etre completer dune lettre au hazar , ce qui permet d'inclure plusieur choix pour une mm colone
  //ex , WHERE status = 'actif' OR status = 'en attente' , devra etre specifier comme suit
  // ['statusA' => 'actif', 'statusB' => 'en attente', ]
  public function findSlug($slug,$status=['statusA' => 'Actif'])
  {
    if(!is_array($status)){
      $status = [$status];
    }
      $status_Full='(';
    foreach ($status as $key => $value) {
      $status_Full .= substr($key,0,-1).' = "'.$value.'"';
      $status_Full .= ' OR ';
    }
    $status_Full = substr($status_Full , 0, -4);
    $status_Full .= ')';

    $sql = 'SELECT * FROM ' . $this->table . ' WHERE slug = :slug AND '.$status_Full.' LIMIT 1';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':slug', $slug);
    $sth->execute();
    $info = $sth->fetch();

    if(!empty($info)){
      return $info;
    }else {
      return 'Aucun element trouver';
    }
  }
}