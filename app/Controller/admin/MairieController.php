<?php
namespace Controller\admin;

use \Controller\CustomController;

class MairieController extends CustomController
{
  //on affiche les information de la mairie stocker en base de donnee , actif comme en attente
  public function home($slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowTo('Admin','Mairie',$slug)){

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
      if($this->allowTo('Admin','Mairie',$slug)){

        $donnee = $this->listing('Mairie',$slug);
        $this->show('admin/liste',['slug' => $slug,'orga' => 'mairie','donnee' => $donnee]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
}
