<?php
namespace Controller\Racine;

use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Controller\CustomController ;
use \Model\UserModel;
use \Model\UsersCustomModel;
use \Model\ContactModel;
use \Model\RolesModel;
use \Service\ValidationTools;
use \W\Security\StringUtils;
use \PHPMailer;

class ConnexionController extends CustomController
{  //traite la connexion
  public function login()
  {

    if(isset($_SESSION['user'])){//si on es deja connecter on affiche directement la page perso
      $this->show('admin/users');
    }else{ // sinon on verifie les donnee

      if($_POST){ //Si post exist c'est que le formulaire a deja ete envoyer
        $r_POST = $this->nettoyage($_POST);

        $Authent = new AuthentificationModel();
        $get_user = new UserModel;
        $user_id = $get_user->isValidLoginInfo($_POST['pseudo'], $_POST['password']);

        if($user_id == 0){  //si ya un soucis on retourne sur le formulaire avec les erreur
          $this->show('racine/connexion',['error'  => 'Les données saisies sont invalides.','saisi'=> $r_POST]);
        }else{//sinon on verifie si le compte est active
          $user = $get_user->getUserByUsernameOrEmail($_POST['pseudo']);

          if($user['status'] == 'Actived'){// si le compte es actif on va sur la page d'accueil du back
            $Authent->logUserIn($user);
            $this->redirectToRoute('admin_monCompte');
          }else {// sinon on rappel que le compte n'est pas actif et on propose de renvoyer de nouveau le mail

            $this->show('racine/inscription',['confirmation'=> 'Votre compte n\'est pas activé. Vérifiez votre boîte mail afin d\'activer votre compte.<br/>Si vous souhaitez recevoir
            un nouveau mail : <a href="'.$this->generateUrl('racine_send_valide',['mail' => urlencode($user['mail']),
            'token' =>urlencode($user['token'])]).'">Cliquez ici.</a>']);
          }
        }
      }else{//sinon on affiche le formulaire de connection
        $this->show('racine/connexion');
      }
    }
  }
// si on es deja connecter on es accede au back , sinon on es rediriger sur la page de connexion
  public function form()
  {
    if(isset($_SESSION['user'])){
      $this->redirectToRoute('admin_monCompte');
    }else{
      $this->show('racine/connexion');
    }
  }
//deconnexion
  public function unlog()
  {
    $Authent = new AuthentificationModel();
    $Authent -> logUserOut();
    $this->redirectToRoute('racine_connexion');
  }
  //affiche le formulaire d'inscritpion
  public function inscriptForm()
  {
    $this->show('racine/inscription');
  }
