<?php
namespace Controller\racine;

use \Controller\CustomController;
use \Service\ValidationTools;
use \Model\ContactModel;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\UserModel;
use \Model\RolesModel;

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
        $error['capcha'] = 'Hello ROBOT';
      }
    }else{
      $error['donnee'] = 'Donnée(s) manquante(s).';
    }
    if(!ValidationTools::IsValid($error)){
      $this->show('racine/contact',array('orga' => $orga ,'slug' => $slug,'saisi' => $r_POST,'error' => $error));

    }else{
      unset($r_POST['submit']);
      unset($r_POST['capcha']);

      $contactModel = new ContactModel;

      $UserModel = new UserModel;
      $id_utilisateur_eventuel = $UserModel->FindElementByElement('id','mail',$r_POST['emeteur_mailOrId']);
      if($id_utilisateur_eventuel){
        if($orga == 'assoc'){
          $AssociationModel = new AssocModel;
          $id_ssociation = $AssociationModel->FindElementByElement('id','slug',$slug);

          $RolesModel = new RolesModel;
          $roleRetourner = $RolesModel->FindRole($id_ssociation,$id_utilisateur_eventuel);
          if(!empty($roleRetourner)){
            $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'Vous faites déjà partie de cette Association']);
          }
        }
        $email = $r_POST['emeteur_mailOrId'];
        $r_POST['emeteur_mailOrId'] = $id_utilisateur_eventuel;
        $r_POST['emeteur_orga'] = 'users';
        $r_POST['emeteur_pseudo'] = $UserModel->FindElementByElement('pseudo','mail',$email);
      }else{
        $r_POST['emeteur_orga'] = 'public';
        $r_POST['emeteur_pseudo'] = 'non-inscrit';
        $r_POST['emeteur_status'] = 'del';
      }

      $r_POST['destinataire_orga'] = $orga;
      if($orga == 'assoc'){
        $AssocModel = new AssocModel;
        $r_POST['destinataire_mailOrId'] = $AssocModel->FindElementByElement('id','slug',$slug);

        if($contactModel->findInvitation($r_POST['emeteur_mailOrId'],$r_POST['destinataire_mailOrId'])){
          if(is_numeric($r_POST['emeteur_mailOrId'])){
            $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,
            'confirmation'=> 'Une invitation à rejoindre cette Association est déjà en attente dans votre messagerie.']);
          }else {
            $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,
            'confirmation'=> 'Une invitation à rejoindre cette Association vous a déjà été envoyée par mail. Si vous l\'avez perdu, inscrivez-vous en cliquant sur "Nous rejoindre", et rendez-vous dans l\'onglet "Messages", vos invitations vous y attendent !']);
          }

        }
        if($contactModel->findDemande($r_POST['emeteur_mailOrId'],$r_POST['destinataire_mailOrId'])){
          $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,
          'confirmation'=> 'Vous avez déjà effectué une demande pour devenir membre. Merci de patienter ou de nous contacter avec l\'objet "Obtenir des informations".']);
        }

      }elseif($orga == 'mairie'){
        $MairieModel = new MairieModel;
        $r_POST['destinataire_mailOrId'] = $MairieModel->FindElementByElement('id','slug',$slug);
      }elseif($orga == 'All'){
        $r_POST['destinataire_mailOrId'] = 'webmaster@as-co-ma.fr';
        $r_POST['destinataire_orga'] = 'webmaster';
      }

      $r_POST['date_envoi'] = date('Y-m-d H:i:s');
      $r_POST['status'] = 'non-lu';



      if($contactModel->insert($r_POST,false)){
        $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'Votre message a bien été envoyé.']);
      }else{
        $this->show('racine/contact',['orga' => $orga ,'slug' => $slug,'confirmation'=> 'Une erreur est survenue.']);
      }
    }
  }
}
