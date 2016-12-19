<?php
namespace Controller\racine;

use \Controller\CustomController;
use \Service\ValidationTools;
use \Model\ContactModel;
use \Model\AssocModel;
use \Model\MairieModel;

class ContactController extends CustomController
{
  //on affiche le formulaire de contact public specifique en fonction du slug
  public function home($orga,$slug)
  {
      $this->show('racine/contact',['orga' => $orga ,'slug' => $slug]);
  }
  //on traite l'envoi du message
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
      $error['donnee'] = 'Donnée manquante.';
    }
    if(!ValidationTools::IsValid($error)){
      $this->show('racine/contact',array('orga' => $orga ,'slug' => $slug,'saisi' => $r_POST,'error' => $error));

    }else{
      unset($r_POST['submit']);
      unset($r_POST['capcha']);
      if($orga == 'assoc'){
        $AssocModel = new AssocModel;
        $maildestinataire = $AssocModel->recupMailBySlug($slug);
      }elseif($orga == 'mairie'){
        $MairieModel = new MairieModel;
        $maildestinataire = $MairieModel->recupMailBySlug($slug);
      }
      $r_POST['destinataire'] = $maildestinataire;
      $r_POST['date_envoi'] = date('Y-m-d H:i:s');
      $r_POST['status'] = 'non-lu';
      $r_POST['organisme'] = $orga;

        $contactModel = new ContactModel;

      if($contactModel->insert($r_POST,false)){
        $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'Votre message a bien été envoyé']);
      }else{
        $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'Une erreur est survenue.']);
      }
    }
  }
}
