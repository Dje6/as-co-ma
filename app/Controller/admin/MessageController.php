<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\ContactModel;
use \Model\AssocModel;
use \Model\MairieModel;
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

      $donnees = $this->messagesUser($_SESSION['user']['id'],$limit,$calcule['offset']);
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
          $maildestinataire = $AssocModel->recupMailBySlug($slug);
        }elseif($orga == 'mairie'){
          $MairieModel = new MairieModel;
          $maildestinataire = $MairieModel->recupMailBySlug($slug);
        }
        $limit = 1;
        //limit d'affichage par page
        $Pagination = new Pagination('contact');
        //on precise la table a exploiter
        $calcule = $Pagination->calcule_page('destinataire = \''.$maildestinataire.'\' AND organisme = \''.$orga.'\'',$limit,$page);

        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],
        'admin_message_'.$orga,['slug' => $slug,'orga' => $orga]);
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe

        $donnees = $this->messagesOrga($maildestinataire,$limit,$calcule['offset']);
        $this->show('admin/message',['slug' => $slug,'donnees' => $donnees, 'pagination' => $affichage_pagination,
        'limit' => $limit,'orga' => $orga]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

//recupere les message en base de donnee utilisateur
  public function messagesUser($id,$limit,$offset)
  {
      $MessageModel = new ContactModel;
      return $MessageModel->searchMessagesOrga(['destinataire_mailOrId' => $id,
      'destinataire_orga' => 'users'],'AND',true,$limit,$offset);
  }
//recupere les message de l'organisme preciser , mairie , assoc, site
  public function messagesOrga($mail,$limit,$offset)
  {
      $MessageModel = new ContactModel;
      return $MessageModel->searchMessagesOrga(['destinataire' => $mail],'AND',true,$limit,$offset);
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
          $mailEmeteur = $AssocModel->recupMailBySlug($slugEmeteur);
          $MairieModel = new MairieModel;
          $maildestinataire = $MairieModel->recupMailBySlug($slugRecepteur);
          if($maildestinataire && $mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['mail'] = $mailEmeteur;
            $this->sendMessage('mairie','assoc',$slugEmeteur,$slugRecepteur,$r_POST);
          }else {
            echo 'rien ne corespon au slug';
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
          $mailEmeteur = $MairieModel->recupMailBySlug($slugEmeteur);
          if($maildestinataire && $mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['mail'] = $mailEmeteur;
            $this->sendMessage('assoc','mairie',$slugEmeteur,$slugRecepteur,$r_POST);
          }
          else {
            echo 'rien ne corespon au slug';
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
          $mailEmeteur = $MairieModel->recupMailBySlug($slugEmeteur);
          if($mailEmeteur){
            $r_POST['emeteur_pseudo'] = $slugEmeteur;
            $r_POST['mail'] = $mailEmeteur;
            $this->sendMessage('site','mairie',$slugEmeteur,'Webmaster',$r_POST);
          }
          else {
            echo 'rien ne corespon au slug';
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
          $error['capcha'] = 'vous etes un bots';
        }
      }else{
        $error['donnee'] = 'donnee manquante';
      }
      if(!ValidationTools::IsValid($error)){
        $this->show('admin/Editmessage',['slugEmeteur' => $slugEmeteur,'slugRecepteur' => $slugRecepteur,
        'donnee' => $r_POST,'error' => $error,'mailRecepteur' => $r_POST['destinataire'],'orga' => $orgaEmeteur ,
         'slug' => $slugEmeteur,'mailEmeteur'=> $r_POST['mail']]);

      }else{
        unset($r_POST['submit']);
        unset($r_POST['capcha']);

        $r_POST['date_envoi'] = date('Y-m-d H:i:s');
        $r_POST['status'] = 'non-lu';
        $r_POST['organisme'] = $orgaRecepteur;

         $contactModel = new ContactModel;

        if($contactModel->insert($r_POST,false)){
          $this->show('admin/Editmessage',['orga' => $orgaEmeteur ,'slug' => $slugEmeteur,
          'slugRecepteur' => $slugRecepteur,'confirmation'=> 'Votre message a bien ete envoyer']);
        }else{
          $this->show('admin/Editmessage',['orga' => $orgaEmeteur ,'slug' => $slugEmeteur,
          'slugRecepteur' => $slugRecepteur,'confirmation'=> 'une erreur est survenu']);
        }
      }
    }
  }
}
