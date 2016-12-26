<?php
namespace Controller\racine;

use \Controller\CustomController;
use \Model\MairieModel;
use \Model\NewsModel;


class MairieController extends CustomController
{
  //affiche le formulaire de recherche d'une mairie , puis les resulat si il y en a , ainsi que les eventuel erreur
  public function home($orga,$slug)
  {
    if($slug == 'All'){
      $this->show('racine/mairie',['orga' => $orga,'slug' => $slug]);
    }else{

      $donnees = $this->infoBdd($orga,$slug,['statusA' => 'Actif']);
      $mairieModel = new MairieModel;
      $id_orga = $mairieModel->FindElementByElement('id','slug',$slug);

      $NewsModel = new NewsModel;
      $news = $NewsModel->FindAllNews($id_orga,$orga,$limit = 1, $offset = 0,true);
      $this->show('racine/mairie',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees,'news'=>$news ]);
    }
  }
  //recherche en base donnee si une mairie correspon a la recherche
  public function search($orga,$slug)
  {
    $donnees = $this->searchOrga($orga,$slug,$_POST);
    $this->show('racine/mairie',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees ]);
  }
}
