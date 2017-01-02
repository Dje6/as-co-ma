<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\MairieModel;
use \Model\RolesModel;
use \Model\ContactModel;
use \Model\AssocModel;


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

        $ContactModel = new ContactModel;
        if($ContactModel->deleteByType($id,'mairie')){

          $slug_Mairie = $MairieModel->FindElementByElement('slug','id',$id);
          $assoc_affilier = $MairieModel->findListe($slug_Mairie);
          $erreur = 0;

          if(!empty($assoc_affilier)){
            $assocModel = new AssocModel;
            $rolesModel = new RolesModel;
            $contactModel = new ContactModel;

            foreach ($assoc_affilier as $key => $value) {
              $result = $assocModel->delete($value['id']);
              if($result){
                $result2 = $rolesModel->deleteRoles($value['id'],'id_assoc');

                $roleSession = $this->in_multi_array_return_array_and_key($value['slug'],$_SESSION['user']['roles']);
                unset($_SESSION['user']['roles'][$roleSession['key']]);

                if($result2){
                  $result3 = $contactModel->deleteByType($value['id'],'assoc');
                  if(!$result3){
                    $erreur += 1;
                  }
                }else {
                  $erreur += 1;
                }
              }else {
                $erreur += 1;
              }
            }
          }
          if($erreur == 0){
            if($MairieModel->delete($id)){
              $rolesModel2 = new RolesModel;

              if($rolesModel2->deleteRoles($id,'id_mairie')){
                $roleSession2 = $this->in_multi_array_return_array_and_key($slug_Mairie,$_SESSION['user']['roles']);
                unset($_SESSION['user']['roles'][$roleSession2['key']]);
                $this->redirectToRoute('admin_webmaster_mairie',['page' => 1]);

              }else {
                $this->showErrors('Un problème est survenu lors de la suppression des rôles.');
              }
            }else {
              $this->showErrors('Un problème est survenu lors de la suppression de la Mairie.');
            }
          }else {
            $this->showErrors('Un problème est survenu lors de la suppression des '.$erreur.' associations affiliées.');
          }
        }else {
          $this->showErrors('Un problème est survenu lors de la suppression des messages.');
        }
      }
    }else {
      $this->redirectToRoute('racine_form');
    }
  }

}
