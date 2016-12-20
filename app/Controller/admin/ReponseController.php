<?php
namespace Controller\admin ;

use \Controller\CustomController;
use \Service\ValidationTools;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\ContactModel;
use \Model\UserModel;
use \PHPMailer;
/**
 *
 */
class ReponseController extends CustomController
{
  public function accepte($id,$orga,$slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        $contactModel = new ContactModel;
        $leMessage = $contactModel->FindMessageById($id);
        $UserModel = new UserModel;
        debug($leMessage);

        if(is_numeric($leMessage['emeteur_mailOrId'])){
          //si c'est un id , on repon en interne
          if($leMessage['emeteur_orga'] == 'assoc'){
                            //(le type de destinataire,le type demeteur, lidentifian du destinataire , lidentifian de lemeteur , les donnee)
            $this->sendMessage($leMessage['emeteur_orga'],$leMessage['destinatire_orga'],$idDestinaire,$idEmeteur,$r_POST);

          }elseif($leMessage['emeteur_orga'] == 'mairie'){
            sendMessage($orgaDestinataire,$orgaEmeteur,$slugEmeteur,$slugRecepteur,$r_POST);

          }elseif($leMessage['emeteur_orga'] == 'users'){
            sendMessage($orgaDestinataire,$orgaEmeteur,$slugEmeteur,$slugRecepteur,$r_POST);

          }
        }else {
          //sinon on verifie quan mm en base de donnee si le mail peu exister
          if($leMessage['emeteur_orga'] == 'public'){
            if($UserModel->emailExists($leMessage['emeteur_mailOrId'])){
              $idUser = $UserModel->FindElementByElement('id','mail',$leMessage['emeteur_mailOrId']);

              //si le mail fait reference a un utilisateur on repond en interne
              //et on ajoute en tant que user

            }else {
              // on envoi un mail pour proposer de sinscrire sur le site
              // il semblerai que votre email ne soi pas connu sur notre site ,
              //si vous etes deja enregistrer sur le site , merci de nou refaire une demande
              //avec le mail enregistrer , sinon cliquer sur ce lien pour creer un compte
              //et devenir un de nos membre des la fin de votre inscritpion
            }
          }
        }

      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
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
  public function Repondre($id,$orga,$slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
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
        if($_POST){
          $r_POST = $this->nettoyage($_POST);
          $r_POST['emeteur_pseudo'] = $pseudoEmeteur;

          $this->sendMAil($orgaDestinataire = $leMessage['emeteur_orga'],$orgaEmeteur = $leMessage['destinataire_orga'],
          $idDestinaire = $leMessage['emeteur_mailOrId'],$idEmeteur = $leMessage['destinataire_mailOrId'],
          $maildestinataire,$leMessage,$r_POST);

        }else {
          $this->show('admin/EditReponse',['mailRecepteur' => $maildestinataire,'leMessage' => $leMessage,
          'slug' => $pseudoEmeteur,'orga' => $leMessage['destinataire_orga']]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function RepondreUser($id)
  {
    if(isset($_SESSION['user'])){
      $contactModel = new ContactModel;
      $leMessage = $contactModel->FindMessageById($id);
      $maildestinataire = $this->FindMailDestinataire($leMessage['emeteur_orga'],$leMessage['emeteur_mailOrId']);
      $pseudoEmeteur = $this->FindPseudoEmeteur($leMessage['destinataire_orga'],$leMessage['destinataire_mailOrId']);

      if($_POST){
        $r_POST = $this->nettoyage($_POST);
        $r_POST['emeteur_pseudo'] = $pseudoEmeteur;

        $this->sendMail($orgaDestinataire = $leMessage['emeteur_orga'],$orgaEmeteur = $leMessage['destinataire_orga'],
        $idDestinaire = $leMessage['emeteur_mailOrId'],$idEmeteur = $leMessage['destinataire_mailOrId'],
        $maildestinataire,$leMessage,$r_POST);

      }else {
        $this->show('admin/EditReponse',['mailRecepteur' => $maildestinataire,'leMessage' => $leMessage,
        'slug' => $pseudoEmeteur,'orga' => $leMessage['destinataire_orga']]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
//gere l'envoi des message interne ET des mail externe , detecte automatiquement comment lenvoi doit etre fait
//si on envoi un email externe , on enregistre une copie de l'envoi en base de donnee
  public function sendMail($orgaDestinataire,$orgaEmeteur,$idDestinaire,$idEmeteur,$maildestinataire,$leMessage,$r_POST)
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
        $this->show('admin/EditReponse',['mailRecepteur' => $maildestinataire,'leMessage' => $leMessage,
        'donnee' => $r_POST,'error' => $error,'orga' => $orgaEmeteur ,'slug' => $r_POST['emeteur_pseudo']]);

      }else{
        unset($r_POST['submit']);
        unset($r_POST['capcha']);

        $r_POST['emeteur_mailOrId'] = $idEmeteur;
        $r_POST['destinataire_orga'] = $orgaDestinataire;
        $r_POST['destinataire_mailOrId'] = $idDestinaire;
        $r_POST['emeteur_orga'] = $orgaEmeteur;
        $r_POST['date_envoi'] = date('Y-m-d H:i:s');
        $r_POST['status'] = 'non-lu';
        //si c'est un utilisateur enregister on repon en interne
        $contactModel = new ContactModel;
        if(is_numeric($r_POST['destinataire_mailOrId'])){
          if($contactModel->insert($r_POST,false)){
            $this->show('admin/EditReponse',['orga' => $orgaEmeteur ,'slug' => $r_POST['emeteur_pseudo']
            ,'mailRecepteur' => $maildestinataire,'confirmation'=> 'Votre message a bien été envoyé.',
          'leMessage' => $leMessage]);
          }else{
            $this->show('admin/EditReponse',['orga' => $orgaEmeteur ,'slug' => $r_POST['emeteur_pseudo'],
            'mailRecepteur' => $maildestinataire,'confirmation'=> 'Une erreur est survenue.',
          'leMessage' => $leMessage]);
          }
        }else{ //sinon on envoi une copi interne + le mail externe
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
          $messagedumail .= 'N\'esitez pas a venir vous inscrire sur notre site! c\'est gratuit!';                                   

          $mail->Subject = $r_POST['objet'];
          $mail->Body    = $messagedumail ;
          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          if(!$mail->send()) {
            $this->show('admin/EditReponse',['orga' => $orgaEmeteur ,'slug' => $r_POST['emeteur_pseudo'],
            'mailRecepteur' => $maildestinataire,'confirmation'=> $mail->ErrorInfo,
          'leMessage' => $leMessage]);
          } else {
            $this->show('admin/EditReponse',['orga' => $orgaEmeteur ,'slug' => $r_POST['emeteur_pseudo']
            ,'mailRecepteur' => $maildestinataire,'confirmation'=> 'Votre message a bien été envoyé.',
          'leMessage' => $leMessage]);
          }
        }
      }
    }
  }
  //recupere ladresse mail du destinataire parmi les 3 table , users , mairie , assoc
  public function FindMailDestinataire($destinataire_orga,$destinataire_id)
  {
    if($destinataire_orga == 'assoc'){
      $AssocModel = new AssocModel;
      return $AssocModel->FindElementByElement('mail','id',$destinataire_id) ;
    }elseif($destinataire_orga == 'mairie'){
      $MairieModel = new MairieModel;
      return $MairieModel->FindElementByElement('mail','id',$destinataire_id) ;
    }elseif($destinataire_orga == 'users'){
      $UserModel = new UserModel;
      return $UserModel->FindElementByElement('mail','id',$destinataire_id) ;
    }elseif ($destinataire_orga == 'webmaster') {
      return 'webmaster@as-co-ma.fr';
    }
  }
//trouve le pseudo de l'emeteur parmi les 3 table , users , mairie , assoc
  public function FindPseudoEmeteur($emeteur_orga,$emeteur_id)
  {
    if($emeteur_orga == 'assoc'){
      $AssocModel = new AssocModel;
      return $AssocModel->FindElementByElement('slug','id',$emeteur_id) ;
    }elseif($emeteur_orga == 'mairie'){
      $MairieModel = new MairieModel;
      return $MairieModel->FindElementByElement('slug','id',$emeteur_id) ;
    }elseif($emeteur_orga == 'users'){
      $UserModel = new UserModel;
      return $UserModel->FindElementByElement('pseudo','id',$emeteur_id) ;
    }elseif ($emeteur_orga == 'webmaster') {
      return 'webmaster';
    }
  }
}

 ?>
