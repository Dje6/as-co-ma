<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\ContactModel;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\UserModel;
use \Service\Pagination;
use \Service\ValidationTools;

class MessageController extends CustomController
{
  //on affiche les message PERSONNEL de l'utilisateur connecter
  public function home($page)
  {
    if(isset($_SESSION['user']))
    {
      $limit = 5;
      //limit d'affichage par page
      $Pagination = new Pagination('contact');
      //on precise la table a exploiter
      $calcule = $Pagination->calcule_page('destinataire_mailOrId = \''.$_SESSION['user']['id'].'\'
      AND destinataire_orga = \'users\' ',$limit,$page);
      //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
      //ce qui calcule le nombre de page total et le offset
      $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],'admin_message');
      //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe

      $donnees = $this->messagesOrga($_SESSION['user']['id'],'users',$limit,$calcule['offset']);
      $this->show('admin/message',['donnees' => $donnees, 'pagination' => $affichage_pagination,'limit' => $limit]);
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  //On affiche les message de la mairie
  public function orga($slug,$orga,$page)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        if($orga == 'assoc'){
          $AssocModel = new AssocModel;
          $maildestinataire = $AssocModel->findIDBySlug($slug);
        }elseif($orga == 'mairie'){
          $MairieModel = new MairieModel;
          $maildestinataire = $MairieModel->findIDBySlug($slug);
        }
        $limit = 6;
        //limit d'affichage par page
        $Pagination = new Pagination('contact');
        //on precise la table a exploiter
        $calcule = $Pagination->calcule_page('destinataire_mailOrId = \''.$maildestinataire.'\' AND
         destinataire_orga = \''.$orga.'\'',$limit,$page);

        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],
        'admin_message_'.$orga,['slug' => $slug,'orga' => $orga]);
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe

        $donnees = $this->messagesOrga($maildestinataire,$orga,$limit,$calcule['offset']);
        $this->show('admin/message',['slug' => $slug,'donnees' => $donnees, 'pagination' => $affichage_pagination,
        'limit' => $limit,'orga' => $orga]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

//recupere les message de l'organisme preciser , mairie , assoc, site
  public function messagesOrga($id,$orga,$limit,$offset)
  {
      $MessageModel = new ContactModel;
      return $MessageModel->searchMessagesOrga($id,$orga,true,$limit,$offset);
  }

//permet a une association de contacter SA mairie referente , uniquement
  public function contactMairie($slugEmeteur,$slugRecepteur)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slugEmeteur)){
        if($_POST){
          $r_POST = $this->nettoyage($_POST);
          $AssocModel = new AssocModel;
          $mailEmeteur = $AssocModel->findIDBySlug($slugEmeteur);
          $MairieModel = new MairieModel;
          $maildestinataire = $MairieModel->recupMailBySlug($slugRecepteur);
          if($maildestinataire && $mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $mailEmeteur;
            $this->sendMessage('mairie','assoc',$slugEmeteur,$slugRecepteur,$r_POST);
          }else {
            echo 'Aucune correspondance avec le slug.';
          }
        }else{
          $MairieModel = new MairieModel;
          $maildestinataire = $MairieModel->recupMailBySlug($slugRecepteur);
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
          $mailEmeteur = $AssocModel->findIDBySlug($slugEmeteur);
          $UserModel = new UserModel;
          $maildestinataire = $UserModel->FindElementByElement('mail','id',$id);
          if($maildestinataire && $mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $mailEmeteur;
            $this->sendMessage('users','assoc',$slugEmeteur,$id,$r_POST);
          }else {
            echo 'Aucune correspondance avec le slug.';
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
  //permet a une mairie de contacter une de SES association , uniquement
  public function contactAssoc($slugEmeteur,$slugRecepteur)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slugEmeteur)){
        if($_POST) {
          $r_POST = $this->nettoyage($_POST);
          $AssocModel = new AssocModel;
          $maildestinataire = $AssocModel->recupMailBySlug($slugRecepteur);
          $MairieModel = new MairieModel;
          $mailEmeteur = $MairieModel->findIDBySlug($slugEmeteur);
          if($maildestinataire && $mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $mailEmeteur;
            $this->sendMessage('assoc','mairie',$slugEmeteur,$slugRecepteur,$r_POST);
          }
          else {
            echo 'Aucune correspondance avec le slug.';
          }
        }else{
          $AssocModel = new AssocModel;
          $maildestinataire = $AssocModel->recupMailBySlug($slugRecepteur);
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
          $mailEmeteur = $MairieModel->findIDBySlug($slugEmeteur);
          if($mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['emeteur_mailOrId'] = $mailEmeteur;
            $this->sendMessage('site','mairie',$slugEmeteur,'Webmaster',$r_POST);
          }
          else {
            echo 'Aucune correspondance avec le slug.';
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
          $r_POST['destinataire_mailOrId'] = $AssocModel->findIDBySlug($slugRecepteur);
        }elseif($orgaRecepteur == 'mairie'){
          $MairieModel = new MairieModel;
          $r_POST['destinataire_mailOrId'] = $MairieModel->findIDBySlug($slugRecepteur);
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
          'slugRecepteur' => $slugRecepteur,'confirmation'=> 'Votre message a bien été envoyé.']);
        }else{
          $this->show('admin/Editmessage',['orga' => $orgaEmeteur ,'slug' => $slugEmeteur,
          'slugRecepteur' => $slugRecepteur,'confirmation'=> 'Une erreur est survenue.']);
        }
      }
    }
  }
}
