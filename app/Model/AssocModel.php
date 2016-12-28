<?php
namespace Model;

use \W\Model\ConnectionModel;

class AssocModel extends CustomModel
{
  //on precise a quel table on se connecte
  public function __construct()
  {
    $this->setTable('assoc');
    $this->dbh = ConnectionModel::getDbh() ;
  }
  // on prepare la requete pour rechercher en base de donnee si une assoc correspon a nos critere
  // ici on detect si on recherche un numeros de departement , un code postal ou un mot
  public function searchAssoc($search)
  {
    if(is_numeric($search)){
      if(strlen($search) == 2 || strlen($search) == 3){
        return $this->searchAssocDepartement(['departement' => $search],'OR', $stripTags = true,'m.');
        //le m. est lier a la jointure, voir la fonction pour comprendre
      }elseif(strlen($search) == 5){
        return $this->searchAssocDepartement(['code_postal' => $search],'OR', $stripTags = true,'m.');
        //le m. est lier a la jointure, voir la fonction pour comprendre
      }
    }else{
      return $this->searchAssocDepartement(['nom' => $search],'OR', $stripTags = true,'a.');
      //le a. est lier a la jointure, voir la fonction pour comprendre
    }
  }
  // on recherche en base de donnee si une association corespond a departement , un code postal , ou une ville
  public function searchAssocDepartement(array $search, $operator = 'OR', $stripTags = true,$alias_table){

    // Sécurisation de l'opérateur
    $operator = strtoupper($operator);
    if($operator != 'OR' && $operator != 'AND'){
      die('Error: invalid operator param');
    }

        $sql = 'SELECT a.nom,a.slug,m.nom AS mnom,m.code_postal AS mCP FROM ' . $this->table.' AS a
        LEFT JOIN mairie AS m ON a.id_mairie = m.id WHERE';
        //bien verifier dans le foreach suivant l'alias du nom de colonne

    foreach($search as $key => $value){
      $sql .= " $alias_table`$key` LIKE :$key ";
      $sql .= $operator;
    }
    // Supprime les caractères superflus en fin de requète
    if($operator == 'OR') {
      $sql = substr($sql, 0, -3);
    }
    elseif($operator == 'AND') {
      $sql = substr($sql, 0, -4);
    }
    $sql.= ' AND a.status = "Actif" ';
    $sth = $this->dbh->prepare($sql);

    foreach($search as $key => $value){
      $value = ($stripTags) ? strip_tags($value) : $value;
      $sth->bindValue(':'.$key, '%'.$value.'%');
    }
    if(!$sth->execute()){
      return false;
    }
    $donnee = $sth->fetchAll();

    if(empty($donnee)){
      return 'Aucune Association trouvée.';
    }
        return $donnee;
  }
// recherche un menbre par son ID et retourne ses information
  public function findMenbre($slug)
  {
    $sql = "SELECT id_user FROM roles WHERE id_assoc = (SELECT id FROM assoc WHERE slug = :slug)";
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':slug', $slug);
    $sth->execute();
    $users_id = $sth->fetchAll();

    if(!empty($users_id)){
      $where='(';
      foreach ($users_id as $key => $value) {
        $where .= 'u.id = '.$value['id_user'].' OR ';
      }
      $where = substr($where,0,-3);
      $where .= ") AND r.id_assoc = (SELECT id FROM assoc WHERE slug = :slug)";

      $sql = 'SELECT DISTINCT u.id,u.pseudo,u.mail,u.prenom,u.nom,r.role FROM users AS u LEFT JOIN roles AS r ON
      u.id = r.id_user WHERE '.$where ;
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':slug', $slug);
      $sth->execute();
      $donnee = $sth->fetchAll();
    }

    if(isset($donnee)){
      if(!is_array($donnee)){
        return 'Aucun membre présent dans l\'Association.';
      }else{
        return $donnee;
      }
    }else {
      return 'Aucun membre présent dans l\'Association.';
    }
  }
}
