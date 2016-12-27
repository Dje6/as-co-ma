<?php
namespace Controller\racine;

use \Controller\CustomController;
use \model\AssocModel;
use \model\NewsModel;

class AssocController extends CustomController
{
  //affiche au public les information de l'association , uniquement si elle est actif
  public function home($orga,$slug)
  {
    if($slug == 'All'){
      $this->show('racine/assoc',['orga' => $orga,'slug' => $slug]);
    }else{
      $donnees = $this->info($slug,['statusA'=> 'Actif']);
      $assocModel = new AssocModel;
      $id_orga = $assocModel->FindElementByElement('id','slug',$slug);

      $NewsModel = new NewsModel;
      $news = $NewsModel->FindAllNews($id_orga,$orga,6,0,true);
      $this->show('racine/assoc',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees,'news'=>$news ]);
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
