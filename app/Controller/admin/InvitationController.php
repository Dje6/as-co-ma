<?php
namespace Controller\admin ;
use \Model\AssocModel;
use \Model\MairieModel;
use \Model\ContactModel;
use \Model\RolesModel;
use \Model\UserModel;
use \Controller\CustomController;
use \Service\ValidationTools;
use \PHPMailer;
/**
 *
 */
class InvitationController extends CustomController
{
    public function decision($id,$decision)
    {
      if(isset($_SESSION['user']))
      {
          $contactModel = new ContactModel;
          $leMessage = $contactModel->FindMessageById($id);
          $RolesModel = new RolesModel;

          $AssocModel = new AssocModel;
          $slug = $AssocModel->FindElementByElement('slug','id',$leMessage['emeteur_mailOrId']);
          $AssocComplete = $AssocModel->findSlug($slug,$status=['statusA' => 'En attente','statusB' => 'Actif']);
          $id_assoc = $AssocComplete['id'];

          if(!empty($RolesModel->FindRole($id_assoc,$_SESSION['user']['id']))){
            //si on fais deja partie de lassociation on detruit la demande
            $contactModel->delete($id);
            if($this->isAjax()){
              return $this->showJson(['redirect'=>$this->generateUrl('admin_message',['page'=>1])]);
            }
            $this->redirectToRoute('admin_message',['page'=>1]);
          }

          if($decision == 'Accepter'){
            $MairieModel = new MairieModel;

            $slug_mairie = $MairieModel->FindElementByElement('slug','id',$AssocComplete['id_mairie']) ;

            $result = $RolesModel->insert(['id_assoc' => $id_assoc,'id_user' => $_SESSION['user']['id'],'role' => 'User']);

            if($result){// si ca c bien passer
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

              $contactModel->update(['status'=>'Accepter','date_lecture'=>date('Y-m-d H:i:s')],$id);

            }else{
              $this->showErrors('Un problème est survenu lors de l\'attribution du rôle');
            }
          }elseif ($decision == 'Refuser') {
              $contactModel->update(['status'=>'Refuser','date_lecture'=>date('Y-m-d H:i:s')],$id);
          }
          if($this->isAjax()){
            return $this->showJson(['redirect'=>$this->generateUrl('admin_message',['page'=>1])]);
          }
        $this->redirectToRoute('admin_message',['page'=>1]);
        }
    }

    //on envoi une invitation
    public function invitMembre($slug)
    {
      if(isset($_SESSION['user']))
      {
        if($this->allowToTwo('Admin','Assoc',$slug)){

          $donnee = $this->listing('Assoc',$slug);

          if($_POST){
            $r_POST = $this->nettoyage($_POST);
            $error['mail'] = ValidationTools::emailValid($r_POST['mail']);

            $assocModel = new AssocModel;
            $nom_assoc = $assocModel->FindElementByElement('nom','slug',$slug);
            $id_assoc = $assocModel->FindElementByElement('id','slug',$slug);

            if(ValidationTools::IsValid($error)){
              if(!is_numeric($r_POST['mail'])){ //si c'est ce n'est pas id on verifie si eventuelemt il le mail
                //exist en base en base de donnee
                $UserModel = new UserModel;
                $contactModel = new ContactModel;

                if($UserModel->emailExists($r_POST['mail'])){ //si oui on recupere l'id
                  $r_POST['mail'] = $UserModel->FindElementByElement('id','mail',$r_POST['mail']);
                  $r_POST['destinataire_orga'] = 'users';
                  $RolesModel = new RolesModel;
                  $roleRetourner = $RolesModel->FindRole($id_assoc,$r_POST['mail']);

                  if(!empty($roleRetourner)){

                    $confirmation ='Cet utilisateur fait déjà partie de l\'Association';
                    $this->show('admin/liste',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee,
                    'page'=>1,'confirmation'=>$confirmation]);

                  }

                }else {
                  $r_POST['destinataire_orga'] = 'public';
                  $r_POST['destinataire_status'] = 'del';
                }

                $invitation = $contactModel->findInvitation($r_POST['mail'],$id_assoc);
                if(!empty($invitation)){
                  $confirmation ='Une invitation a déjà été envoyée à cette personne';
                  $this->show('admin/liste',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee,
                  'page'=>1,'confirmation'=>$confirmation]);
                }

                if($contactModel->findDemande($r_POST['mail'],$id_assoc)){
                  $confirmation ='Une demande pour rejoindre l\'Association a déjà faite par ce membre, merci de consulter les messages reçus de l\'Association pour pouvoir y répondre';

                  $this->show('admin/liste',['slug' => $slug,'orga' => 'assoc','donnee' => $donnee,
                  'page'=>1,'confirmation'=>$confirmation]);
                }
              }

              unset($r_POST['submit']);

              $r_POST['emeteur_pseudo'] = $nom_assoc;
              $r_POST['objet'] = 'Invitation a rejoindre '.$nom_assoc ;
              $r_POST['emeteur_mailOrId'] = $id_assoc;
              $r_POST['destinataire_mailOrId'] = $r_POST['mail'];
              $r_POST['emeteur_orga'] = 'assoc';
              $r_POST['date_envoi'] = date('Y-m-d H:i:s');
              $r_POST['status'] = 'non-lu';
              $ok = false;


              if(is_numeric($r_POST['mail'])){
                //on envoi en interne une invite

                unset($r_POST['mail']);

                $r_POST['contenu'] = 'Bonjour,<br/>
                Nous serions très heureux de pouvoir vous compter parmi nous et vous invitons donc à rejoindre notre Association ! Pour en savoir plus sur nos activités n\'hésitez pas à visiter <a href="'.$this->generateUrl('racine_assoc',['orga'=>'assoc','slug'=>$slug],true).'">notre page</a> !<br/>
                A bientôt !';

                if($contactModel->insert($r_POST,false)){
                  $ok = true;
                }
              }else {
                unset($r_POST['mail']);


                $r_POST['contenu'] = 'Bonjour, <br/>
                Nous serions très heureux de pouvoir vous compter parmi nous ! Pour en savoir plus sur nos activités n\'hésitez pas à visiter <a href="'.$this->generateUrl('racine_assoc',['orga'=>'assoc','slug'=>$slug],true).'">notre page</a> !<br/>
                Cependant, vous devez au préalable être inscrit sur le site.<br/>
                <a href="'.$this->generateUrl('racine_inscriptForm',[],true).'">Cliquez ici</a> pour vous inscrire et devenir aussitôt un de nos membres !<br/>
                A bientôt !';

                $contactModel = new ContactModel;
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
                if($mail->send()) {
                  $ok = true;
                }
              }
              if($ok){
                $confirmation = 'L\'invitation a bien été envoyée';
              }else {
                $confirmation = 'L\'invitation n\'a pas pu être envoyée suite à un problème technique';
              }
              $this->show('admin/liste',['slug' => $slug,'orga' => 'assoc',
              'page'=>1,'donnee' => $donnee,'confirmation'=>$confirmation]);
            }else {
              $this->show('admin/liste',['slug' => $slug,'orga' => 'assoc',
              'page'=>1,'donnee' => $donnee,'error'=>$error]);
            }

          }else {

            $error['mail']= 'Merci de saisir un mail';
            $this->show('admin/liste',['slug' => $slug,'orga' => 'assoc',
            'page'=>1,'donnee' => $donnee,'error'=>$error]);

          }

        }
      }else{
        $this->redirectToRoute('racine_form');
      }
    }




}
 ?>
