<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\UsersCustomModel;
use \Model\AssocModel;
use \Service\ValidationTools;
use \Model\RolesModel;
use \Model\UserModel;
use \W\Security\AuthentificationModel;


class AssocController extends CustomController
{
  //affiche les information de l'association qui sont enregistrer en base de donnee
  //uniquement pour les Admin de l'association , quel soit active ou en attente d'activation
  public function home($slug)
  {
    if(isset($_SESSION['user'])){
      if($this->allowToTwo('Admin','Assoc',$slug)){

        $donnee = $this->infoBdd('Assoc',$slug,['statusA'=> 'Actif','statusB'=> 'En attente']);
        $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee]);
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
        $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee,'edition' => true]);
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
        $error['nom'] = ValidationTools::textValid($r_POST['nom'],'nom',3,100);
        $error['adresse'] = ValidationTools::textValid($r_POST['adresse'],'adresse',3,50);
        $error['code_postal'] = ValidationTools::code_postalVerif($r_POST['code_postal']);
        $error['ville'] = ValidationTools::textValid($r_POST['ville'],'ville',3,50);
        $error['fix'] = ValidationTools::telVerif($r_POST['fix'],true);
        $error['description'] = ValidationTools::textValid($r_POST['description'],'description',10,500,true);

        if(ValidationTools::IsValid($error)){
          if(empty($r_POST['fix'])){
            unset($r_POST['fix']);
          }
          if(empty($r_POST['description'])){
            unset($r_POST['description']);
          }
          unset($r_POST['submit']);

          $id = $assocModel->FindElementByElement('id','slug',$slug);
          $result = $assocModel->update($r_POST,$id);
          if(!$result){
            $this->show('admin/assoc',['slug' => $slug,'orga' => 'assoc','edition' => true,'bug' => 'L\'insertion n\'a pas pu aboutir', 'donnee' => $r_POST]);
          }else {
            $this->redirectToRoute('admin_assoc', ['slug' => $slug]);
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
      if($this->allowToTwo('Admin','Assoc',$slug)){
        $assocModel = new AssocModel;
        $rolesModel = New RolesModel;

         $slug = $this->nettoyage($slug);
         $id_membre = $this->nettoyage($id);

         $id_assoc = $assocModel->FindElementByElement('id','slug',$slug);
         $resultat = $rolesModel->FindRole($id_assoc,$id_membre);

         $id_roles =  $resultat['id'];
         $role = $resultat['role'];
         if($role == 'Admin'){
           //new role est user
           $newRole = 'User';
           $result = $rolesModel->update(['role' => $newRole],$id_roles);
         }else {
           //new role est admin
           $newRole = 'Admin';
           $result = $rolesModel->update(['role' => $newRole],$id_roles);
         }
            if($result){ //si l'update c bien passer on avance

              if($id_membre == $_SESSION['user']['id']){
                //si on a changer notre propre droit , on detruit notre session pour la reconstruire avec les nouveau droit
                 $pseudo = $_SESSION['user']['pseudo'];
                 $authent = new AuthentificationModel();
                 $authent->logUserOut();
                 $get_user = new UserModel;
                 $user = $get_user->getUserByUsernameOrEmail($pseudo);

                 $authent->logUserIn($user);
                 //ca planter ici
                 if($newRole == 'Admin'){//on detect si on vien de passer de user a admin ou de admin a user
                   //si on es devenu user on es rediriger vers le listing (ce cas de figure est IMPOSSIBLE)
                   //puisque pour fair un changement de role il faut etre user , mais bon c'est fais
                   $this->redirectToRoute('admin_assoc_membres',['slug' => $slug, 'page' => 1]);
                 }else {
                   //sinon c'est qu'on es devenu user , donc on a pu acces au listing , alors on es renvoyer sur notre compte
                   $this->redirectToRoute('admin_monCompte');
                 }
               }else {//sinon on peu directement rediriger puisque ca ne concerner pas notre session
                 $this->redirectToRoute('admin_assoc_membres',['slug' => $slug, 'page' => 1]);
               }
            } else {
              echo 'un soucis lors de la mise a jour du role';
            }
      }
    }else {
      $this->redirectToRoute('racine_form');
    }
  }

}
