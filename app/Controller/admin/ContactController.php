<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\ContactModel;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\UserModel;
use \Model\RolesModel;
use \Service\Pagination;
use \Service\ValidationTools;

class ContactController extends CustomController
{
//permet a une association de contacter SA mairie referente , uniquement
  public function contactMairie($slugEmeteur,$slugRecepteur)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slugEmeteur)){
        if($_POST){
          $r_POST = $this->nettoyage($_POST);
          $AssocModel = new AssocModel;
          $mailEmeteur = $AssocModel->FindElementByElement('id','slug',$slugEmeteur);
          $MairieModel = new MairieModel;
          $maildestinataire = $MairieModel->FindElementByElement('mail','slug',$slugRecepteur);
          if($maildestinataire && $mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $mailEmeteur;
            $this->sendMessage('mairie','assoc',$slugEmeteur,$slugRecepteur,$r_POST);
          }else {
            $this->showErrors('Aucune correspondance avec le slug.');
          }
        }else{
          $MairieModel = new MairieModel;
          $maildestinataire = $MairieModel->FindElementByElement('mail','slug',$slugRecepteur);
          $this->show('admin/Editmessage',['orga' => 'assoc','slug' => $slugEmeteur,'slugEmeteur' => $slugEmeteur,
          'slugRecepteur' => $slugRecepteur,'mailRecepteur' => $maildestinataire]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function contactMembre($slugEmeteur,$id)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slugEmeteur)){
        if($_POST){
          $r_POST = $this->nettoyage($_POST);
          $AssocModel = new AssocModel;
          $mailEmeteur = $AssocModel->FindElementByElement('id','slug',$slugEmeteur);
          $UserModel = new UserModel;
          $maildestinataire = $UserModel->FindElementByElement('mail','id',$id);
          if($maildestinataire && $mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $mailEmeteur;
            $this->sendMessage('users','assoc',$slugEmeteur,$id,$r_POST);
          }else {
            $this->showErrors('Aucune correspondance avec le slug.');
          }
        }else{
          $UserModel = new UserModel;
          $maildestinataire = $UserModel->FindElementByElement('mail','id',$id);
          $this->show('admin/Editmessage',['orga' => 'assoc','slug' => $slugEmeteur,'slugEmeteur' => $slugEmeteur,
          'mailRecepteur' => $maildestinataire,'id' => $id]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function contactToutMembres($slugEmeteur)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slugEmeteur)){
        if($_POST){
          $r_POST = $this->nettoyage($_POST);
          $AssocModel = new AssocModel;
          $id_assoc = $AssocModel->FindElementByElement('id','slug',$slugEmeteur);
          $RolesModel = new RolesModel;
          $AllMembres = $RolesModel->AllMembre($id_assoc);

          if(empty($r_POST['capcha'])){
            $error['objet'] = ValidationTools::textValid($r_POST['objet'], 'objet',3,30);
            $error['contenu'] = ValidationTools::textValid($r_POST['contenu'], 'message',3,500);
          }else {
            $error['capcha'] = 'Hello ROBOT';
          }

          if(!ValidationTools::IsValid($error)){
            $this->show('admin/Editmessage',['slugEmeteur' => $slugEmeteur,
            'donnee' => $r_POST,'error' => $error,'mailRecepteur' => 'Tous les membres',
             'slug' => $slugEmeteur]);

          }else{
            unset($r_POST['submit']);
            unset($r_POST['capcha']);

            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $id_assoc;
            $r_POST['destinataire_orga'] = 'users';
            $r_POST['emeteur_orga'] = 'assoc';
            $r_POST['date_envoi'] = date('Y-m-d H:i:s');
            $r_POST['status'] = 'non-lu';
            $r_POST['emeteur_status'] = 'del';

            $contactModel = new ContactModel;
            foreach ($AllMembres as $key => $value) {
              $r_POST['destinataire_mailOrId'] = $value['id_user'];
              $contactModel->insert($r_POST,false);
            }
//une fois envoyer a tout les membre , on s'en envoi une copie en boite de reception pour lassoc
            $r_POST['destinataire_orga'] = 'assoc';
            $r_POST['destinataire_mailOrId'] = $id_assoc;

            if($contactModel->insert($r_POST,false)){
              $this->show('admin/Editmessage',['slug' => $slugEmeteur,
              'mailRecepteur' => 'Tous les membres','confirmation'=> '<h3 class="titrecontact glyphicon-envelope blue"> Votre message a bien été envoyé.</h3>']);
            }else{
              $this->show('admin/Editmessage',['slug' => $slugEmeteur,
              'mailRecepteur' => 'Tous les membres','confirmation'=> '<h3 class="titrecontact glyphicon-envelope red"> Une erreur est survenue.</h3>']);
            }
          }
        }else{
          $this->show('admin/Editmessage',['slug' => $slugEmeteur,'slugEmeteur' => $slugEmeteur,
          'mailRecepteur' => 'Tous les membres']);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  //permet a une mairie de contacter une de SES association , uniquement
  public function contactAssoc($slugEmeteur,$slugRecepteur)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slugEmeteur)){
        if($_POST) {
          $r_POST = $this->nettoyage($_POST);
          $AssocModel = new AssocModel;
          $maildestinataire = $AssocModel->FindElementByElement('mail','slug',$slugRecepteur);
          $MairieModel = new MairieModel;
          $mailEmeteur = $MairieModel->FindElementByElement('id','slug',$slugEmeteur);
          if($maildestinataire && $mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $mailEmeteur;
            $this->sendMessage('assoc','mairie',$slugEmeteur,$slugRecepteur,$r_POST);
          }
          else {
            $this->showErrors('Aucune correspondance avec le slug.');
          }
        }else{
          $AssocModel = new AssocModel;
          $maildestinataire = $AssocModel->FindElementByElement('mail','slug',$slugRecepteur);
          $this->show('admin/Editmessage',['orga' => 'mairie','slug' => $slugEmeteur,'slugEmeteur' => $slugEmeteur,
          'slugRecepteur' => $slugRecepteur,'mailRecepteur' => $maildestinataire]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function contactWebmaster($slugEmeteur)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slugEmeteur)){
        if($_POST) {
          $r_POST = $this->nettoyage($_POST);
          $MairieModel = new MairieModel;
          $mailEmeteur = $MairieModel->FindElementByElement('id','slug',$slugEmeteur);
          if($mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $mailEmeteur;
            $this->sendMessage('site','mairie',$slugEmeteur,'Webmaster',$r_POST);
          }
          else {
            $this->showErrors('Aucune correspondance avec le slug.');
          }
        }else{
          $this->show('admin/Editmessage',['orga' => 'site','slug' => $slugEmeteur,'slugEmeteur' => $slugEmeteur,
          'slugRecepteur' => 'Webmaster','mailRecepteur' => 'Webmaster@as-co-ma.fr']);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
//verifie les information fourni et traite linsertion en base de donnee

  public function sendMessage($orgaRecepteur,$orgaEmeteur,$slugEmeteur,$slugRecepteur,$r_POST)
  {
    if(isset($_SESSION['user']))
    {
      if(!empty($r_POST)){
        if(empty($r_POST['capcha'])){

          $error['objet'] = ValidationTools::textValid($r_POST['objet'], 'objet',3,30);
          $error['contenu'] = ValidationTools::textValid($r_POST['contenu'], 'message',3,500);

        }else {
          $error['capcha'] = 'Hello ROBOT';
        }
      }else{
        $error['donnee'] = 'Donnée(s) manquante(s).';
      }
      if(!ValidationTools::IsValid($error)){
        $this->show('admin/Editmessage',['slugEmeteur' => $slugEmeteur,'slugRecepteur' => $slugRecepteur,
        'donnee' => $r_POST,'error' => $error,'mailRecepteur' => $r_POST['destinataire_mailOrId'],'orga' => $orgaEmeteur ,
         'slug' => $slugEmeteur]);

      }else{
        unset($r_POST['submit']);
        unset($r_POST['capcha']);

        $r_POST['destinataire_orga'] = $orgaRecepteur;

        if($orgaRecepteur == 'assoc'){
          $AssocModel = new AssocModel;
          $r_POST['destinataire_mailOrId'] = $AssocModel->FindElementByElement('id','slug',$slugRecepteur);
        }elseif($orgaRecepteur == 'mairie'){
          $MairieModel = new MairieModel;
          $r_POST['destinataire_mailOrId'] = $MairieModel->FindElementByElement('id','slug',$slugRecepteur);
        }elseif($orgaRecepteur == 'users'){

          $r_POST['destinataire_mailOrId'] = $slugRecepteur;

        }elseif($orgaRecepteur == 'site'){
          $r_POST['destinataire_mailOrId'] = 'webmaster@as-co-ma.fr';
          $r_POST['destinataire_orga'] = 'webmaster';
        }

        $r_POST['emeteur_orga'] = $orgaEmeteur;
        $r_POST['date_envoi'] = date('Y-m-d H:i:s');
        $r_POST['status'] = 'non-lu';

         $contactModel = new ContactModel;

        if($contactModel->insert($r_POST,false)){
          $this->show('admin/Editmessage',['orga' => $orgaEmeteur ,'slug' => $slugEmeteur,
          'slugRecepteur' => $slugRecepteur,'confirmation'=> '<h3 class="titrecontact glyphicon-envelope blue"> Votre message a bien été envoyé.</h3>']);
        }else{
          $this->show('admin/Editmessage',['orga' => $orgaEmeteur ,'slug' => $slugEmeteur,
          'slugRecepteur' => $slugRecepteur,'confirmation'=> '<h3 class="titrecontact glyphicon-envelope red"> Une erreur est survenue.</h3>']);
        }
      }
    }
  }
}
