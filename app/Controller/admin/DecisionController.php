<?php
namespace Controller\admin ;
use \Controller\admin\ReponseController;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\ContactModel;
use \Model\UserModel;
use \PHPMailer;
/**
 *
 */
class DecisionController extends ReponseController
{
    public function accepte($id,$orga,$slug)
    {
      if(isset($_SESSION['user']))
      {
        if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          $UserModel = new UserModel;
          $contactModel = new ContactModel;
          $leMessage = $contactModel->FindMessageById($id);

          if(!is_numeric($leMessage['emeteur_mailOrId'])){ //si c'est ce n'est pas id on verifie si eventuelemt il exist en base
            $UserModel = new UserModel;
            if($UserModel->emailExists($leMessage['emeteur_mailOrId'])){ //si oui on recupere l'id
              $leMessage['emeteur_mailOrId'] = $UserModel->FindElementByElement('id','mail',$leMessage['emeteur_mailOrId']);
            }
          }

          if(is_numeric($leMessage['emeteur_mailOrId'])){// si c'est un id on repon en interne
            $maildestinataire = $this->FindMailDestinataire($leMessage['emeteur_orga'],$leMessage['emeteur_mailOrId']);
          }else {//sinon en externe
            $maildestinataire = $leMessage['emeteur_mailOrId'];
          }

          $pseudoEmeteur = $this->FindPseudoEmeteur($leMessage['destinataire_orga'],$leMessage['destinataire_mailOrId']);

            $donnee = $this->generateDonnee($leMessage['objet'],$pseudoEmeteur)

            $r_POST['emeteur_pseudo'] = $pseudoEmeteur;
            $r_POST['objet'] = 'Re:'.$donnee['objet'] ;
            $r_POST['contenu'] = $donnee['contenu'];
            $r_POST['destinataire_status'] = 'del';
            $r_POST['laDecision'] = 'Accepter';

            $this->sendDecision($orgaDestinataire = $leMessage['emeteur_orga'],$orgaEmeteur = $leMessage['destinataire_orga'],
            $idDestinaire = $leMessage['emeteur_mailOrId'],$idEmeteur = $leMessage['destinataire_mailOrId'],
            $maildestinataire,$leMessage,$r_POST);

        }
      }else{
        $this->redirectToRoute('racine_form');
      }
    }

    //refuse la demande mais pourrai accepter si une nouvelle demande es faite avec davantage dinformation
    public function plusInfo($id,$orga,$slug)
    {
      if(isset($_SESSION['user']))
      {
        if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          $contactModel = new ContactModel;
          $leMessage = $contactModel->FindMessageById($id);


        }
      }else{
        $this->redirectToRoute('racine_form');
      }
    }

    //refuse la demande
    public function refuse($id,$orga,$slug)
    {
      if(isset($_SESSION['user']))
      {
        if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          $contactModel = new ContactModel;
          $leMessage = $contactModel->FindMessageById($id);

        }
      }else{
        $this->redirectToRoute('racine_form');
      }
    }
    public function sendDecision($orgaDestinataire,$orgaEmeteur,$idDestinaire,$idEmeteur,$maildestinataire,$leMessage,$r_POST)
    {
      if(isset($_SESSION['user']))
      {
          $laDecision = $r_POST['laDecision'];
          unset($r_POST['decision']);

          $r_POST['emeteur_mailOrId'] = $idEmeteur;
          $r_POST['destinataire_orga'] = $orgaDestinataire;
          $r_POST['destinataire_mailOrId'] = $idDestinaire;
          $r_POST['emeteur_orga'] = $orgaEmeteur;
          $r_POST['date_envoi'] = date('Y-m-d H:i:s');
          $r_POST['status'] = 'non-lu';
          //si c'est un utilisateur enregister on repon en interne
          $contactModel = new ContactModel;
          debug($r_POST);
          if(is_numeric($r_POST['destinataire_mailOrId'])){
            if($contactModel->insert($r_POST,false)){
              $contactModel->update(['status' => $laDecision,'date_lecture' => date('Y-m-d H:i:s')],$leMessage['id']);
              $this->redirectToRoute('admin_message_'.$orgaEmeteur,['orga' => $orgaEmeteur,'slug' => $r_POST['emeteur_pseudo'] ,'page'=>1]);
            }else{
              $this->showErrors('L\'envoi du message a echoué');
            }
          }else{ //sinon on envoi une copi interne + le mail externe
            $r_POST['destinataire_status'] = 'del';
            $contactModel->insert($r_POST,false);
            $app = getApp();
            $urlBase = $app->getConfig('urlBase');

            $mail = new PHPMailer();
            //$mail->SMTPDebug = 3;                              // Enable verbose debug output
            $mail->isMail();
            $mail->setFrom('Assaucisse@as-co-ma.fr', 'Mailer');
            $mail->addAddress($r_POST['destinataire_mailOrId'], 'exemple@example.com');
            $mail->addReplyTo('do-no-reply@as-co-ma', 'Information');
            $mail->isHTML(true);    // Set email format to HTML

            $messagedumail = 'Bonjour ,<br/>';
            $messagedumail .= $r_POST['contenu'].'<br/>';
            $messagedumail .= '';

            $mail->Subject = $r_POST['objet'];
            $mail->Body    = $messagedumail ;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
              $this->showErrors('L\'envoi du message a echoué '.$mail->ErrorInfo);
            } else {
              $contactModel->update(['status' => $laDecision,'date_lecture' => date('Y-m-d H:i:s')],$leMessage['id']);
              $this->redirectToRoute('admin_message_'.$orgaEmeteur,['orga' => $orgaEmeteur,'slug' => $r_POST['emeteur_pseudo'] ,'page'=>1]);
          }
        }
      }
    }
    public function generateDonnee($objet,$pseudo)
    {
      if($objet == 'inscript_mairie'){
        $array['objet'] = 'Inscrire ma Mairie';
        if(is_numeric($pseudo)){
          $array['contenu'] = 'ok on vous a donner les droit pour creer la mairie , suiver ce lien pour
          remplir les formulaire , nous verifieron les information avant de mettre en ligne la mairie';
        }else {
          $array['contenu'] = 'Nous serion ravi de compter votre mairie parmi notre site ,
          pour cela rendez vous a cette adresse : url afin de vous inscrire comme utilisateur ,
           nous vous attribueron alors les droit pour creer votre mairie , ';
        }
      }elseif($objet == 'inscript_assoc'){
        $array['objet'] = 'Inscrire mon Association';
        if(is_numeric($pseudo)){
          $array['contenu'] = 'le message si c une demande d assoc';
        }else {
          $array['contenu'] = 'le message si c une demande d assoc';
        }
      }elseif($objet == 'inscript_membre'){
        $array['objet'] = 'Devenir membre de l\'association';
        if(is_numeric($pseudo)){
          $array['contenu'] = 'le message si c une demande de membre';
        }else {
          $array['contenu'] = 'le message si c une demande de membre';
        }
      }
      return $array;
    }

}
 ?>
