<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\MessageModel;
use \Service\Pagination;

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
  public function mairie($slug,$page)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Mairie',$slug)){
        $limit = 5;
        //limit d'affichage par page
        $Pagination = new Pagination('contact');
        //on precise la table a exploiter
        $calcule = $Pagination->calcule_page('destinataire = \''.$slug.'\' AND organisme = "mairie"',$limit,$page);

        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],'admin_message_mairie',['slug' => $slug]);
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe

        $donnees = $this->messagesOrga($slug,$limit,$calcule['offset'],'mairie');
        $this->show('admin/message',['slug' => $slug,'donnees' => $donnees, 'pagination' => $affichage_pagination,
        'limit' => $limit,'orga' => 'mairie']);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  //on affiche les message de l'association
  public function assoc($slug,$page)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin','Assoc',$slug)){
        $limit = 5;
        //limit d'affichage par page
        $Pagination = new Pagination('contact');
        //on precise la table a exploiter
        $calcule = $Pagination->calcule_page('destinataire = \''.$slug.'\' AND organisme = "assoc"',$limit,$page);
        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],'admin_message_assoc',['slug' => $slug]);
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
        $donnees = $this->messagesOrga($slug,$limit,$calcule['offset'],'assoc');
        $this->show('admin/message',['slug' => $slug,'donnees' => $donnees, 'pagination' => $affichage_pagination,
        'limit' => $limit,'orga' => 'assoc']);
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
}
