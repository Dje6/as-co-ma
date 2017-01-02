<?php
namespace Controller\racine;

use \Controller\CustomController;
use \model\AssocModel;
use \model\NewsModel;
use \Service\ValidationTools;
use \Model\AbonnesModel;

class AssocController extends CustomController
{
  //affiche au public les information de l'association , uniquement si elle est actif
  public function home($orga,$slug)
  {
    if($slug == 'All'){
      if(isset($_POST['submit'])){
        $donnees = $this->searchOrga($orga,$slug,$_POST);
        $this->show('racine/assoc',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees ]);
      }else {
        $this->show('racine/assoc',['orga' => $orga,'slug' => $slug]);
      }
    }else{
      $donnees = $this->infoBdd($orga,$slug,['statusA' => 'Actif']);
      $assocModel = new AssocModel;
      $id_orga = $assocModel->FindElementByElement('id','slug',$slug);

      $NewsModel = new NewsModel;
      $news = $NewsModel->FindAllNews($id_orga,$orga,6,0,true);

      if(isset($_POST['submit_news'])){
        $r_POST = $this->nettoyage($_POST);
        if(empty($r_POST['capcha'])){
          $error['mail'] = ValidationTools::emailValid($r_POST['mail']);
          if(!ValidationTools::IsValid($error)){
            $this->show('racine/assoc',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees,'news'=>$news,
            'error'=> $error]);
            exit();
          }else{
            $AbonnesModel = new AbonnesModel;
            $id_eventuel = $AbonnesModel->findAbonne($r_POST['mail'],$id_orga,'assoc');
            if(!empty($id_eventuel)){
              $confirmation = 'Vous êtes déjà inscrit à cette newsletter';
            }else {
              $AbonnesModel->insert(['id_assoc'=> $id_orga,'mail'=> $r_POST['mail']]);
              $confirmation = 'Votre inscription a bien été prise en compte';
            }
          }
        }else {
          $this->showErrors('Hello ROBOT');
        }
        $this->show('racine/assoc',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees,'news'=>$news,
        'confirmation'=> $confirmation]);
      } else {
        $this->show('racine/assoc',['orga' => $orga,'slug' => $slug,'donnees' =>$donnees,'news'=>$news ]);
      }
    }
  }
}
