<?php
namespace Model;

use \W\Model\UsersModel;
use \W\Model\ConnectionModel;
use \W\Security\AuthentificationModel;

class UsersCustomModel extends UsersModel
{
  //verifie si le token et l'email corresponde bien a un utilisateur
  //si oui on retourne sont ID
  public function tokenOk($mail,$token)
  {
    $sql = 'SELECT id FROM ' . $this->table . ' WHERE mail = :mail AND token = :token';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':mail', $mail);
    $sth->bindValue(':token', $token);
    $sth->execute();

    return $sth->fetchColumn();
  }
// surcharge!!!!!!!
// surcharge!!!!!!!
// surcharge!!!!!!!
// surcharge!!!!!!!
  public function isValidLoginInfo($usernameOrEmail, $plainPassword)
  {

    $app = getApp();

    $usernameOrEmail = strip_tags(trim($usernameOrEmail));
    $foundUser = $this->getUserByUsernameOrEmail($usernameOrEmail);
    if(!$foundUser){
      return 0;
    }

    if(password_verify($plainPassword, $foundUser[$app->getConfig('security_password_property')])){
      return (int) $foundUser[$app->getConfig('security_id_property')];
    }

    return 0;
  }
  // surcharge!!!!!!!
  // surcharge!!!!!!!
  // surcharge!!!!!!!
  // surcharge!!!!!!!
  public function isGranted($role,$organisation,$slug_orga)
  {
    $app = getApp();
    $roleProperty = $_SESSION['user']['roles'];
    //si on es SUPERADMIN, on a automatiquement acces a tout
    if(in_array('SuperAdmin',$roleProperty)){
      return true;
    }

    //récupère les données en session sur l'utilisateur
    $authentificationModel = new AuthentificationModel();
    $loggedUser = $authentificationModel->getLoggedUser();

    // Si utilisateur non connecté
    if (!$loggedUser){
      // Redirige vers le login
      $this->redirectToLogin();
    }
    if (!empty($loggedUser['roles'])){

      if (!is_array($roleProperty)){
        $roleProperty = [$roleProperty];
      }
      foreach ($roleProperty as $key => $value) {
        if(isset($value['orga'])){
          if(!empty($value['orga'])){
            if($value['orga'] == $organisation){
              if($value['slug'] == $slug_orga){
                if($value['role'] == $role){
                  return true;
                }
              }
            }
          }
        }
      }
    }
      return false;
  }
// surcharge!!!!!!!
// surcharge!!!!!!!
// surcharge!!!!!!!
// surcharge!!!!!!!
// surcharge!!!!!!!
// surcharge!!!!!!!

  public function getUserByUsernameOrEmail($usernameOrEmail)
	{

		$app = getApp();

		$sql = 'SELECT * FROM ' . $this->table .'
			  WHERE '.$app->getConfig('security_username_property').' = :username' .
			   ' OR ' . $app->getConfig('security_email_property') . ' = :email LIMIT 1';

		$dbh = ConnectionModel::getDbh();
		$sth = $dbh->prepare($sql);
		$sth->bindValue(':username', $usernameOrEmail);
		$sth->bindValue(':email', $usernameOrEmail);

		if($sth->execute()){
			$foundUser = $sth->fetch();
      $sql = 'SELECT r.id_mairie,r.id_assoc,r.id_site,r.role,a.slug AS Aslug,
      m.slug AS Mslug,a.nom AS Anom,m.nom AS Mnom
      FROM roles AS r LEFT JOIN assoc AS a
      ON r.id_assoc = a.id LEFT JOIN mairie AS m
      ON r.id_mairie = m.id WHERE r.id_user = :userid ';

      $dbh = ConnectionModel::getDbh();
      $sth = $dbh->prepare($sql);
      $sth->bindValue(':userid', $foundUser['id']);
      $sth->execute();

      foreach ($sth->fetchAll() as $key => $value) {

        if(!empty($value['id_mairie'])){
          $foundUser['roles'][$key]['orga'] = 'Mairie';
          $foundUser['roles'][$key]['id'] = $value['id_mairie'];
          $foundUser['roles'][$key]['role'] = $value['role'];
          $foundUser['roles'][$key]['nom'] = $value['Mnom'];
          $foundUser['roles'][$key]['slug'] = $value['Mslug'];

        }elseif(!empty($value['id_site'])){
          $foundUser['roles'][$key]['orga'] = 'Site';
          $foundUser['roles'][$key]['id'] = $value['id_site'];
          $foundUser['roles'][$key]['role'] = $value['role'];
          $foundUser['roles'][$key]['slug'] = '0';

        }elseif(!empty($value['id_assoc'])){
          $foundUser['roles'][$key]['orga'] = 'Assoc';
          $foundUser['roles'][$key]['id'] = $value['id_assoc'];
          $foundUser['roles'][$key]['role'] = $value['role'];
          $foundUser['roles'][$key]['nom'] = $value['Anom'];
          $foundUser['roles'][$key]['slug'] = $value['Aslug'];
        }
      }
			if($foundUser){
				 return $foundUser;
			}
		}
		 return false;
	}

}
