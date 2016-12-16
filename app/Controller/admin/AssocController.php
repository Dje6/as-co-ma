<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\UsersCustomModel;
use \Model\AssocModel;
use \Service\ValidationTools;

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
  public function listeMenbres($slug)
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
      $assocModel = new AssocModel;

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

          $id = $assocModel->findIDBySlug($slug);
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
        $error['donnee'] = 'données manquante';
      }
    } else {
      $this->redirectToRoute('racine_form');
    }
  }

}
