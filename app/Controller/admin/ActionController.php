<?php
namespace Controller\admin;
use \Controller\CustomController;
use \Model\ContactModel;
use \Model\AssocModel;
use \Model\MairieModel;


/**
 *
 */
class ActionController extends CustomController
{
  // ajoute del dans le status du destinataire ou de lemeteur , ainsi on peu supprimer le message de
  //notre messagerie mais il reste existant pour le destinataire ou l'emeteur ,
    public function delete($id,$orga,$slug,$page)
    {
      if(isset($_SESSION['user']))
      {
        $contactModel = new ContactModel;
        $leMessage = $contactModel->FindMessageById($id);
        //en premier on recupere le message en question par son id

        if($orga == 'user' && $slug == 'user'){
        //on verifie si on veu supprimer un message de user ou d'organisque
          if($leMessage['emeteur_mailOrId'] == $_SESSION['user']['id'] && $leMessage['emeteur_orga'] == 'users'){
          //ensuite on veu savoir si on est l'emeteur de ce message
            if($leMessage['destinataire_status'] == 'del'){
            //apres on regarde si le destinataire a deja supprimer sa version du message
            //si oui , on supprime totalement de la base de donnee
              $contactModel->delete($leMessage['id']);
            }else{
            //sinon on update
              if($leMessage['date_lecture'] == NULL){
              //si le message n'avait pas ete lu on update la date de lecture a la date de suppression, car on li avan de supprimer
                $contactModel->update(['emeteur_status'=> 'del','date_lecture' =>date('Y-m-d H:i:s')],$leMessage['id']);
              }else {
                //sinon on ajoute simplement 'del' a notre status pour quil ne safiche plus dans notre messagerie
                $contactModel->update(['emeteur_status'=> 'del'],$leMessage['id']);
              }
            }
            if($this->isAjax()){
              return $this->showJson(['redirect'=>$this->generateUrl('admin_message_send',['page' => $page])]);
            }
            $this->redirectToRoute('admin_message_send',['page' => $page]);

          }elseif ($leMessage['destinataire_mailOrId'] == $_SESSION['user']['id'] && $leMessage['destinataire_orga'] == 'users') {
          //ou si on es le destinataire
            if($leMessage['emeteur_status'] == 'del'){
            //on verifie si l'emeteur a deja supprimer le message on supprime en base de donnee
              $contactModel->delete($leMessage['id']);
            }else {
              //sinon on update
                if($leMessage['date_lecture'] == NULL){
                //si le message n'avait pas ete lu on update la date de lecture a la date de suppression, car on li avan de supprimer
                  $contactModel->update(['destinataire_status'=> 'del','date_lecture' =>date('Y-m-d H:i:s')],$leMessage['id']);
                }else {
                  //sinon on ajoute simplement 'del' a notre status pour quil ne safiche plus dans notre messagerie
                  $contactModel->update(['destinataire_status'=> 'del'],$leMessage['id']);
                }
            }
            if($this->isAjax()){
              return $this->showJson(['redirect'=>$this->generateUrl('admin_message',['page' => $page])]);
            }
            $this->redirectToRoute('admin_message',['page' => $page]);
          }
        }else{
        //si on es pas un user c'est que l'on es un organisme

          if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          //on verifie nos droit dans lorganisme en question
            if($orga == 'assoc'){
            //si nous somme une assoc on recupere notre id
              $AssocModel = new AssocModel;
              $id_orga = $AssocModel->FindElementByElement('id','slug',$slug) ;
            }elseif($orga == 'mairie'){
            //meme chose si nous somme une mairie
              $MairieModel = new MairieModel;
              $id_orga = $MairieModel->FindElementByElement('id','slug',$slug) ;
            }elseif($orga == 'webmaster'){
              $id_orga = 'webmaster@as-co-ma.fr' ;
            }

            if($leMessage['emeteur_mailOrId'] == $id_orga && $leMessage['emeteur_orga'] == $orga){
            //et la comme tout a l'heure , si on es emeteur ect....
              if($leMessage['destinataire_status'] == 'del'){
                $contactModel->delete($leMessage['id']);
              }else {
                //sinon on update
                  if($leMessage['date_lecture'] == NULL){
                  //si le message n'avait pas ete lu on update la date de lecture a la date de suppression, car on li avan de supprimer
                    $contactModel->update(['emeteur_status'=> 'del','date_lecture' =>date('Y-m-d H:i:s')],$leMessage['id']);
                  }else {
                    //sinon on ajoute simplement 'del' a notre status pour quil ne safiche plus dans notre messagerie
                    $contactModel->update(['emeteur_status'=> 'del'],$leMessage['id']);
                  }
              }
              if($this->isAjax()){
                return $this->showJson(['redirect'=>$this->generateUrl('admin_message_send_'.$orga,['page' => $page,'orga' => $orga,'slug' => $slug])]);
              }
              $this->redirectToRoute('admin_message_send_'.$orga,['page' => $page,'orga' => $orga,'slug' => $slug]);
            }elseif ($leMessage['destinataire_mailOrId'] == $id_orga && $leMessage['destinataire_orga'] == $orga) {
              if($leMessage['emeteur_status'] == 'del'){
                $contactModel->delete($leMessage['id']);
              }else {
                //sinon on update
                  if($leMessage['date_lecture'] == NULL){
                  //si le message n'avait pas ete lu on update la date de lecture a la date de suppression, car on li avan de supprimer
                    $contactModel->update(['destinataire_status'=> 'del','date_lecture' =>date('Y-m-d H:i:s')],$leMessage['id']);
                  }else {
                    //sinon on ajoute simplement 'del' a notre status pour quil ne safiche plus dans notre messagerie
                    $contactModel->update(['destinataire_status'=> 'del'],$leMessage['id']);
                  }
              }
              if($this->isAjax()){
                return $this->showJson(['redirect'=>$this->generateUrl('admin_message_'.$orga,['page' => $page,'orga' => $orga,'slug' => $slug])]);
              }
              $this->redirectToRoute('admin_message_'.$orga,['page' => $page,'orga' => $orga,'slug' => $slug]);
            }else {
              if($this->isAjax()){
                return $this->showJson(['error'=>'Une erreur est survenue']);
              }
              $this->showErrors('Une erreur est survenue');
            }
          }
        }
      }else{
        if($this->isAjax()){
          return $this->showJson(['redirect'=>$this->generateUrl('racine_form')]);
        }
        $this->redirectToRoute('racine_form');
      }
    }

    public function asSeen($id,$orga,$slug,$page)
    {
      if(isset($_SESSION['user']))
      {
        $contactModel = new ContactModel;
        $leMessage = $contactModel->FindMessageById($id);
        //en premier on recupere le message en question par son id

        if($orga == 'user' && $slug == 'user'){
        //on verifie si on veu supprimer un message de user ou d'organisque
          if($leMessage['destinataire_mailOrId'] == $_SESSION['user']['id'] && $leMessage['destinataire_orga'] == 'users'){
          //on verifie qu'on es bien le destinataire du message
            if($leMessage['date_lecture'] == NULL){
            //si le message n'a pas ete lu on update la date de lecture
              $contactModel->update(['date_lecture' =>date('Y-m-d H:i:s'),'status' => 'lu'],$leMessage['id']);
            }
          }
          if($this->isAjax()){
            return $this->showJson(['redirect'=>$this->generateUrl('admin_message',['page' => $page])]);
          }
          $this->redirectToRoute('admin_message',['page' => $page]);
        }else{
        //si on es pas un user c'est que l'on es un organisme

          if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          //on verifie nos droit dans lorganisme en question
            if($orga == 'assoc'){
            //si nous somme une assoc on recupere notre id
              $AssocModel = new AssocModel;
              $id_orga = $AssocModel->FindElementByElement('id','slug',$slug) ;
            }elseif($orga == 'mairie'){
            //meme chose si nous somme une mairie
              $MairieModel = new MairieModel;
              $id_orga = $MairieModel->FindElementByElement('id','slug',$slug) ;
            }elseif($orga == 'webmaster'){
              $id_orga = 'webmaster@as-co-ma.fr' ;
            }

            if ($leMessage['destinataire_mailOrId'] == $id_orga && $leMessage['destinataire_orga'] == $orga) {
              if($leMessage['date_lecture'] == NULL){
              //si le message n'avait pas ete lu on update la date de lecture a la date de suppression, car on li avan de supprimer
                $contactModel->update(['date_lecture' =>date('Y-m-d H:i:s'),'status' => 'lu'],$leMessage['id']);
              }
            }
            if($this->isAjax()){
              return $this->showJson(['redirect'=>$this->generateUrl('admin_message_'.$orga,['page' => $page,'orga' => $orga,'slug' => $slug])]);
            }
            $this->redirectToRoute('admin_message_'.$orga,['page' => $page,'orga' => $orga,'slug' => $slug]);
          }
        }
      }else{
        if($this->isAjax()){
          return $this->showJson(['redirect'=>$this->generateUrl('racine_form')]);
        }
        $this->redirectToRoute('racine_form');
      }
    }
}
