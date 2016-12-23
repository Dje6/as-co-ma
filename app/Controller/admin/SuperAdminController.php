<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\MairieModel;
use \Model\RolesModel;


class SuperAdminController extends CustomController
{
  public function listeMairie()
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('SuperAdmin','Webmaster',0)){

        $MairieModel = new MairieModel;
        $donnee = $MairieModel->findAll();
        $this->show('admin/liste',['slug' => 'webmaster','orga' => 'webmaster','donnee' => $donnee]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function EditStatus($id)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('SuperAdmin','Webmaster',0)){
        $MairieModel = new MairieModel;

         $id = $this->nettoyage($id);

         $status = $MairieModel->FindElementByElement('status','id',$id);
         if($status == 'Actif'){
           $result = $MairieModel->update(['status' => 'En attente'],$id);
         }else {
           $result = $MairieModel->update(['status' => 'Actif'],$id);
         }

        $this->redirectToRoute('admin_webmaster_mairie',['page' => 1]);
      }
    }else {
      $this->redirectToRoute('racine_form');
    }
  }

  public function DeleteMairie($id)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('SuperAdmin','Webmaster',0)){

        $MairieModel = new MairieModel;

        $id = $this->nettoyage($id);

        $result = $MairieModel->delete($id);
        if($result){
          $rolesModel = new RolesModel;
          $result2 = $rolesModel->deleteRoles($id,'id_mairie');
          if($result2){
            $this->redirectToRoute('admin_webmaster_mairie',['page' => 1]);
          }
        }else {

        }
      }

    }else {
      $this->redirectToRoute('racine_form');
    }
  }

}
