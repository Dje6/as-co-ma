<?php
namespace Controller\admin;
use Controller\CustomController;

/**
 *
 */
class GenerateViewsController extends CustomController
{
  public function messageView($donnees,$orga=NULL,$slug=NULL,$page)
  {
    $html ='';
    if(empty($slug)){ $slug = 'user' ;}
    if(empty($orga)){ $orga = 'user' ;}

    if(isset($donnees)){
    	if(!empty($donnees)){
    		if(is_array($donnees)){ // si donnee est un array on explore , sinon on affiche le message qu'il contient

      			foreach ($donnees as $key => $value) {

              if(isset($value['destinataire_pseudo'])){
              // si on est dans les message envoyer il affiche ca
              $html .= '<h3 class="padleft4">Destinataire :'.$value['destinataire_pseudo'].'</h3>
                <p class="padleft4">Email : '.$value['destinataire_mail'].'</p><br/>';
               }else{
              //sinon c'est ca
              $html .=  '<h3 class="padleft4">Emetteur : '.$value['emeteur_pseudo'].'</h3>
                <p class="padleft4">Email : '.$value['emeteur_mail'].'</p><br/>';
               }
        				$html .= '<p class="padleft4">Objet : '.$value['objet'].'</p>
        				<p class="padleft4">Message : '.$value['contenu'].'</p><br/>

        				<p class="padleft4">Envoye le : '.$value['date_envoi'].'</p>';
             if($value['status'] == 'lu'){
              //si le statu est a lu , on affiche la date de lecture
              $html .=  '<p class="padleft4">Lu le : '.$value['date_lecture'].'</p>';
             }elseif ($value['status'] != 'lu' && $value['status'] != 'non-lu') {
              //si une reponse a ete faite a ce message on indique la date de reponse
              //qui es la meme date que pour la lecture mais mise a jour
              $html .= '<p class="padleft4">Repondu le : '.$value['date_lecture'].'</p>';
               }
              $html .= '<p class="padleft4">Statut : '.$value['status'].' </p><br/>';

              preg_match_all('/inscript/', $value['objet'], $matches);
              // on detect si il s'agit dune demande d'inscription
              preg_match_all('/Invitation/', $value['objet'], $matches2);
              //ou si il s'agit dune invitation

              if(!empty($matches[0]) && $value['status'] == 'non-lu' && !isset($value['destinataire_pseudo'])){
              //si oui on affiche les bouton de decision

                $html .= '<a href=" '.$this->generateUrl('admin_decide',['id' => $value['id'],'orga' => $orga,
                'slug' => $slug,'decision'=>'Accepter']).' " class="message_btn">
                  <button class="btn btn-success margin1 ">Accepter</button>
                </a>';
                $html .='<a href="'.$this->generateUrl('admin_decide',['id' => $value['id'],'orga' => $orga,
                'slug' => $slug,'decision'=>'Plus-Info']).'" class="message_btn">
                  <button class="btn btn-warning margin1">Manque d\'informations</button>
                </a>';
                $html .='<a href="'.$this->generateUrl('admin_decide',['id' => $value['id'],'orga' => $orga,
                'slug' => $slug,'decision'=>'Refuser']).'" class="message_btn">
                  <button class="btn btn-danger margin1">Refuser</button>
                </a>';

              }elseif ((!empty($matches2[0]) && $value['status'] == 'non-lu' && $orga == 'user')) {

                 $html .= '<a href="'.$this->generateUrl('admin_invitation_decision',['id' => $value['id'],
                 'decision'=>'Accepter']).'" class="message_btn">
                   <button class="btn btn-success margin1">Accepter</button>
                 </a>
                 <a href="'.$this->generateUrl('admin_invitation_decision',['id' => $value['id'],
                 'decision'=>'Refuser']).'" class="message_btn">
                   <button class="btn btn-danger margin1">Refuser</button>
                 </a>';
              }else{
              //sinon j'affiche les autre bouton
                if($orga == 'user' && empty($matches2[0])){
                //si on es un user , on ne peu que repondre , declarer Lu ou le supprimer
                  if(!isset($value['destinataire_pseudo'])){
                    $html .= '<a href="'.$this->generateUrl('admin_repondre_User',['id'=> $value['id']]).'">
                      <button class="btn btn-primary margin1">Répondre</button>
                    </a>';
                  }
                }else {
                //sinon le bouton repondre s'adapte au fait que l'on es un organisme mais reste afficher identique
                  if(!isset($value['destinataire_pseudo']) && ($value['status'] == 'non-lu' || $value['status'] == 'lu')){
                    // le bouton repondre quan on es un organisme ne safiche que sous plusieur condition
                    $html .= '<a href="'.$this->generateUrl('admin_repondre',['id'=> $value['id'],'orga' => $orga,'slug' => $slug]).'">
                      <button class="btn btn-primary margin1">Répondre</button>
                    </a>';
                  }
                }
                if($value['status'] == 'non-lu' && !isset($value['destinataire_pseudo'])){
                //le bouton pour declarer le message comme lu ne safiche QUE si on es mode boite de reception et si le message
                // n'a pas encor ete lu
                  $html .='<a href="'.$this->generateUrl('admin_message_asSeen',['id'=> $value['id'],'orga' => $orga,
                  'slug' => $slug,'page' => $page]).'" class="message_btn">
                    <button class="btn btn-success margin1">Lu</button>
                  </a>';
                }
                //le bouton supprimer lui saffiche tout le temp dés lors que ce n'est pas une demande dinscritpion ou
                //Si s'en est une ,il ne saffiche qui si la demande a ete traiter
                $html .= '<a href="'.$this->generateUrl('admin_message_delete',['id'=> $value['id'],'orga' => $orga,
                'slug' => $slug,'page' =>$page]).'" class="message_btn_supprimer">
                  <button class="btn btn-danger margin1">Supprimer</button>
                </a>';
              }
              $html .='<br/>
              <br/>
              <br/>';

      			}//fin du foreach
    		}
    	}else{
        $html .='<h3 class="titreback">Aucun messages</h3>';
      }
    }
    return $html;
  }

}
