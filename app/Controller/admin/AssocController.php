<?php
namespace Controller\admin;

use \Controller\CustomController;

class AssocController extends CustomController
{
  //affiche les information de l'association qui sont enregistrer en base de donnee
  //uniquement pour les Admin de l'association , quel soit active ou en attente d'activation
  public function home($slug)
  {
    if(isset($_SESSION['user'])){
      if($this->allowTo('Admin','Assoc',$slug)){

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
      if($this->allowTo('Admin','Assoc',$slug)){

        $donnee = $this->listing('Assoc',$slug);
        $this->show('admin/liste',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

}
