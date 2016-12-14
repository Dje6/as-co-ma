<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\monCompteModel;

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
