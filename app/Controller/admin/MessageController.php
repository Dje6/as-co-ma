<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\MessageModel;
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
      $Pagination = new Pagination('message');
      //on precise la table a exploiter
      $calcule = $Pagination->calcule_page('destinataire = '.$_SESSION['user']['id'],$limit,$page);
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
        $limit = 1;
        //limit d'affichage par page
        $Pagination = new Pagination('contact');
        //on precise la table a exploiter
        $calcule = $Pagination->calcule_page('destinataire = \''.$slug.'\' AND organisme = \''.$orga.'\'',$limit,$page);

        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],
        'admin_message_'.$orga,['slug' => $slug,'orga' => $orga]);
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe

        $donnees = $this->messagesOrga($slug,$limit,$calcule['offset'],$orga);
        $this->show('admin/message',['slug' => $slug,'donnees' => $donnees, 'pagination' => $affichage_pagination,
        'limit' => $limit,'orga' => $orga]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

//recupere les message en base de donnee utilisateur
  public function messagesUser($slug,$limit,$offset)
  {
      $MessageModel = new MessageModel('message');
      return $MessageModel->searchMessages(['destinataire' => $slug],'OR',true,'m.',$limit,$offset);
  }
//recupere les message de l'organisme preciser , mairie , assoc, site
  public function messagesOrga($slug,$limit,$offset,$table)
  {
      $MessageModel = new MessageModel('contact');
      return $MessageModel->searchMessagesOrga(['destinataire' => $slug,'organisme' => $table],'AND',true,$limit,$offset);
  }


  public function contactMairie($slugEmeteur,$sulgRecepteur)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slugEmeteur)){
        if($_POST){
          $r_POST = $this->nettoyage($_POST);
          $error['mail'] = ValidationTools::emailValidAssoc($r_POST['mail'],true);
          if(empty($error['mail'])){
            $this->sendMessage('mairie',$slugEmeteur,$sulgRecepteur,$r_POST);
          }
        }else{
          $MessageModel = new MessageModel('mairie');
          $mail = $MessageModel->recupMailBySlug($slugRecepteur);
          $this->show('admin/Editmessage',['slugEmeteur' => $slugEmeteur,'slugRecepteur' => $slugRecepteur,'mailRecepteur'=> $mail]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function contactAssoc($slugEmeteur,$slugRecepteur)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slugEmeteur)){
        if($_POST) {
          $r_POST = $this->nettoyage($_POST);
          $error['destinataire'] = ValidationTools::emailValidAssoc($r_POST['destinataire'],true);
          $error['mail'] = ValidationTools::emailValidMairie($r_POST['mail'],true);
          if(empty($error['mail']) && empty($error['destinataire'])){
            $this->sendMessage('assoc',$slugEmeteur,$slugRecepteur,$r_POST);
          }else{
            debug($error);
          }
        }else{
          $AssocModel = new AssocModel;
          $maildestinataire = $AssocModel->recupMailBySlug($slugRecepteur);
          $MairieModel = new MairieModel;
          $mailEmeteur = $MairieModel->recupMailBySlug($slugEmeteur);
          $this->show('admin/Editmessage',['slugEmeteur' => $slugEmeteur,'slugRecepteur' => $slugRecepteur,
          'mailRecepteur' => $maildestinataire,'mailEmeteur' => $mailEmeteur]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  public function sendMessage($orga,$slugEmeteur,$slugRecepteur,$donnee)
  {
    if(isset($_SESSION['user']))
    {
      if(!empty($donnee)){
        if(empty($donnee['capcha'])){

          $error['emeteur_pseudo'] = ValidationTools::textValid($donnee['emeteur_pseudo'], 'pseudo',3,50);
          $error['objet'] = ValidationTools::textValid($donnee['objet'], 'objet',3,30);
          $error['contenu'] = ValidationTools::textValid($donnee['contenu'], 'message',3,500);

        }else {
          $error['capcha'] = 'vous etes un bots';
        }
      }else{
        $error['donnee'] = 'donnee manquante';
      }
      if(!ValidationTools::IsValid($error)){
        $this->show('admin/Editmessage',['slugEmeteur' => $slugEmeteur,'slugRecepteur' => $slugRecepteur,
        'donnee' => $donnee,'error' => $error,'mailEmeteur' => $donnee['mail']]);

      }else{
        unset($donnee['submit']);
        unset($donnee['capcha']);

        $donnee['date_envoi'] = date('Y-m-d H:i:s');
        $donnee['status'] = 'non-lu';
        $donnee['organisme'] = $orga;

         $contactModel = new ContactModel;

        if($contactModel->insert($donnee,false)){
          $this->show('admin/Editmessage',['orga' => $orga ,'slug' => $slugRecepteur,'confirmation'=> 'Votre message a bien ete envoyer']);
        }else{
          $this->show('admin/Editmessage',['orga' => $orga ,'slug' => $slugRecepteur,'confirmation'=> 'une erreur est survenu']);
        }
      }
    }
  }
}