//traite le formulaire d'inscritpion
  public function inscriptPost()
  {
    $error = array();
    $usersModel = new UserModel;
    if($_POST){
      $r_POST = $this->nettoyage($_POST);

      if(empty($r_POST['capcha'])){
        $error['pseudo'] = ValidationTools::textValid($r_POST['pseudo'], 'pseudo',5,30);
        if($usersModel->usernameExists($r_POST['pseudo'])){ $error['pseudo'] = 'Ce pseudo existe déjà.' ; }
        $error['mail'] = ValidationTools::emailValid($r_POST['mail']);
        if($usersModel->emailExists($r_POST['mail'])){ $error['mail'] = 'Cet e-mail existe déjà.' ; }
        $error['password'] = ValidationTools::passwordValid($r_POST['password'],$r_POST['r_password'],5,30);
        $error['r_password'] = ValidationTools::passwordValid($r_POST['password'],$r_POST['r_password'],5,30);
        $error['prenom'] = ValidationTools::textValid($r_POST['prenom'], 'prenom',2,30);
        $error['nom'] = ValidationTools::textValid($r_POST['nom'], 'nom',3,30);
        $error['adresse'] = ValidationTools::textValid($r_POST['adresse'], 'adresse',3,50);
        $error['code_postal'] = ValidationTools::code_postalVerif($r_POST['code_postal']);
        $error['ville'] = ValidationTools::textValid($r_POST['ville'], 'ville',3,30);
        $error['fix'] = ValidationTools::telVerif($r_POST['fix'],true);
        $error['mobile'] = ValidationTools::telVerif($r_POST['mobile'],true);
      }else {
        $error['capcha'] = 'Hello ROBOT';
      }
    }else{
      $error['donnee'] = 'Donnée(s) manquante(s).';
    }
    if(!ValidationTools::IsValid($error)){
      $this->show('racine/inscription',array('saisi' => $r_POST,'error' => $error));
      exit();
    }else{
      unset($r_POST['r_password']);
      unset($r_POST['submit']);
      unset($r_POST['capcha']);
      if(empty($r_POST['fix'])){
        unset($r_POST['fix']);
      }
      if(empty($r_POST['mobile'])){
        unset($r_POST['mobile']);
      }
      $pass = password_hash($r_POST['password'], PASSWORD_DEFAULT);
      $r_POST['password'] = $pass;
      $r_POST['created_at'] = date('Y-m-d H:i:s');
      $r_POST['token'] = StringUtils::randomString(50);
      $r_POST['status'] = 'no-actived';

      if($usersModel->insert($r_POST,false)){
        $this->redirectToRoute('racine_send_valide',['mail' =>urlencode($r_POST['mail']),'token' =>urlencode($r_POST['token'])]);
      }else{
        $this->show('racine/inscription',['confirmation'=> 'Une erreur est survenue.']);
      }
    }
  }
  //envoi l'email de confirmation de compte
  public function sendMailValidate($email,$token)
  {

    $app = getApp();
    $urlLink = $this->generateUrl('racine_valide_inscript',
    ['mail' => trim(strip_tags($email)), 'token' => trim(strip_tags($token))],true);

    $mail = new PHPMailer();
    $mail->CharSet = "utf8";
    //$mail->SMTPDebug = 3;                              // Enable verbose debug output
    $mail->isMail();
    $mail->setFrom('Webmaster@as-co-ma.com', 'Mailer');
    $mail->addAddress(urldecode($email), 'exemple@example.com');
    $mail->addReplyTo('no-reply@xamp.com', 'Information');
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Bienvenue sur AS-CO-MA ';
    $mail->Body    = 'Bonjour, <br/>
    Votre inscription a bien été prise en compte, veuillez suivre ce lien pour activer votre compte :
    <a href="'.$urlLink.'">Cliquez ici</a><br/>' ;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
      $this->show('racine/inscription',['confirmation'=> $mail->ErrorInfo]);
    } else {
        $this->show('racine/inscription',['confirmation'=> 'Un e-mail de confirmation
        vous a été adressé à l\'adresse : '.urldecode(trim(strip_tags($email))).'. Consultez ce mail et cliquez sur le lien fourni pour activer votre compte.']);
    }
  }
  //traite la requete d 'activation du compte
  public function validation($mail,$token)
  {
    if(!empty($mail) && !empty($token)){
      $mail = urldecode(trim(strip_tags($mail)));
      $token =  urldecode(trim(strip_tags($token)));
      $array = array();
      $usersModel = new UserModel;
      $id = $usersModel->tokenOK($mail,$token);
      $LePseudo = $usersModel->FindElementByElement('pseudo','id',$id);
      if(!empty($id) && is_numeric($id)){
        $newToken = StringUtils::randomString(50);
        if($usersModel->update(['status' => 'Actived','token' => $newToken], $id)){

          $contactModel = new ContactModel;

          $contactModel->updateMessageDestinataire(['destinataire_mailOrId' => $id,
            'destinataire_status'=> 'NULL','destinataire_orga'=>'users',],$mail);

          $contactModel->updateMessageEmeteur(['emeteur_mailOrId' => $id,
            'emeteur_status'=> 'NULL','emeteur_pseudo'=>$LePseudo,
            'emeteur_orga'=>'users',],$mail);

            $demande = $contactModel->findDemandeValider($id);
          if($demande){
            $RolesModel = new RolesModel;
            $result = $RolesModel->insert(['id_assoc' => $demande['destinataire_mailOrId'],
            'id_user' => $id,'role' => 'User']);

            if(!$result){// si ca c bien passer
              $this->showErrors('Un problème est survenu lors de l\'attribution du rôle.');
            }
          }

          $this->show('racine/inscription',['confirmation'=> 'Votre compte est activé !
          <a href="'.$this->generateUrl('racine_form').'">Connectez-vous !</a>']);
        }
      }else {
        $this->redirectToRoute('default_home');
      }
    }
  }
  //affiche le formulaire pour recuperer le mot e passe
  public function mdpForm()
  {
    $this->show('racine/rescu');
  }
  //traite la demande de changement de passe
  public function mdpPost()
  {

    $mail = new PHPMailer();
    $mail->CharSet = "utf8";
    $error = array();
    if($_POST){
      $r_POST = $this->nettoyage($_POST);

      if(empty($r_POST['capcha'])){
        //on fait les verif si le mail es ok et en base de donnee
        $error['email'] = ValidationTools::emailValid($r_POST['email'],true);
        if(ValidationTools::isValid($error)){

            $usersModel = new UsersCustomModel;
            $token = $usersModel->recupToken($r_POST['email']);
            $urlLink = $this->generateUrl('racine_modifyForm',['mail' => urlencode($r_POST['email']), 'token' => $token],true);

            $message = '<a href="'.$urlLink.'">cliquez ici</a>';
            $mail-> isMail();
            $mail->setFrom('Webmaster@ascoma.com', 'Mailer');
            $mail->addAddress($r_POST['email'], 'Joe User');     // Add a recipient

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Here is the subject';
            $mail->Body    = $message;

            if(!$mail->send()) {
              $this->showErrors('Le message n\'a pas pu être envoyé ' . $mail->ErrorInfo);
            } else {

              $this->redirectToRoute('default_home');
            }

        } else {
          $this->show('racine/rescu', ['error' => $error]);
        }

      }else {
        $error['capcha'] = 'Hello ROBOT';
      }


    }else{
      $error['donnee'] = 'Donnée(s) manquante(s).';
    }
    if(!empty($error)){
      $this->show('racine/rescu',array('error' => $error));
      exit();
    }else{
      //on envoi le mail pour recuperer le mot de passe
    }
  }
  public function modifyForm($mail,$token)
  {
    $this->show('racine/modify',['mail' => urldecode(trim(strip_tags($mail))), 'token' => urldecode(trim(strip_tags($token)))]);
  }

  public function modifyPost()
  {
    // debug($_POST);
    if($_POST){
      $usersModel = new UserModel;
      $r_POST = $this->nettoyage($_POST);

      if(!$usersModel->emailExists($r_POST['mail'])){ $error['mail'] = 'Cet e-mail n\'existe pas.' ; }

      if(empty($usersModel->tokenOK($r_POST['mail'],$r_POST['token']))){ $error['token'] = 'Token introuvable' ;
      } else { $id = $usersModel->tokenOK($r_POST['mail'],$r_POST['token']); }

      $error['password'] = ValidationTools::passwordValid($r_POST['password'],$r_POST['repeat_password'],5,30);
      $error['repeat_password'] = ValidationTools::passwordValid($r_POST['password'],$r_POST['repeat_password'],5,30);

      if(ValidationTools::isValid($error)){

        $newToken = StringUtils::randomString(50);
        $data = array('password' => password_hash($r_POST['password'], PASSWORD_DEFAULT), 'token' => $newToken);
        $usersModel->update($data,$id);

        $this->redirectToRoute('racine_form');
      } else {
        $this->show('racine/modify', ['error' => $error,'donnee' => $r_POST]);
      }


    }
  }
}
 ?>
