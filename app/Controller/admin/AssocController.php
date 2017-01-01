<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\UsersCustomModel;
use \Model\AssocModel;
use \Service\ValidationTools;
use \Model\RolesModel;
use \Model\UserModel;
use \W\Security\AuthentificationModel;
use \Service\Slugify;
use \Model\ContactModel;
use \PHPMailer;


class AssocController extends CustomController
{
  //affiche les information de l'association qui sont enregistrer en base de donnee
  //uniquement pour les Admin de l'association , quel soit active ou en attente d'activation
  public function home($slug)
  {
    if(isset($_SESSION['user'])){
      if($this->allowToTwo('Admin','Assoc',$slug)){

        $donnee = $this->infoBdd('Assoc',$slug,['statusA'=> 'Actif','statusB'=> 'En attente']);

        if(empty($donnee['nom'])){
          $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee,'creation' => true]);
        }else {
          $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  //retourne la liste des menbres inscrit dans l'association
  public function listeMembres($slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slug)){

        $donnee = $this->listing('Assoc',$slug);
        $this->show('admin/liste',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }


  public function homeEditForm($slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slug)){

        $donnee = $this->infoBdd('Assoc',$slug,['statusA' => 'Actif','statusB' => 'En attente']);

        if(empty($donnee['nom'])){
          $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee,'edition' => true,'creation' =>true]);
        }else {
          $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee,'edition' => true]);
        }
      }

    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  public function homeEditPost($slug)
  {
    if(isset($_SESSION['user']))
    {
      $error = array();
      $assocModel = new AssocModel();

      if(!empty($_POST))
      {
        $r_POST = $this->nettoyage($_POST);
        if(isset($r_POST['nom'])){
          $error['nom'] = ValidationTools::textValid($r_POST['nom'],'nom',3,100);
        }
        $error['adresse'] = ValidationTools::textValid($r_POST['adresse'],'adresse',3,50);
        $error['code_postal'] = ValidationTools::code_postalVerif($r_POST['code_postal']);
        $error['ville'] = ValidationTools::textValid($r_POST['ville'],'ville',3,50);
        $error['fix'] = ValidationTools::telVerif($r_POST['fix'],true);
        $error['description'] = ValidationTools::textValid($r_POST['description'],'description',10,500,true);
        $error['mail'] = ValidationTools::emailValid($r_POST['mail']);

        if(ValidationTools::IsValid($error)){

          unset($r_POST['submit']);

          if(isset($r_POST['nom'])){
            $r_POST['slug'] = Slugify::slugify($r_POST['nom']);
          }

          $id = $assocModel->FindElementByElement('id','slug',$slug);
          $result = $assocModel->update($r_POST,$id);
          if(!$result){
            $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','edition' => true,'bug' => 'L\'insertion n\'a pas pu aboutir', 'donnee' => $r_POST]);
          }else {
            $ArrayAvatar = $_FILES['avatar'];
            $ArrayBackground = $_FILES['background'];
            unset($_FILES['avatar']);
            unset($_FILES['background']);

            if(!empty($ArrayAvatar['name'])){
              $_FILES['image'] = $ArrayAvatar;
              $PicturesController = new PicturesController;
              $PicturesController->picturesPost('assoc',$slug,'avatar');
              unset($_FILES['avatar']);
            }
            if(!empty($ArrayBackground['name'])){
              $_FILES['image'] = $ArrayBackground;
              $PicturesController = new PicturesController;
              $PicturesController->picturesPost('assoc',$slug,'background');
              unset($_FILES['background']);
            }

            if(isset($r_POST['nom'])){
              $roleSession = $this->in_multi_array_return_array_and_key($slug,$_SESSION['user']['roles']);
              $_SESSION['user']['roles'][$roleSession['key']]['nom'] = $r_POST['nom'];
              $_SESSION['user']['roles'][$roleSession['key']]['slug'] = $r_POST['slug'];

              $this->redirectToRoute('admin_assoc', ['slug' => $r_POST['slug']]);
            }else {
              $this->redirectToRoute('admin_assoc', ['slug' => $slug]);
            }
          }
        } else {
          $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','edition' => true,'error' => $error, 'donnee' => $r_POST]);
        }
      } else {
        $error['donnee'] = 'Donnée(s) manquante(s).';
      }
    } else {
      $this->redirectToRoute('racine_form');
    }
  }

  public function homeEditUserRole($slug,$id)
  {
    if(isset($_SESSION['user']))
    {
      $assocModel = new AssocModel;
      $rolesModel = New RolesModel;
      if($this->allowToTwo('Admin','Assoc',$slug)){

         $slug = $this->nettoyage($slug);
         $id_membre = $this->nettoyage($id);
         $id_assoc = $assocModel->FindElementByElement('id','slug',$slug);
         $resultat = $rolesModel->FindRole($id_assoc,$id_membre);
         $id_roles =  $resultat['id'];
         $role = $resultat['role'];
         if($role == 'Admin'){
           $newRole = 'User';
           $result = $rolesModel->update(['role' => 'User'],$id_roles);
         }else {
            $newRole = 'Admin';
           $result = $rolesModel->update(['role' => 'Admin'],$id_roles);
         }
            if($result){
              if($id_membre == $_SESSION['user']['id']){
                 $pseudo = $_SESSION['user']['pseudo'];
                 $authent = new AuthentificationModel();
                 $authent->logUserOut();
                 $get_user = new UserModel;
                 $user = $get_user->getUserByUsernameOrEmail($pseudo);

                 $authent->logUserIn($user);
                 if($newRole == 'User'){
                   $this->redirectToRoute('racine_assoc',['orga'=>'Assoc','slug' => $slug]);
                 }elseif($newRole == 'Admin') {
                   $this->redirectToRoute('admin_assoc_membres',['slug' => $slug, 'page' => 1]);
                 }
               }
               $this->redirectToRoute('admin_assoc_membres',['slug' => $slug, 'page' => 1]);
            } else {
              $this->showErrors('un soucis lors de la mise a jour du role');
            }
      }
    }else {
      $this->redirectToRoute('racine_form');
    }
  }

  public function homeDeleteUserAssoc($slug,$id)
  {
    if(isset($_SESSION['user']))
    {
      $assocModel = new AssocModel;
      $rolesModel = New RolesModel;
      if($this->allowToTwo('Admin','Assoc',$slug)){

         $slug = $this->nettoyage($slug);
         $id_membre = $this->nettoyage($id);
         $id_assoc = $assocModel->FindElementByElement('id','slug',$slug);
         $resultat = $rolesModel->FindRole($id_assoc,$id_membre);
         $id_roles =  $resultat['id'];
         $role = $resultat['role'];
         $result = $rolesModel->deleteRoles($id_roles,'id');
            if($result){
              $confirm = 'Le membre a bien ete supprimer';

              if($id_membre == $_SESSION['user']['id']){
                 $pseudo = $_SESSION['user']['pseudo'];
                 $authent = new AuthentificationModel();
                 $authent->logUserOut();
                 $get_user = new UserModel;
                 $user = $get_user->getUserByUsernameOrEmail($pseudo);

                 $authent->logUserIn($user);

                 $this->redirectToRoute('admin_assoc_membres',['slug' => $slug, 'page' => 1,'confirmation'=>$confirm]);
               } else {
                 $this->redirectToRoute('admin_assoc_membres',['slug' => $slug, 'page' => 1,'confirmation'=>$confirm]);
               }
            } else {
              $this->showErrors('un soucis lors de la suppresion du role');
            }
      }
    }else {
      $this->redirectToRoute('racine_form');
    }

  }

}
