<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Service\ValidationTools;
use \Model\ContactModel;

class ContactController extends CustomController
{
  public function home($orga,$slug)
  {

      $this->show('admin/contact',['orga' => $orga ,'slug' => $slug]);
  }
  public function sendMessage($orga,$slug)
  {
    if($_POST)
    {
      $r_POST = $this->nettoyage($_POST);
      if(empty($r_POST['capcha'])){

        $error['emeteur_pseudo'] = ValidationTools::textValid($r_POST['emeteur_pseudo'], 'pseudo',3,50);
        $error['mail'] = ValidationTools::emailValid($r_POST['mail']);
        $error['objet'] = ValidationTools::textValid($r_POST['objet'], 'objet',3,30);
        $error['contenu'] = ValidationTools::textValid($r_POST['contenu'], 'message',3,400);

      }else {
        $error['capcha'] = 'Hello ROBOT';
      }
    }else{
      $error['donnee'] = 'Donnée(s) manquante(s).';
    }
    if(!ValidationTools::IsValid($error)){
      $this->show('admin/contact',array('orga' => $orga ,'slug' => $slug,'saisi' => $r_POST,'error' => $error));

    }else{
      unset($r_POST['submit']);
      unset($r_POST['capcha']);
      $r_POST['destinataire'] = $slug;
      $r_POST['date_envoi'] = date('Y-m-d H:i:s');
      $r_POST['status'] = 'non-lu';

      if($orga == 'All'){
        $contactModel = new ContactModel('su');
      }else{
        $contactModel = new ContactModel($orga);
      }
      if($contactModel->insert($r_POST,false)){
        $this->show('admin/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'Votre message a bien été envoyé.']);
      }else{
        $this->show('admin/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'Une erreur est survenue.']);
      }
    }
  }
}
