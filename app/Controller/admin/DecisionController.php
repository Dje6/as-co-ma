<?php
namespace Controller\admin ;
use \Controller\admin\ReponseController;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\ContactModel;
use \Model\RolesModel;
use \Model\UserModel;
use \Controller\admin\GenerateDataController;
use \Controller\admin\RolesController;
use \PHPMailer;
use \W\Security\StringUtils;
/**
 *
 */
class DecisionController extends ReponseController
{
    public function decision($id,$orga,$slug,$decision)
    {
      if(isset($_SESSION['user']))
      {
        if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          $UserModel = new UserModel;
          $contactModel = new ContactModel;
          $leMessage = $contactModel->FindMessageById($id);

          //on verifie si c'est un ID ou email qui nous ecrit , pour savoir si on doit repondre en interne ou en mail
          if(!is_numeric($leMessage['emeteur_mailOrId'])){ //si c'est ce n'est pas id on verifie si eventuelemt il le mail
            //exist en base en base de donnee
            $UserModel = new UserModel;
            if($UserModel->emailExists($leMessage['emeteur_mailOrId'])){ //si oui on recupere l'id
              $leMessage['emeteur_mailOrId'] = $UserModel->FindElementByElement('id','mail',$leMessage['emeteur_mailOrId']);
            }
          }

          //ici on verifie si c'est un ID (si c 'ete un email a lorgine mais quil exist en base de donne ,
          //la ligne precedante le transform')
          if(!is_numeric($leMessage['emeteur_mailOrId'])){
            // si ce n'est pas un nombre , on cherche le mail de
            // lutilisateur avec cette ID
            $maildestinataire = $this->FindMailDestinataire($leMessage['emeteur_orga'],$leMessage['emeteur_mailOrId']);
            if(!$maildestinataire){
              //si pour une raison inconnu le mail retourne FALSE , on atribu l'ID
              $maildestinataire = $leMessage['emeteur_mailOrId'];
            }
          }else {//sinon en interne
            $maildestinataire = $leMessage['emeteur_mailOrId'];
          }

          $pseudoEmeteur = $this->FindPseudoEmeteur($leMessage['destinataire_orga'],$leMessage['destinataire_mailOrId']);
          $orga_demande = $this->analiseObject($leMessage['objet']);

          if(is_numeric($maildestinataire) && $decision == 'Accepter'){
            $RolesModel = new RolesModel;

            //////////////////////////////////////////////////////////////////
            ///////////////////////      MAIRIE            ///////////////////
            /////////////////////////////////////////////////////////////////
            if($orga_demande == 'mairie'){

              $MairieModel = new MairieModel;
              $dateEtHeure = date('Y-m-d H:i:s');
              $SlugTemporaire = StringUtils::randomString($length = 15);
              $result = $MairieModel->insert(['status' =>'En attente','id_user' =>$maildestinataire,'nom' =>'',
              'slug' => $SlugTemporaire,
              'token' => StringUtils::randomString($length = 80),'adresse' =>'','code_postal' => '','departement' => '','ville' => '',
              'mail' => '','fix' =>'',
              'horaire' => 'a:7:{s:5:"Lundi";s:0:"";s:5:"Mardi";s:0:"";s:8:"Mercredi";s:0:"";s:5:"Jeudi";s:0:"";s:8:"Vendredi";s:0:"";s:6:"Samedi";s:0:"";s:8:"Dimanche";s:0:"";}',
              'created_at' => $dateEtHeure]);

              if($result){//si le premier insert c bien passer on avance
                $id_mairie = $MairieModel->FindElementByElement('id','created_at',$dateEtHeure);
                $result2 = $RolesModel->insert(['id_mairie' => $id_mairie,'id_user' => $maildestinataire,'role' => 'Admin']);

                if($result2){//si le deuxieme c bien passer on avance
                  if($_SESSION['user']['id'] == $maildestinataire){//si les modif nous concerne nous on met a jour la session

                    $nbr = count($_SESSION['user']['roles']);// on compte combien de role il y a actuelement
                    //pour savoir quel CLE mettre pour le nouveau role
                    $_SESSION['user']['roles'][$nbr]['orga'] = 'Mairie';
                    $_SESSION['user']['roles'][$nbr]['id'] = $id_mairie;
                    $_SESSION['user']['roles'][$nbr]['role'] = 'Admin';
                    $_SESSION['user']['roles'][$nbr]['nom'] = '';
                    $_SESSION['user']['roles'][$nbr]['slug'] = $SlugTemporaire;
                    $_SESSION['user']['roles'][$nbr]['id_user'] = $maildestinataire;
                  }
                }else {
                  if($this->isAjax()){
                    return $this->showJson(['error'=>'Un problème est survenu lors de l\'attribution du rôle']);
                  }
                  $this->showErrors('Un problème est survenu lors de l\'attribution du rôle');
                }
              }else {
                if($this->isAjax()){
                  return $this->showJson(['error'=>'Un problème est survenu lors de la création'.$result]);
                }
                $this->showErrors('Un problème est survenu lors de la création'.$result);
              }
              //////////////////////////////////////////////////////////////////
              ///////////////////////     ASSOC            ///////////////////
              /////////////////////////////////////////////////////////////////
            }elseif ($orga_demande == 'assoc') {
              $AssocModel = new AssocModel;
              $MairieModel = new MairieModel;
              $dateEtHeure = date('Y-m-d H:i:s');
              $id_mairie = $MairieModel->FindElementByElement('id','slug',$slug);
              $SlugTemporaire = StringUtils::randomString($length = 15);

              $result = $AssocModel->insert(['status' =>'En attente','id_user' =>$maildestinataire,'nom' =>'',
              'slug' => $SlugTemporaire,'id_mairie' => $id_mairie,
              'token' => StringUtils::randomString($length = 80),'adresse' =>'','code_postal' => '',
              'ville' => '','mail' => '','created_at' => $dateEtHeure]);

              if($result){ //si le premier insert c bien passer
                $id_assoc = $AssocModel->FindElementByElement('id','created_at',$dateEtHeure);
                $result2 = $RolesModel->insert(['id_assoc' => $id_assoc,'id_user' => $maildestinataire,'role' => 'Admin']);

                if($result2){// si le deuxieme c bien passer
                  if($_SESSION['user']['id'] == $maildestinataire){
                    //si les mdofi concerne notre session on met a jour
                    $nbr = count($_SESSION['user']['roles']);//on recupere le nombre de role actuel
                    //pour ajouter un nouveau role a la suite
                    $_SESSION['user']['roles'][$nbr]['orga'] = 'Assoc';
                    $_SESSION['user']['roles'][$nbr]['id'] = $id_assoc;
                    $_SESSION['user']['roles'][$nbr]['role'] = 'Admin';
                    $_SESSION['user']['roles'][$nbr]['nom'] = '';
                    $_SESSION['user']['roles'][$nbr]['slug'] = $SlugTemporaire;
                    $_SESSION['user']['roles'][$nbr]['id_user'] = $maildestinataire;
                    $_SESSION['user']['roles'][$nbr]['id_mairie'] = $id_mairie;
                    $_SESSION['user']['roles'][$nbr]['slug_mairie'] = $slug;
                  }
                }else{
                  if($this->isAjax()){
                    return $this->showJson(['error'=>'Un problème est survenu lors de l\'attribution du rôle']);
                  }
                  $this->showErrors('Un problème est survenu lors de l\'attribution du rôle');
                }
              }else {
                if($this->isAjax()){
                  return $this->showJson(['error'=>'Un problème est survenu lors de la création'.$result]);
                }
                $this->showErrors('Un problème est survenu lors de la création'.$result);
              }

              //////////////////////////////////////////////////////////////////
              ///////////////////////     MEMBRE            ///////////////////
              /////////////////////////////////////////////////////////////////
            }elseif ($orga_demande = 'membre') {
              $MairieModel = new MairieModel;
              $AssocModel = new AssocModel;
              $AssocComplete = $AssocModel->findSlug($slug,$status=['statusA' => 'En attente','statusB' => 'Actif']);

              $id_assoc = $AssocComplete['id'];
              $slug_mairie = $MairieModel->FindElementByElement('slug','id',$AssocComplete['id_mairie']) ;

              if(!empty($RolesModel->FindRole($id_assoc,$maildestinataire))){
                //si le membre fais deja partie de lassociation on detruit la demande
                $contactModel->delete($id);
                if($this->isAjax()){
                  return $this->showJson(['redirect'=>$this->generateUrl('admin_message_assoc',['orga' => 'assoc',
                  'slug' => $AssocComplete['slug'] ,'page'=>1])]);
                }
                $this->redirectToRoute('admin_message_assoc',['orga' => 'assoc',
                'slug' => $AssocComplete['slug'] ,'page'=>1]);
              }

              $result = $RolesModel->insert(['id_assoc' => $id_assoc,'id_user' => $maildestinataire,'role' => 'User']);

              if($result){// si ca c bien passer
                if($_SESSION['user']['id'] == $maildestinataire){
                  //si les mdofi concerne notre session on met a jour
                  $nbr = count($_SESSION['user']['roles']);//on recupere le nombre de role actuel
                  //pour ajouter un nouveau role a la suite
                  $_SESSION['user']['roles'][$nbr]['orga'] = 'Assoc';
                  $_SESSION['user']['roles'][$nbr]['id'] = $id_assoc;
                  $_SESSION['user']['roles'][$nbr]['role'] = 'User';
                  $_SESSION['user']['roles'][$nbr]['nom'] = $AssocComplete['nom'];
                  $_SESSION['user']['roles'][$nbr]['slug'] = $slug;
                  $_SESSION['user']['roles'][$nbr]['id_user'] = $AssocComplete['id_user'];
                  $_SESSION['user']['roles'][$nbr]['id_mairie'] = $AssocComplete['id_mairie'];
                  $_SESSION['user']['roles'][$nbr]['slug_mairie'] = $slug_mairie;
                }
              }else{
                if($this->isAjax()){
                  return $this->showJson(['error'=>'Un problème est survenu lors de l\'attribution du rôle']);
                }
                $this->showErrors('Un problème est survenu lors de l\'attribution du rôle');
              }
            }
          }

          $GenerateDataController = new GenerateDataController;
          if($decision == 'Accepter'){
            $donnee = $GenerateDataController->generateAccept($leMessage['objet'],$maildestinataire);
          }elseif ($decision == 'Plus-Info') {
            $donnee = $GenerateDataController->generatePlusInfo($leMessage['objet'],$maildestinataire);
          }elseif ($decision == 'Refuser') {
            $donnee = $GenerateDataController->generateRefus($leMessage['objet'],$maildestinataire);
          }

          $r_POST['emeteur_pseudo'] = $pseudoEmeteur;
          $r_POST['objet'] = 'Re:'.$donnee['objet'] ;
          $r_POST['contenu'] = $donnee['contenu'];
          $r_POST['laDecision'] = $decision;

          $this->sendDecision($orgaDestinataire = $leMessage['emeteur_orga'],$orgaEmeteur = $leMessage['destinataire_orga'],
          $idDestinaire = $maildestinataire,$idEmeteur = $leMessage['destinataire_mailOrId'],
          $maildestinataire,$leMessage,$r_POST);
        }
      }else{
        if($this->isAjax()){
          return $this->showJson(['redirect'=>$this->generateUrl('racine_form')]);
        }
        $this->redirectToRoute('racine_form');
      }
    }

