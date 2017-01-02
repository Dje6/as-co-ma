<?php
namespace Model;

use \W\Model\ConnectionModel;

class MonCompteModel extends CustomModel
{
  public function __construct()
  {
    $this->setTable('users');
    $this->dbh = ConnectionModel::getDbh() ;
  }
  //recupere les information d'un menbre precis d'une association, uniquement des information "public"
  // son id , pseudo, mail,prenom,nom,adresse code postal ville, fix , mobil , date creation derniere Connectio
  // et le tableau de role
  public function membre($slug,$id)
  {
    $sql = 'SELECT u.id,u.pseudo,u.mail,u.prenom,u.nom,u.adresse,u.code_postal,
    u.ville,u.fix,u.mobile,u.created_at,u.lost_connect,r.role,p.relatif AS avatar
    FROM users AS u LEFT JOIN roles AS r ON
    u.id = r.id_user LEFT JOIN pictures AS p ON u.avatar = p.id WHERE u.id = :id AND r.id_assoc = (SELECT id FROM assoc WHERE slug = :slug) ' ;
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', $id);
    $sth->bindValue(':slug', $slug);
    $sth->execute();
    $info = $sth->fetch();
    if(!$info){
      return 'Aucun membre ne correspond à cet identifiant.';
    }else {
      return $info ;
    }
  }

}
