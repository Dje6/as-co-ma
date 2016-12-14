<?php
namespace Controller\Racine;

use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Controller\CustomController ;
use \Model\UsersCustomModel;
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

        $Authent = new AuthentificationModel();
        $get_user = new UsersCustomModel;
        $user_id = $get_user->isValidLoginInfo($_POST['pseudo'], $_POST['password']);

        if($user_id == 0){  //si ya un soucis on retourne sur le formulaire avec les erreur
          $this->show('connexion/login',array(
            'error'  => 'Les donnee saisi sont invalide'
          ));
        }else{//sinon on verifie si le compte est active
          $user = $get_user->getUserByUsernameOrEmail($_POST['pseudo']);

          if($user['status'] == 'Actived'){// si le compte es actif on va sur la page d'accueil du back
            $Authent->logUserIn($user);
            $this->redirectToRoute('admin_monCompte');
          }else {// sinon on rappel que le compte n'est pas actif et on propose de renvoyer de nouveau le mail

            $this->show('racine/inscription',['confirmation'=> 'Votre compte n\' est pas activer ,
            verifier vos mail afin d\'activer votre compte<br/>Si vous souhaiter recevoir
            un nouveau mail : <a href="'.$this->generateUrl('racine_send_valide',['mail' => urlencode($user['mail']),
            'token' =>urlencode($user['token'])]).'">Cliquer ici</a>']);
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
    $usersModel = new UsersCustomModel;
    if($_POST){
      $r_POST = $this->nettoyage($_POST);

      if(empty($r_POST['capcha'])){
        $error['pseudo'] = ValidationTools::textValid($r_POST['pseudo'], 'pseudo',5,30);
        if($usersModel->usernameExists($r_POST['pseudo'])){ $error['pseudo'] = 'Ce pseudo exist deja' ; }
        $error['mail'] = ValidationTools::emailValid($r_POST['mail']);
        if($usersModel->emailExists($r_POST['mail'])){ $error['mail'] = 'Cet email exist deja' ; }
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
        $error['capcha'] = 'vous etes un bots';
      }
    }else{
      $error['donnee'] = 'donnee manquante';
    }
    if(!ValidationTools::IsValid($error)){
      $this->show('racine/inscription',array('saisi' => $r_POST,'error' => $error));
      exit();
    }else{
      unset($r_POST['r_password']);
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
        $this->show('racine/inscription',['confirmation'=> 'une erreur est survenu']);
      }
    }
  }
  //envoi l'email de confirmation de compte
  public function sendMailValidate($email,$token)
  {

    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                              // Enable verbose debug output
    $mail->isMail();
    $mail->setFrom('Assaucisse@xamp.com', 'Mailer');
    $mail->addAddress(urldecode($email), '');
    $mail->addReplyTo('do-no-reply@xamp.com', 'Information');
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Bienvenue sur Assaussice ';
    $mail->Body    = 'Bonjour, <br/>
    Votre inscription a bien ete prise en compte, veuillez suivre ce lien pour activer votre compte :
    <a href="http://127.0.0.1/ecole/assaucisse/public/valid_inscript/'.trim(strip_tags($email)).'/
    '.trim(strip_tags($token)).'">Cliquez ici</a><br/>' ;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
      $this->show('racine/inscription',['confirmation'=> $mail->ErrorInfo]);
    } else {
        $this->show('racine/inscription',['confirmation'=> 'Un email de confirmation
        vous a ete adresser a l\' adresse : '.urldecode(trim(strip_tags($email))).' ,
         consulter ce mail et cliquer sur le lien fourni pour activer votre compte']);
    }
  }
  //traite la requete d 'activation du compte
  public function validation($mail,$token)
  {
    if(!empty($mail) && !empty($token)){
      $mail = trim(strip_tags(urldecode($mail)));
      $token =  trim(strip_tags(urldecode($token)));
      $array = array();
      $usersModel = new UsersCustomModel;
      $id = $usersModel->tokenOK($mail,$token);
      if(!empty($id) && is_numeric($id)){
        $newToken = StringUtils::randomString(50);
        if($usersModel->update(['status' => 'Actived','token' => $newToken], $id)){
          $this->show('racine/inscription',['confirmation'=> 'Votre compte est activer!
          <a href="'.$this->generateUrl('racine_form').'">Connectez-vous !</a>']);
        }
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
    $error = array();
    if($_POST){
      $r_POST = $this->nettoyage($_POST);

      if(empty($r_POST['capcha'])){

        //on fait les verif si le mail es ok et en base de donnee

      }else {
        $error['capcha'] = 'vous etes un bots';
      }


    }else{
      $error['donnee'] = 'donnee manquante';
    }
    if(!empty($error)){
      $this->show('racine/rescu',array('error' => $error));
      exit();
    }else{
      //on envoi le mail pour recuperer le mot de passe
    }
  }
}
 ?>
