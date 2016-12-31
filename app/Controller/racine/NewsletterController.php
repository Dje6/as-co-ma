<?php
namespace Controller\racine;

use \Controller\CustomController;
use \model\AssocModel;
use \model\MairieModel;
use \model\AbonnesModel;

class NewsletterController extends CustomController
{
  //affiche au public les information de l'association , uniquement si elle est actif
  public function home($orga,$slug)
  {
    if($_POST){
      $r_POST = $this->nettoyage($_POST);
      if(empty($r_POST['capcha'])){
        if(!empty($r_POST['mail'])){
          $retour = $this->deleteAbonne($r_POST['mail'],$orga,$slug);
          $this->show('racine/newsletter',['orga' => $orga,'slug' => $slug,'confirmation' => $retour]);
        }else {
          $this->show('racine/newsletter',['orga' => $orga,'slug' => $slug,'error' => ['mail'=> 'merci de saisir un email']]);
        }
      }else {
        $this->showErrors('vous etes un bots');
      }
    }else {
      $this->show('racine/newsletter',['orga' => $orga,'slug' => $slug]);
    }
  }
  public function deleteAbonne($mail,$orga,$slug)
  {
    $AbonnesModel = new AbonnesModel;
    if(ucfirst($orga) == 'Mairie'){
      $MairieModel = new MairieModel;
      $id_orga = $MairieModel->FindElementByElement('id','slug',$slug);
    }elseif (ucfirst($orga) == 'Assoc') {
      $AssocModel = new AssocModel;
      $id_orga = $AssocModel->FindElementByElement('id','slug',$slug);
    }
    $id_abonement = $AbonnesModel->findAbonne($mail,$id_orga,$orga);
    if($AbonnesModel->delete($id_abonement)){
      return 'Votre desinscription a la newsletter a bien ete prise en compte';
    }else {
      return 'Une erreur est survenu , votre desinscription n\' a pas ete prise en compte';
    }
  }
}
