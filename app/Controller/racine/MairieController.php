<?php
namespace Controller\racine;

use \Controller\CustomController;
use \Model\MairieModel;
use \Model\NewsModel;
use \Service\ValidationTools;
use \Model\AbonnesModel;


class MairieController extends CustomController
{
  //affiche le formulaire de recherche d'une mairie , puis les resulat si il y en a , ainsi que les eventuel erreur
  public function home($orga,$slug)
  {
    if($slug == 'All'){
      if(isset($_POST['submit'])){
        $donnees = $this->searchOrga($orga,$slug,$_POST);
        $this->show('racine/mairie',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees ]);
      }else {
        $this->show('racine/mairie',['orga' => $orga,'slug' => $slug]);
      }
    }else{
      $donnees = $this->infoBdd($orga,$slug,['statusA' => 'Actif']);
      $mairieModel = new MairieModel;
      $id_orga = $mairieModel->FindElementByElement('id','slug',$slug);

      $NewsModel = new NewsModel;
      $news = $NewsModel->FindAllNews($id_orga,$orga,6,0,true);

      if(isset($_POST['submit_news'])){
        $r_POST = $this->nettoyage($_POST);
        if(empty($r_POST['capcha'])){
          $error['mail'] = ValidationTools::emailValid($r_POST['mail']);
          if(!ValidationTools::IsValid($error)){
            $this->show('racine/mairie',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees,'news'=>$news,
            'error'=> $error]);
            exit();
          }else{
            $AbonnesModel = new AbonnesModel;
            $id_eventuel = $AbonnesModel->findAbonne($r_POST['mail'],$id_orga,'mairie');
            if(!empty($id_eventuel)){
              $confirmation = 'Vous êtes déjà inscrit à cette newsletter';
            }else {
              $AbonnesModel->insert(['id_mairie'=> $id_orga,'mail'=> $r_POST['mail']]);
              $confirmation = 'Votre inscription a bien été prise en compte';
            }
          }
        }else {
          $this->showErrors('Hello ROBOT');
        }
        $this->show('racine/mairie',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees,'news'=>$news,
        'confirmation'=> $confirmation]);
      } else {
        $this->show('racine/mairie',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees,'news'=>$news ]);
      }
    }
  }
}
