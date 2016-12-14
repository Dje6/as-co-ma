<?php
namespace Controller\racine;

use \Controller\CustomController;
use \model\AssocModel;

class AssocController extends CustomController
{
  //affiche au public les information de l'association , uniquement si elle est actif
  public function home($orga,$slug)
  {
    if($slug == 'All'){
      $this->show('racine/assoc',['orga' => $orga,'slug' => $slug]);
    }else{
      $donnees = $this->info($slug,['statusA'=> 'Actif']);
      $this->show('racine/assoc',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees ]);
    }
  }
  //recherche en base de donnee les organisation correspondan au critere saisi par lutilisateur
  public function search($orga,$slug)
  {
    $donnees = $this->searchOrga($orga,$slug,$_POST);
    $this->show('racine/assoc',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees ]);
  }
  //recupere les info d'une association en base de donnee
  public function info($slug,$status)
  {
    $assocModel = new AssocModel;
    $donnees = $assocModel->findSlug($slug,$status);
    return $donnees;
  }
}
