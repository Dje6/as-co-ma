<?php
namespace Controller\admin ;
use \Controller\CustomController ;

// LES MESSAGES SONT RELATIVEMENT SIMILAIRE, TU PEUX LES REFORMULER COMME TU VEUX ,TU A CARTE BLANCHE,
// JE T'AI LAISSER LE HTML VOLONTAIREMENT , TU PEUX METTRE DES BALISE ECT....
// J'AI ECRIT CA VITE FAIT POUR AVOIR LIDEE DONC L'ORTHOGRAPHE C UN CARNAGE ET LA SYNTAX EST BOFF
// JE COMPTE SUR TOI! BONNE CHANCE!!

class GenerateDataController extends CustomController
{
  public function generateAccept($objet,$pseudo)
  {
    $urlConnection = $this->generateUrl('racine_form',[],true);
    $urlContact = $this->generateUrl('racine_contact',['orga' => 'All','slug' => 'All'],true);
    $urlInscription = $this->generateUrl('racine_inscriptForm',[],true);
    //
    //
    //entete et pied de page
    //
    //
    $enteteEmail = 'Bonjour, <br/><br/>';
    $enteteMessagePriver = 'Bonjour, <br/><br/>';
    $piedpageEmail = '<br/><br/>Merci de nous accorder votre confiance. A bientôt sur AS-CO-MA !<br/>
    Cet e-mail est envoyé automatiquement, merci de ne pas y répondre. Pour nous contacter, <a href="'.$urlContact.'">Cliquez ici</a>.';

    $piedpageMessagePriver = '<br/><br/>Merci de nous accorder votre confiance. A bientôt sur AS-CO-MA !<br/>
    Cet e-mail est envoyé automatiquement, merci de ne pas y répondre. Pour nous contacter, <a href="'.$urlContact.'">Cliquez ici</a>.';
    //
    //
    // Mairie
    //
    //
    if($objet == 'inscript_mairie'){//si c'est une demande d'inscritpion de mairie

      $array['objet'] = 'AS-CO-MA - Inscription de Mairie'; //Ca cera l'objet afficher dan le mail , si tu souhaite le revoir

      if(is_numeric($pseudo)){// si on accepte et la demande vien d'un membre deja inscrit

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et sommes très heureux de pouvoir vous compter parmi nos nouveaux membres !
        Nous venons par cet e-mail vous confirmer l\'acceptation de votre demande. Vous pouvez dès à présent <a href="'.$urlConnection.'">cliquez ici</a> pour vous connecter. <br/>
        Rendez-vous dans l\'onglet "Mairie" de votre l\'administration sur le site pour y trouver un lien qui vous mènera au formulaire pour compléter les informations de votre Mairie. Une fois vos informations enregistrées, un temps de modération nous sera nécessaire pour nous assurer de la validité des donnée saisies, après quoi votre Mairie sera visible sur AS-CO-MA. <br/>
        Dès que votre mairie sera en ligne, vous pourrez recevoir des demandes d\'inscriptions provenant d\'associations ou envoyer vous-mêmes ces invitations.';

      }else {//si on accepte mais que la demande vien d'un email non enregistrer
        $array['contenu'] = 'Nous serions ravis de compter votre Mairie parmi nous. Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur. Nous vous attribuerons alors les droits pour créer votre Mairie au travers d\'une nouvelle demande via l\'adresse e-mail renseignée lors de votre inscription.<br/>
        Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel. Les informations de la Mairie seront à saisir lors de l\'étape suivante.';
      }
    //
    //
    // assoc
    //
    //
  }elseif($objet == 'inscript_assoc'){//inscription d'une association

      $array['objet'] = 'AS-CO-MA - Inscrire mon Association';//objet du mail

      if(is_numeric($pseudo)){//si la demande vien d'un utilisateur

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\'Association auprès de votre Mairie et sommes très heureux de pouvoir vous compter parmi nous.<br/>
        Nous venons par cet e-mail vous confirmer l\'acceptation de votre demande. Vous pouvez dès à présent <a href="'.$urlConnection.'">cliquez ici</a> afin de vous connecter.<br/>
        Rendez-vous dans votre onglet d\'administration, rubrique "Association". Vous y trouverez un lien pour remplir les informations de votre Association. Une fois vos informations enregistrées, un temps de modération nous sera nécessaire afin de nous assurer de la validité des données saisies. Votre association sera alors visible sur AS-CO-MA et vous pourrez ainsi recevoir des demandes d\'inscription de membres ou envoyer vous-mêmes ces invitations.';

      }else {//sinon on dit ok mais inscrivez vous

        $array['contenu'] = 'Nous serions ravis d\'enregistrer votre Association auprès de votre Mairie. Pour cela, rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur. Nous vous attribuerons alors les droits pour créer votre Association au travers d\'une nouvelle demande via l\'adresse e-mail renseignée lors de votre inscription.<br/>
        Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel. Les informations de l\'Association seront à saisir lors de l\'étape suivante.';
      }
    //
    //
    // MEMBRE
    //
    //
  }elseif($objet == 'inscript_membre'){//demande pour devenir membre

      $array['objet'] = 'AS-CO-MA - Devenir membre de l\'Association';//objet du mail

      if(is_numeric($pseudo)){//si c'est un utilisateur du site

        $array['contenu'] = 'Nous avons bien reçu votre demande pour devenir membre de cette Association et sommes très heureux de pouvoir vous compter parmi nous. Nous venons par cet e-mail vous confirmer l\'acceptation de votre demande.<br/>
        Vous faites dès à présent partie de l\'Association en tant qu\'utilisateur. Vous pouvez nous contacter par message privé au travers de votre espace personnel et vous recevrez les informations désirées via l\'adresse e-mail reseignée lors de votre inscription.';

      }else {//si il ne fais pas parti du site

        $array['contenu'] = 'Nous serions ravis de vous compter parmi les membres de cette Association.<br/>
        Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur. Nous vous attribuerons alors les droits d\'accès à votre Association au travers d\'une nouvelle demande via l\'adresse e-mail renseignée lors de votre inscription.';
      }

    }
    //on concataine l'entete le contenu et le pied de page selon si c'est un message priver ou un mail
    if(is_numeric($pseudo)){
      $array['contenu'] = $enteteMessagePriver.$array['contenu'].$piedpageMessagePriver;
    }else {
      $array['contenu'] = $enteteEmail.$array['contenu'].$piedpageEmail;
    }
    //puis on renvoi le tout!
    return $array;
  }


//a partir de la c'est pas fait , pour le moment n'y touche pas ^^ merci x)
/////////////////////////////
//   OK pas touché (Benoît)

  public function generatePlusInfo($objet,$pseudo)
  {
    $entete = 'Bonjour<br/><br/>';
    $piedpage = '<br/><br/>Merci pour votre confiance, a biento';

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
      $array['contenu'] = $entete.$array['contenu'].$piedpage;
    return $array;
  }

  public function generateRefus($objet,$pseudo)
  {
    $entete = 'Bonjour<br/><br/>';
    $piedpage = '<br/><br/>Merci pour votre confiance, a biento';

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
      $array['contenu'] = $entete.$array['contenu'].$piedpage;
    return $array;
  }
}
