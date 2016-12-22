<?php
namespace Controller\admin;

use \Controller\CustomController;


class SuperAdminController extends CustomController
{
  public function home()
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('SuperAdmin','Webmaster',0)){
        $this->show('admin/SuperAdmin',['slug'=> 'webmaster','orga' =>'webmaster']);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function listeMairie()
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('SuperAdmin','Webmaster',0)){

        $donnee = $this->listing();
        $this->show('admin/liste',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function listing()
  {
      $MairieModel = new MairieModel;
      return $MairieModel->findListe($slug);
  }

}
