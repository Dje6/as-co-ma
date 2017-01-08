<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Controller\admin\DestroyController;
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
    // affiche le formulaire de modification des données de l'utilisateur
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
    // Traite le formulaire en POST, si tout se passe bien : update des données de l'utilisateur
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

          unset($r_POST['submit']);
          if(isset($r_POST['avt'])){
            unset($r_POST['avt']);
          }

          $id = $_SESSION['user']['id'];
          $result = $userModel->update($r_POST,$id);
          if(!$result){
            $this->show('admin/users', ['edition' => true, 'donnee' => $r_POST]);
            } else {
              if(!empty($_FILES['image']['name'])){
                $PicturesController = new PicturesController;
                $PicturesController->picturesPost('users','users','avatar');
              }

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
        $error['donnee'] = 'Donnée(s) manquante(s)';
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
        if($this->isAjax()){
          return $this->showJson(['resultat'=> $donnees]);
        }
        $this->show('admin/users',['orga' => 'assoc','slug' => $slug,'acces' => 'np','donnee' => $donnees]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  public function delete()
  {
    // affiche le formulaire de modification des données de l'utilisateur
    if(isset($_SESSION['user']))
    {
      $id_user = $_SESSION['user']['id'];

      $DestroyController = new DestroyController;
      $resultat = $DestroyController->DeleteUser($id_user);
      
      if($this->isAjax()){
        if(!is_array($resultat)){
          $resultat = $this->generateUrl('default_home');
        }
        return $this->showJson(['resultat' => $resultat]);
      }

      if(!$resultat){
        $this->showErrors('Un problème est survenu lors de la suppression du compte utilisateur');
      }else {
        $this->redirectToRoute('default_home');
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }




}
