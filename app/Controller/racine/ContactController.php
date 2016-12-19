<?php
namespace Controller\racine;

use \Controller\CustomController;
use \Service\ValidationTools;
use \Model\ContactModel;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\UserModel;

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

        $error['emeteur_mailOrId'] = ValidationTools::emailValid($r_POST['emeteur_mailOrId']);
        $error['objet'] = ValidationTools::textValid($r_POST['objet'], 'objet',3,30);
        $error['contenu'] = ValidationTools::textValid($r_POST['contenu'], 'message',3,400);

      }else {
        $error['capcha'] = 'vous etes un bots';
      }
    }else{
      $error['donnee'] = 'donnee manquante';
    }
    if(!ValidationTools::IsValid($error)){
      $this->show('racine/contact',array('orga' => $orga ,'slug' => $slug,'saisi' => $r_POST,'error' => $error));

    }else{
      unset($r_POST['submit']);
      unset($r_POST['capcha']);

      $UserModel = new UserModel;
      if($UserModel->FinIdByMail($r_POST['emeteur_mailOrId'])){
        $r_POST['emeteur_mailOrId'] = $UserModel->FinIdByMail($r_POST['emeteur_mailOrId']);
        $r_POST['emeteur_orga'] = 'users';
        $r_POST['emeteur_pseudo'] = $UserModel->FinPseudoByMail($r_POST['emeteur_mailOrId']);
      }else{
        $r_POST['emeteur_orga'] = 'public';
        $r_POST['emeteur_pseudo'] = 'non-inscrit';
      }
      $r_POST['destinataire_orga'] = $orga;
      if($orga == 'assoc'){
        $AssocModel = new AssocModel;
        $r_POST['destinataire_mailOrId'] = $AssocModel->findIDBySlug($slug);
      }elseif($orga == 'mairie'){
        $MairieModel = new MairieModel;
        $r_POST['destinataire_mailOrId'] = $MairieModel->findIDBySlug($slug);
      }elseif($orga == 'All'){
        $r_POST['destinataire_mailOrId'] = 'webmaster@as-co-mo.fr';
        $r_POST['destinataire_orga'] = 'webmaster';
      }

      $r_POST['date_envoi'] = date('Y-m-d H:i:s');
      $r_POST['status'] = 'non-lu';
        $contactModel = new ContactModel;

      if($contactModel->insert($r_POST,false)){
        $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'Votre message a bien ete envoyer']);
      }else{
        $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'une erreur est survenu']);
      }
    }
  }
}
