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
      $status_Full .= 't.'.substr($key,0,-1).' = "'.$value.'"';
      $status_Full .= ' OR ';
    }
    $status_Full = substr($status_Full , 0, -4);
    $status_Full .= ')';

    $sql = 'SELECT t.*,p.relatif AS avatar,p2.relatif AS background FROM ' . $this->table . ' AS t LEFT JOIN pictures AS p
    ON t.avatar = p.id LEFT JOIN pictures AS p2 ON t.background = p2.id WHERE t.slug = :slug AND '.$status_Full.'';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':slug', $slug);
    $sth->execute();
    $info = $sth->fetch();

    if(!empty($info)){
      return $info;
    }else {
      return 'Aucune '.$this->table.' correspondante.';
    }
  }

  public function FindElementByElement($search,$colone,$where)
  {
    $sql = 'SELECT '.$search.' FROM '.$this->table.' WHERE '.$colone.' = :where LIMIT 1';
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

  public function emailExistsOrga($email)
  {
   $sql = 'SELECT COUNT(mail) FROM '.$this->table.' WHERE mail = :email ';
   $sth = $this->dbh->prepare($sql);
   $sth->bindValue(':email', $email);
   if($sth->execute()){
     $foundUser = $sth->fetchColumn();
     if($foundUser > 0){
         return true;
     }else{
       return false;
     }
    }
  }
//verifie dans toute la base de donnee si l'email es deja atribuer , que se soi un utilisateur , une mairie , ou une assoc

// sutilise avec nimporte quel model
// $mairieModel->mailExistAllSite($r_POST['mail']);

  public function mailExistAllSite($mail)
  {
   $sql = 'SELECT COUNT(mail) AS c FROM mairie WHERE mail = :mail UNION ALL
   SELECT COUNT(mail) AS c FROM assoc WHERE mail = :mail UNION ALL
   SELECT COUNT(mail) AS c FROM users WHERE mail = :mail';

   $sth = $this->dbh->prepare($sql);
   $sth->bindValue(':mail', $mail);
   if($sth->execute()){
     $foundUser = $sth->fetchAll();
     $total = 0;
     foreach ($foundUser as $key => $value) {
       $total += $value['c'];
     }
     if($total > 0){
       echo $total;
       return 'Cet e-mail est déjà enregistré sur le site.';
     }
    }
  }

  //////////////////////////////////////////////////////:
  ///////////////////////////////////////////////////////
  //////////////////////////////////////////////////////
  ///////////////SURCHARGE

// les surcharge son identique au originaux , la seul difference es qu'ils gere le NULL , on peu donc inserer et mettre a jour
// une value NULL en base de donnee

//ATTENTION !! pour que ca fonctionne , la valeur doit etre 'NULL' , une chaine de caractere avec ecrit NULL , pas un NULL reel
  public function insert(array $data, $stripTags = true)
	{

		$colNames = array_keys($data);
		$colNamesEscapes = $this->escapeKeys($colNames);
		$colNamesString = implode(', ', $colNamesEscapes);

		$sql = 'INSERT INTO ' . $this->table . ' (' . $colNamesString . ') VALUES (';
		foreach($data as $key => $value){
      if($value == 'NULL'){
        $sql .= "NULL, ";
      }else {
        $sql .= ":$key, ";
      }
		}
		// Supprime les caractères superflus en fin de requète
		$sql = substr($sql, 0, -2);
		$sql .= ')';

		$sth = $this->dbh->prepare($sql);
		foreach($data as $key => $value){
      if($value == 'NULL'){
      }else {
  			$value = ($stripTags) ? strip_tags($value) : $value;
  			$sth->bindValue(':'.$key, $value);
      }
		}

		if (!$sth->execute()){
			return false;
		}
		return $this->find($this->lastInsertId());
	}

	public function update(array $data, $id, $stripTags = true)
	{
		if (!is_numeric($id)){
			return false;
		}

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
		$sql .= ' WHERE ' . $this->primaryKey .' = :id';

		$sth = $this->dbh->prepare($sql);
		foreach($data as $key => $value){
      if($value == 'NULL'){
      }else {
        $value = ($stripTags) ? strip_tags($value) : $value;
        $sth->bindValue(':'.$key, $value);
      }
		}
		$sth->bindValue(':id', $id);

		if(!$sth->execute()){
			return false;
		}
		return $this->find($id);
	}
  public function escapeKeys($datas)
  {
    return array_map(function($val){
      return '`'.$val.'`';
    }, $datas);
  }

}
