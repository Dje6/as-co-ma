<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\monCompteModel;
use \Model\UserModel;
use \Service\ValidationTools;
use \W\Security\AuthentificationModel;
use Service\CustomFile;

class UsersController extends CustomController
{
  //affiche les donnee de la session actuel
  public function home()
  {

    if(isset($_SESSION['user']))
    {
      $donnees = $_SESSION['user'];
      $this->show('admin/users',['donnee' => $donnees]);
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function homeEditionForm()
  {
    if(isset($_SESSION['user']))
    {
      $donnees = $_SESSION['user'];
      $this->show('admin/users',['donnee' => $donnees,'edition' => true]);
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function homeEditionPost()
  {
    if(isset($_SESSION['user']))
    {
      $error = array();
      $userModel = new UserModel;
      $donnee = $_SESSION['user'];

      if(!empty($_POST))
      {
        $r_POST = $this->nettoyage($_POST);
        $error['nom'] = ValidationTools::textValid($r_POST['nom'],'nom',3,30);
        $error['prenom'] = ValidationTools::textValid($r_POST['prenom'],'prenom',3,30);
        $error['mail'] = ValidationTools::emailValid($r_POST['mail']);
        $error['adresse'] = ValidationTools::textValid($r_POST['adresse'],'adresse',3,50);
        $error['code_postal'] = ValidationTools::code_postalVerif($r_POST['code_postal']);
        $error['ville'] = ValidationTools::textValid($r_POST['ville'],'ville',3,30);
        $error['mobile'] = ValidationTools::telVerif($r_POST['mobile'],true);
        $error['fix'] = ValidationTools::telVerif($r_POST['fix'],true);


        if(ValidationTools::IsValid($error)){
          if(empty($r_POST['mobile'])){
            unset($r_POST['mobile']);
          }
          if(empty($r_POST['fix'])){
            unset($r_POST['fix']);
          }
          unset($r_POST['submit']);

          $id = $_SESSION['user']['id'];
          $result = $userModel->update($r_POST,$id);
          if(!$result){
            $this->show('admin/users', ['edition' => true, 'donnee' => $r_POST]);
            } else {
              $pseudo = $_SESSION['user']['pseudo'];
              $Authent = new AuthentificationModel();
              $Authent -> logUserOut();
              $get_user = new UserModel;
              $user = $get_user->getUserByUsernameOrEmail($pseudo);

              $Authent->logUserIn($user);
              $this->redirectToRoute('admin_monCompte');
            }

        } else {
          $this->show('admin/users', ['edition' => true, 'donnee' => $r_POST, 'error' => $error]);
        }
        // debug($_SESSION['user']['id']);
        // $this->show('admin/users',['donnee' => 'Moulinette en cours']);
      } else {
        $error['donnee'] = "données manquante";
      }

    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  //affiche les information user d'un menbre d'association
  public function ficheMembre($slug,$id)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slug)){
        $model = new monCompteModel;
        $donnees =  $model->membre($slug,$id);
        $this->show('admin/users',['orga' => 'assoc','slug' => $slug,'acces' => 'np','donnee' => $donnees]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  public function homeEditionAvatarPost()
  {
    if(isset($_SESSION['user']))
    {

      function URLimg($path)
       {
           $app = getApp();
           $courant = str_replace('/','\\',$app->getBasePath() );
           $base = str_replace('/','\\',$_SERVER['DOCUMENT_ROOT'] );
           return $base.$courant. '\assets\\img\\'.$path;
       }
      $customFile = new CustomFile(URLimg('avatar'));
      $storage = new \Upload\Storage\FileSystem(URLimg('avatar'));
      $file = new \Upload\File('image', $storage);

      $new_filename = uniqid();
      $file->setName($new_filename);

      $file->addValidations(array(
      // Ensure file is of type "image/png"
      new \Upload\Validation\Mimetype(array('image/png', 'image/jpg', 'image/jpeg')),

      //You can also add multi mimetype validation
      //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

      // Ensure file is no larger than 5M (use "B", "K", M", or "G")
      new \Upload\Validation\Size('2M')
      ));
      $data = array(
      'name' => $new_filename,
      'type'        => $file->getExtension(),
      'mime'        => $file->getMimetype(),
      'size'        => $file->getSize(),
      'md5'         => $file->getMd5(),
      'dimensions'  => $file->getDimensions(),
      'emplacement' => $customFile->getDirectory() . $file->getNameWithExtension() ,
      );
      try {
      $file->upload();
      debug($data);
      } catch (\Exception $e) {
          // Fail!
          $errors = $file->getErrors();
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

}
