<?php
namespace Controller\admin;
use \Controller\CustomController;

use \Model\MairieModel;
use \Model\PicturesModel;
use \Model\AssocModel;
use \Model\NewsModel;
use \Model\RolesModel;
use \Model\ContactModel;
use \Model\AbonnesModel;
/**
 *
 */
class DestroyController extends CustomController
{
  public function DeleteMairie($id_mairie)
  {
    $MairieModel = new MairieModel;
    $MairieFull = $MairieModel->Find($id_mairie);
    $assoc_affilier = $MairieModel->findListe($MairieFull['slug']);

      if(!empty($assoc_affilier)){
        foreach ($assoc_affilier as $key => $value) {
          $result = $this->DeleteAssoc($value['id']);
          if(is_array($result)){
            $error['assoc'] = $result;
          }
        }
      }

      if(!$this->DeleteRole($id_mairie,'mairie')){
        $error['roles'] = 'probleme pour la suppression des roles';
      }

      if(!$this->DeletePicture($MairieFull['avatar'])){
        $error['picture']['avatar'] = 'probleme de suppression image avatar';
      }

      if(!$this->DeletePicture($MairieFull['background'])){
        $error['picture']['background'] = 'probleme de suppression image background';
      }

      $NewsModel = new NewsModel;
      $AllNews = $NewsModel->AllNewsID($id_mairie,'mairie');
      if(!empty($AllNews)){
        foreach ($AllNews as $key => $value) {
          if(!$this->DeleteNews($value['id'])){
            $error['news'][$value['id']] = 'probleme de suppression news '.$value['id'];
          }
        }
      }

      if(!$this->DeleteContact($id_mairie,'mairie')){
        $error['contact'] = 'probleme de suppression des messages';
      }

      if(!$this->DeleteAbonnee($id_mairie,'mairie')){
        $error['abonnee'] = 'probleme de suppression des entrer de newsletter';
      }

      if(!$MairieModel->delete($id_mairie)){
        $error['mairie'] = 'probleme pour la suppression de la mairie';
      }

    if(!isset($error)){
      return true;
    }else {
      return $error;
    }
  }

  public function DeleteAssoc($id_assoc)
  {
      $assocModel = new AssocModel;
      $AssocFull = $assocModel->Find($id_assoc);

      if(!$this->DeleteRole($id_assoc,'assoc')){
        $error['roles'] = 'probleme pour la suppression des roles';
      }

      if(!$this->DeletePicture($AssocFull['avatar'])){
        $error['picture']['avatar'] = 'probleme de suppression image avatar';
      }

      if(!$this->DeletePicture($AssocFull['background'])){
        $error['picture']['background'] = 'probleme de suppression image background';
      }

      $NewsModel = new NewsModel;
      $AllNews = $NewsModel->AllNewsID($id_assoc,'assoc');
      if(!empty($AllNews)){
        foreach ($AllNews as $key => $value) {
          if(!$this->DeleteNews($value['id'])){
            $error['news'][$value['id']] = 'probleme de suppression news '.$value['id'];
          }
        }
      }

      if(!$this->DeleteContact($id_assoc,'assoc')){
        $error['contact'] = 'probleme de suppression des messages';
      }

      if(!$this->DeleteAbonnee($id_assoc,'assoc')){
        $error['abonnee'] = 'probleme de suppression des entrer de newsletter';
      }

      if(!$assocModel->delete($id_assoc)){
        $error['assoc'] = 'probleme pour la suppression de l assoc';
      }

      if(!isset($error)){
        return true;
      }else {
        return $error;
      }
  }

  public function DeleteMembre($slug,$id_membre)
  {
    $assocModel = new AssocModel;
    $rolesModel = New RolesModel;
    $id_assoc = $assocModel->FindElementByElement('id','slug',$slug);

    if($this->deleteRole($id_membre,'assoc')){
      return true;
    }
    return false;
  }

  public function DeletePicture($id_picture)
  {
    $picturesModel = new PicturesModel();
    $relatif = $picturesModel->FindElementByElement('relatif','id',$id_picture);
    if(!empty($relatif)){
      $detail = explode('/',$relatif);
      $orga = $detail[1];
      $type = $detail[2];
      $nom = $detail[3];
      if($picturesModel->delete($id_picture)){
        if(unlink('./assets/img/'.$orga.'/'.$type.'/'.$nom)){
          return true;
        }
      }
      return false;
    }
    return true;
  }

  public function DeleteNews($id_news)
  {
    $NewsModel = new NewsModel;
    $id_picture = $NewsModel->FindElementByElement('picture','id',$id_news);
    if(!empty($id_picture)){
      $this->DeletePicture($id_picture);
    }
    if($NewsModel->delete($id_news)){
      return true;
    }
    return false;
  }
  public function DeleteContact($id_orga,$orga)
  {
    $ContactModel = new ContactModel;
    if($ContactModel->deleteByType($id_orga,$orga)){
      return true;
    }
    return false;
  }

  public function DeleteAbonnee($id,$orga)
  {
    $AbonnesModel = new AbonnesModel;
    if($AbonnesModel->deleteByOrga($id,$orga)){
      return true;
    }
    return false;
  }

  public function DeleteRole($id_orga,$orga)
  {
    $rolesModel = new RolesModel;

    if($rolesModel->deleteRoles($id_orga,'id_'.$orga)){
      if($orga != 'user'){
        if($orga == 'assoc'){
          $AssocModel = new AssocModel;
          $slug = $AssocModel->FindElementByElement('slug','id',$id_orga);
        }elseif ($orga == 'mairie') {
          $MairieModel = new MairieModel;
          $slug = $MairieModel->FindElementByElement('slug','id',$id_orga);
        }
        $roleSession = $this->in_multi_array_return_array_and_key($slug,$_SESSION['user']['roles']);
        unset($_SESSION['user']['roles'][$roleSession['key']]);
      }
      return true;
    }
    return false;
  }

}
