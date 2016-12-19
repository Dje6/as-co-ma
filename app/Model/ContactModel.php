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
  public function searchMessagesOrga($id,$orga, $stripTags = true,$limit = 1, $offset = 0){

    $sql = 'SELECT * FROM ' . $this->table.' WHERE destinataire_mailOrId = \''. $id.'\'
    AND destinataire_orga = \'' . $orga.'\' ORDER BY date_envoi DESC LIMIT ' . $limit.' OFFSET ' . $offset.'';
    $sth = $this->dbh->prepare($sql);
    if(!$sth->execute()){
      return false;
    }
    $donnee = $sth->fetchAll();

    foreach ($donnee as $key => $value) {
      if(is_numeric($value['emeteur_mailOrId'])){
        $sql = 'SELECT mail FROM ' .$value['emeteur_orga'].' WHERE Id = \''. $value['emeteur_mailOrId'].'\'';
        $sth = $this->dbh->prepare($sql);
        if(!$sth->execute()){
          return false;
        }
        $donnee[$key]['emeteur_mail'] = $sth->fetchColumn();
      }else {
        $donnee[$key]['emeteur_mail'] = $value['emeteur_mailOrId'];
      }
    }

    if(!is_array($donnee)){
      return 'Aucun message';
    }else {
      return $donnee;
    }
  }

}
