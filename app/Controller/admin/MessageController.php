<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\ContactModel;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\UserModel;
use \Service\Pagination;
use \Service\PaginationMultiAjax;
use \Service\ValidationTools;
use \Controller\admin\GenerateViewsController;

class MessageController extends CustomController
{
  //on affiche les message PERSONNEL de l'utilisateur connecter
  public function home($page=1)
  {
    if(isset($_SESSION['user']))
    {
      if($this->isAjax()){
        if(isset($_GET['page'])){
          $page = $_GET['page'];
        }
      }
      $GenerateViewsController = new GenerateViewsController;

        $limit = 1;
        //limit d'affichage par page
        $Pagination = new PaginationMultiAjax('contact');
        //on precise la table a exploiter
        $calcule = $Pagination->calcule_page('destinataire_mailOrId = \''.$_SESSION['user']['id'].'\'
        AND destinataire_orga = \'users\' AND destinataire_status IS NULL ',$limit,$page);
        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],'admin_message');
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
        $donnees = $this->messagesOrga($_SESSION['user']['id'],'users',$limit,$calcule['offset']);

        $Recu = $GenerateViewsController->messageView($donnees,NULL,NULL,$page);
        if($this->isAjax()){
          $this->showJson(['donnee'=>$Recu, 'pagination' => $affichage_pagination]);
        }

      $this->show('admin/message',['Recu' => $Recu, 'paginationRecu' => $affichage_pagination,'limit' => $limit,'page' => $page]);
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function homeSend($page=1)
  {
    if(isset($_SESSION['user']))
    {
      if($this->isAjax()){
        if(isset($_GET['page'])){
          $page = $_GET['page'];
        }
      }
      $GenerateViewsController = new GenerateViewsController;

        $limit = 1;
        //limit d'affichage par page
        $Pagination = new PaginationMultiAjax('contact');
        //on precise la table a exploiter
        $calcule = $Pagination->calcule_page('emeteur_mailOrId = \''.$_SESSION['user']['id'].'\'
        AND emeteur_orga = \'users\' AND emeteur_status IS NULL',$limit,$page);
        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],'admin_message_send');
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe

        $donnees = $this->sendMessagesOrga($_SESSION['user']['id'],'users',$limit,$calcule['offset']);

        $Envoyer = $GenerateViewsController->messageView($donnees,NULL,NULL,$page);
        if($this->isAjax()){
          $this->showJson(['donnee'=>$Envoyer, 'pagination' => $affichage_pagination]);
        }

      $this->show('admin/message',['Envoyer' => $Envoyer, 'paginationEnvoyer' => $affichage_pagination,'limit' => $limit,'page' => $page]);
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
          $maildestinataire = $AssocModel->FindElementByElement('id','slug',$slug);
        }elseif($orga == 'mairie'){
          $MairieModel = new MairieModel;
          $maildestinataire = $MairieModel->FindElementByElement('id','slug',$slug);
        }elseif($orga == 'webmaster'){
          $maildestinataire = 'webmaster@as-co-ma.fr';
        }
        if($this->isAjax()){
          if(isset($_GET['page'])){
            $page = $_GET['page'];
          }
        }
        $GenerateViewsController = new GenerateViewsController;

          $limit = 1;
          //limit d'affichage par page
          $Pagination = new PaginationMultiAjax('contact');
          //on precise la table a exploiter
          $calcule = $Pagination->calcule_page('destinataire_mailOrId = \''.$maildestinataire.'\' AND
           destinataire_orga = \''.$orga.'\' AND destinataire_status IS NULL',$limit,$page);
          //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
          //ce qui calcule le nombre de page total et le offset
          $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],
          'admin_message_'.$orga,['slug' => $slug,'orga' => $orga]);
          //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe

          $donnees = $this->messagesOrga($maildestinataire,$orga,$limit,$calcule['offset']);

          $Recu = $GenerateViewsController->messageView($donnees,$orga,$slug,$page);
          if($this->isAjax()){
            $this->showJson(['donnee'=>$Recu, 'pagination' => $affichage_pagination]);
          }

        $this->show('admin/message',['slug' => $slug,'Recu' => $Recu, 'paginationRecu' => $affichage_pagination,
        'limit' => $limit,'orga' => $orga,'page' => $page]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function orgaSend($slug,$orga,$page)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        if($orga == 'assoc'){
          $AssocModel = new AssocModel;
          $mailemeteur = $AssocModel->FindElementByElement('id','slug',$slug);
        }elseif($orga == 'mairie'){
          $MairieModel = new MairieModel;
          $mailemeteur = $MairieModel->FindElementByElement('id','slug',$slug);
        }elseif($orga == 'webmaster'){
          $mailemeteur = 'webmaster@as-co-ma.fr';
        }
        if($this->isAjax()){
          if(isset($_GET['page'])){
            $page = $_GET['page'];
          }
        }
        $GenerateViewsController = new GenerateViewsController;

          $limit = 1;
          //limit d'affichage par page
          $Pagination = new PaginationMultiAjax('contact');
          //on precise la table a exploiter
          $calcule = $Pagination->calcule_page('emeteur_mailOrId = \''.$mailemeteur.'\' AND
           emeteur_orga = \''.$orga.'\' AND emeteur_status IS NULL',$limit,$page);
          //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
          //ce qui calcule le nombre de page total et le offset
          $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],
          'admin_message_send_'.$orga,['slug' => $slug,'orga' => $orga]);
          //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe

          $donnees = $this->sendMessagesOrga($mailemeteur,$orga,$limit,$calcule['offset']);

          $Envoyer = $GenerateViewsController->messageView($donnees,$orga,$slug,$page);
          if($this->isAjax()){
            $this->showJson(['donnee'=>$Envoyer, 'pagination' => $affichage_pagination]);
          }

        $this->show('admin/message',['slug' => $slug,'Envoyer' => $Envoyer, 'paginationEnvoyer' => $affichage_pagination,
        'limit' => $limit,'orga' => $orga,'page' => $page]);
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
  public function sendMessagesOrga($id,$orga,$limit,$offset)
  {
      $MessageModel = new ContactModel;
      return $MessageModel->searchSendMessagesOrga($id,$orga,true,$limit,$offset);
  }

}
