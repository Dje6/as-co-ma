<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\MairieModel;
use \Service\ValidationTools;
use \Model\AssocModel;
use \Model\ContactModel;
use \Model\RolesModel;
use \Service\Slugify;
use \Controller\admin\DestroyController;

class MairieController extends CustomController
{
  //on affiche les information de la mairie stocker en base de donnee , actif comme en attente
  public function home($slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slug)){

        $donnee = $this->infoBdd('Mairie',$slug,['statusA' => 'Actif','statusB' => 'En attente']);

        if(empty($donnee['nom'])){
          $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee,'creation' => true]);
        }else {
          $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  //affiche la liste des association enregistrer dans la mairie
  public function listeAssoc($slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slug)){

        $donnee = $this->listing('Mairie',$slug);
        $this->show('admin/liste',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  public function homeEditForm($slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slug)){

        $donnee = $this->infoBdd('Mairie',$slug,['statusA' => 'Actif','statusB' => 'En attente']);
        if(empty($donnee['nom'])){
          $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee,'edition' => true,'creation' => true]);
        }else {
          $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee,'edition' => true]);
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
      $mairieModel = new MairieModel;

      if(!empty($_POST))
      {
        $r_POST = $this->nettoyage($_POST);
        $error['adresse'] = ValidationTools::textValid($r_POST['adresse'],'adresse',3,50);
        $error['code_postal'] = ValidationTools::code_postalVerif($r_POST['code_postal']);
        if(isset($r_POST['ville'])){
          $error['ville'] = ValidationTools::textValid($r_POST['ville'],'ville',3,50);
        }
        $error['fix'] = ValidationTools::telVerif($r_POST['fix'],true);
        $error['mail'] = ValidationTools::emailValid($r_POST['mail']);


        if(ValidationTools::IsValid($error)){

          unset($r_POST['submit']);
          if(isset($r_POST['avt'])){
            unset($r_POST['avt']);
          }
          if(isset($r_POST['bg'])){
            unset($r_POST['bg']);
          }
          $r_POST['horaire'] = serialize($r_POST['horaire']);

          if(isset($r_POST['ville'])){//uniquement lors de la creation
            $r_POST['nom'] = 'Mairie de '.$r_POST['ville'];
            $r_POST['slug'] = Slugify::slugify($r_POST['nom']);
            $slug_temp = $slug;
          }

          $r_POST['departement'] = substr($r_POST['code_postal'], -5, 2);

          $id = $mairieModel->FindElementByElement('id','slug',$slug);
          $result = $mairieModel->update($r_POST,$id);

          if(!$result){
            $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','edition' => true,'bug' => 'L\'insertion n\'a pas pu aboutir', 'donnee' => $r_POST]);
          }else {
            if(isset($r_POST['ville'])){//uniquement lors de la creation
              $slug = $r_POST['slug'];
            }
            $ArrayAvatar = $_FILES['avatar'];
            $ArrayBackground = $_FILES['background'];
            unset($_FILES['avatar']);
            unset($_FILES['background']);

            if(!empty($ArrayAvatar['name'])){
              $_FILES['image'] = $ArrayAvatar;
              $PicturesController = new PicturesController;
              $PicturesController->picturesPost('mairie',$slug,'avatar');
              unset($_FILES['avatar']);
            }
            if(!empty($ArrayBackground['name'])){
              $_FILES['image'] = $ArrayBackground;
              $PicturesController = new PicturesController;
              $PicturesController->picturesPost('mairie',$slug,'background');
              unset($_FILES['background']);
            }


            if(isset($r_POST['ville'])){//uniquement lors de la creation
              $roleSession = $this->in_multi_array_return_array_and_key($slug_temp,$_SESSION['user']['roles']);
              $_SESSION['user']['roles'][$roleSession['key']]['nom'] = $r_POST['nom'];
              $_SESSION['user']['roles'][$roleSession['key']]['slug'] = $r_POST['slug'];
              $this->redirectToRoute('admin_mairie', ['slug' => $r_POST['slug']]);
            }else {
              $this->redirectToRoute('admin_mairie', ['slug' => $slug]);
            }
          }
        } else {
          $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','edition' => true,'error' => $error, 'donnee' => $r_POST]);
        }
      } else {
        $error['donnee'] = 'Donnée(s) manquante(s).';
      }
    } else {
      $this->redirectToRoute('racine_form');
    }
  }

  public function homeEditStatus($slug,$slugA)
  {
    if(isset($_SESSION['user']))
    {
      $assocModel = new AssocModel;
      if($this->allowToTwo('Admin','Mairie',$slug)){

         $slug = $this->nettoyage($slug);
         $slugA = $this->nettoyage($slugA);
         $id = $assocModel->FindElementByElement('id','slug',$slugA);
         $status = $assocModel->FindElementByElement('status','slug',$slugA);
         if($status == 'Actif'){
           $result = $assocModel->update(['status' => 'En attente'],$id);
         }else {
           $result = $assocModel->update(['status' => 'Actif'],$id);
         }
         if ($this->isAjax()) {
           return $this->showJson(['result' =>$result]);
         }
        $this->redirectToRoute('admin_mairie_assoc',['slug' => $slug, 'page' => 1]);
      }
    }else {
      $this->redirectToRoute('racine_form');
    }
  }

  public function homeDeleteAssoc($slug,$slugA)
  {
    if(isset($_SESSION['user']))
    {
      $assocModel = new AssocModel;
      if($this->allowToTwo('Admin','Mairie',$slug)){
        $slug = $this->nettoyage($slug);
        $slugA = $this->nettoyage($slugA);
        $id_assoc = $assocModel->FindElementByElement('id','slug',$slugA);

        $DestroyController = new DestroyController;
        $resultat = $DestroyController->DeleteAssoc($id_assoc);

        if ($this->isAjax()) {
          return $this->showJson(['resultat' =>$resultat]);
        }

        if(is_array($resultat)){
          $this->showErrors($resultat);
        }else {
          $this->redirectToRoute('admin_mairie_assoc',['slug' => $slug, 'page' => 1]);
        }
      }
    }else {
      $this->redirectToRoute('racine_form');
    }
  }
}
