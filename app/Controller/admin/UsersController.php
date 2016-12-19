<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\monCompteModel;
use \Model\UserModel;
use \Service\ValidationTools;

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
      $userModel = new UserModel();

      if(!empty($_POST))
      {
        $r_POST = $this->nettoyage($_POST);
        $error['nom'] = ValidationTools::textValid($r_POST['nom'],'nom',3,30);
        $error['prenom'] = ValidationTools::textValid($r_POST['prenom'],'prenom',3,30);
        $error['mail'] = ValidationTools::emailValid($r_POST['mail']);
      }

      $donnees = $_SESSION['user'];
      $this->show('admin/users',['donnee' => 'Moulinette en cours']);
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  //affiche les information user d'un menbre d'association
  public function ficheMenbre($slug,$id)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slug)){
        $model = new monCompteModel;
        $donnees =  $model->menbre($slug,$id);
        $this->show('admin/users',['orga' => 'assoc','slug' => $slug,'acces' => 'np','donnee' => $donnees]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

}
