<?php
namespace Model;

use \W\Model\ConnectionModel;

class ContactModel extends CustomModel
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
    AND destinataire_orga = \'' . $orga.'\' AND destinataire_status IS NULL ORDER BY date_envoi DESC LIMIT ' . $limit.' OFFSET ' . $offset.'';
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
  public function searchSendMessagesOrga($id,$orga, $stripTags = true,$limit = 1, $offset = 0){

    $sql = 'SELECT * FROM ' . $this->table.' WHERE emeteur_mailOrId = \''. $id.'\'
    AND emeteur_orga = \'' . $orga.'\' AND emeteur_status IS NULL ORDER BY date_envoi DESC LIMIT ' . $limit.' OFFSET ' . $offset.'';
    $sth = $this->dbh->prepare($sql);
    if(!$sth->execute()){
      return false;
    }
    $donnee = $sth->fetchAll();

    foreach ($donnee as $key => $value) {
      if(is_numeric($value['destinataire_mailOrId'])){
        if($value['destinataire_orga'] == 'users'){
          $sql = 'SELECT mail,pseudo FROM ' .$value['destinataire_orga'].' WHERE Id = \''. $value['destinataire_mailOrId'].'\'';
        }else {
          $sql = 'SELECT mail,slug AS pseudo FROM ' .$value['destinataire_orga'].' WHERE Id = \''. $value['destinataire_mailOrId'].'\'';
        }
        $sth = $this->dbh->prepare($sql);
        if(!$sth->execute()){
          return false;
        }
        $result = $sth->fetch();
        $donnee[$key]['destinataire_mail'] = $result['mail'];
        $donnee[$key]['destinataire_pseudo'] = $result['pseudo'];
      }else {
        $donnee[$key]['destinataire_mail'] = $value['destinataire_mailOrId'];
        if($value['destinataire_mailOrId'] == 'webmaster@as-co-ma.fr'){
            $donnee[$key]['destinataire_pseudo'] = 'Webmaster';
        }else {
          $donnee[$key]['destinataire_pseudo'] = 'non-inscrit';
        }
      }
    }

    if(!is_array($donnee)){
      return 'Aucuns messages.';
    }else {
      return $donnee;
    }
  }
  public function FindMessageById($id)
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
  public function deleteByType($id,$type)
  {
    if (!is_numeric($id)){
      return false;
    }

    $sql = 'DELETE FROM ' . $this->table . ' WHERE (emeteur_orga = :type AND emeteur_mailOrId = :id) OR
    (destinataire_orga = :type AND destinataire_mailOrId = :id) ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':type', $type);
    $sth->bindValue(':id', $id);
    return $sth->execute();
  }

  public function findInvitation($mail,$id_assoc)
  {
    $sql = 'SELECT * FROM '.$this->table.' WHERE destinataire_mailOrId = :mail
     AND objet LIKE \'%Invitation%\' AND objet LIKE \'%a%\' AND objet LIKE \'%rejoindre%\'
     AND emeteur_orga = \'assoc\' AND emeteur_mailOrId = :id_assoc AND status = \'non-lu\' LIMIT 1';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':mail', $mail);
    $sth->bindValue(':id_assoc', $id_assoc);
    if($sth->execute()){
      $foundUser = $sth->fetch();
      if(!empty($foundUser)){
        return $foundUser ;
      }else{
        return false;
      }
    }
  }
  public function findDemande($mail,$id_assoc)
  {
    $sql = 'SELECT * FROM '.$this->table.' WHERE emeteur_mailOrId = :mail
     AND objet = \'inscript_membre\' AND destinataire_mailOrId = :id_assoc AND destinataire_orga = \'assoc\'
     AND status = \'non-lu\' LIMIT 1';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':mail', $mail);
    $sth->bindValue(':id_assoc', $id_assoc);
    if($sth->execute()){
      $foundUser = $sth->fetch();
      if(!empty($foundUser)){
        return $foundUser ;
      }else{
        return false;
      }
    }
  }
  public function findDemandeValider($mail)
  {
    $sql = 'SELECT * FROM '.$this->table.' WHERE emeteur_mailOrId = :mail
     AND objet = \'inscript_membre\'
     AND destinataire_orga = \'assoc\' AND status = \'Accepter\' LIMIT 1';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':mail', $mail);
    if($sth->execute()){
      $foundUser = $sth->fetch();
      if(!empty($foundUser)){
        return $foundUser ;
      }else{
        return false;
      }
    }
  }
  public function updateMessageDestinataire(array $data, $mail)
	{

		$sql = 'UPDATE ' . $this->table . ' SET ';
		foreach($data as $key => $value){
      if($value == 'NULL'){
        $sql .= "`$key` = NULL, ";
      }else {
        $sql .= "`$key` = :$key, ";
      }

		}
		// Supprime les caractères superflus en fin de requète
		$sql = substr($sql, 0, -2);
		$sql .= ' WHERE destinataire_mailOrId = :mail ';

		$sth = $this->dbh->prepare($sql);
		foreach($data as $key => $value){
      if($value == 'NULL'){
      }else {
        $sth->bindValue(':'.$key, $value);
      }
		}
		$sth->bindValue(':mail', $mail);

		if(!$sth->execute()){
			return false;
		}
		return true;
	}
  public function updateMessageEmeteur(array $data, $mail)
	{

		$sql = 'UPDATE ' . $this->table . ' SET ';
		foreach($data as $key => $value){
      if($value == 'NULL'){
        $sql .= "`$key` = NULL, ";
      }else {
        $sql .= "`$key` = :$key, ";
      }

		}
		// Supprime les caractères superflus en fin de requète
		$sql = substr($sql, 0, -2);
		$sql .= ' WHERE emeteur_mailOrId = :mail ';

		$sth = $this->dbh->prepare($sql);
		foreach($data as $key => $value){
      if($value == 'NULL'){
      }else {
        $sth->bindValue(':'.$key, $value);
      }
		}
		$sth->bindValue(':mail', $mail);

		if(!$sth->execute()){
			return false;
		}
		return true;
	}


}
