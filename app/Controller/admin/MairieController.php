<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\MairieModel;
use \Service\ValidationTools;

class MairieController extends CustomController
{
  //on affiche les information de la mairie stocker en base de donnee , actif comme en attente
  public function home($slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slug)){

        $donnee = $this->infoBdd('Mairie',$slug,['statusA' => 'Actif','statusB' => 'En attente']);
        $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee]);
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
        $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee,'edition' => true]);
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
        $error['nom'] = ValidationTools::textValid($r_POST['nom'],'nom',3,100);
        $error['adresse'] = ValidationTools::textValid($r_POST['adresse'],'adresse',3,50);
        $error['code_postal'] = ValidationTools::code_postalVerif($r_POST['code_postal']);
        $error['ville'] = ValidationTools::textValid($r_POST['ville'],'ville',3,50);
        $error['fix'] = ValidationTools::telVerif($r_POST['fix'],true);
        $error['mail'] = ValidationTools::emailValid($r_POST['mail']);

        if(ValidationTools::IsValid($error)){
          if(empty($r_POST['fix'])){
            unset($r_POST['fix']);
          }
          unset($r_POST['submit']);

          $id = $mairieModel->findIDBySlug($slug);
          $result = $mairieModel->update($r_POST,$id);
          if(!$result){
            $this->show('admin/mairie',['slug' => $slug,'orga' => 'mairie','edition' => true,'bug' => 'L\'insertion n\'a pas pu aboutir', 'donnee' => $r_POST]);
          }else {
            $this->redirectToRoute('admin_mairie', ['slug' => $slug]);
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
}