//systeme d'envoi
    public function sendDecision($orgaDestinataire,$orgaEmeteur,$idDestinaire,$idEmeteur,$maildestinataire,$leMessage,$r_POST)
    {
      if(isset($_SESSION['user']))
      {
          $laDecision = $r_POST['laDecision'];
          unset($r_POST['laDecision']);

          $r_POST['emeteur_mailOrId'] = $idEmeteur;
          $r_POST['destinataire_orga'] = $orgaDestinataire;
          $r_POST['destinataire_mailOrId'] = $idDestinaire;
          $r_POST['emeteur_orga'] = $orgaEmeteur;
          $r_POST['date_envoi'] = date('Y-m-d H:i:s');
          $r_POST['status'] = 'non-lu';
          //si c'est un utilisateur enregister on repon en interne
          $contactModel = new ContactModel;

          if(is_numeric($maildestinataire)){
            if($contactModel->insert($r_POST,false)){
              $contactModel->update(['status' => $laDecision,'date_lecture' => date('Y-m-d H:i:s')],$leMessage['id']);
              if($this->isAjax()){
                return $this->showJson(['redirect'=>$this->generateUrl('admin_message_'.$orgaEmeteur,['orga' => $orgaEmeteur,'slug' => $r_POST['emeteur_pseudo'] ,'page'=>1])]);
              }
              $this->redirectToRoute('admin_message_'.$orgaEmeteur,['orga' => $orgaEmeteur,'slug' => $r_POST['emeteur_pseudo'] ,'page'=>1]);
            }else{
              if($this->isAjax()){
                return $this->showJson(['error'=>'L\'envoi du message a échoué']);
              }
              $this->showErrors('L\'envoi du message a échoué');
            }
          }else{ //sinon on envoi une copi interne + le mail externe
            $r_POST['destinataire_status'] = 'del';
            $contactModel->insert($r_POST,false);

            $mail = new PHPMailer();
            $mail->CharSet = "utf8";
            //$mail->SMTPDebug = 3;                              // Enable verbose debug output
            $mail->isMail();
            $mail->setFrom('Webmaster@as-co-ma.fr', 'Mailer');
            $mail->addAddress($r_POST['destinataire_mailOrId'], 'exemple@example.com');
            $mail->addReplyTo('no-reply@as-co-ma', 'Information');
            $mail->isHTML(true);    // Set email format to HTML


            $mail->Subject = $r_POST['objet'];
            $mail->Body    = $r_POST['contenu'];
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
              if($this->isAjax()){
                return $this->showJson(['error'=>'L\'envoi du message a échoué '.$mail->ErrorInfo]);
              }
              $this->showErrors('L\'envoi du message a échoué '.$mail->ErrorInfo);
            } else {
              $contactModel->update(['status' => $laDecision,'date_lecture' => date('Y-m-d H:i:s')],$leMessage['id']);
              if($this->isAjax()){
                return $this->showJson(['redirect'=>$this->generateUrl('admin_message_'.$orgaEmeteur,['orga' => $orgaEmeteur,'slug' => $r_POST['emeteur_pseudo'] ,'page'=>1])]);
              }
              $this->redirectToRoute('admin_message_'.$orgaEmeteur,['orga' => $orgaEmeteur,'slug' => $r_POST['emeteur_pseudo'] ,'page'=>1]);
          }
        }
      }
    }

    public function analiseObject($objet)
    {
      if($objet == 'inscript_mairie'){
        return 'mairie';
      }elseif($objet == 'inscript_assoc'){
        return 'assoc';
      }elseif($objet == 'inscript_membre'){
        return 'membre';
      }
    }


}
 ?>
