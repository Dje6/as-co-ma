<?php
namespace Controller\admin ;
use \Controller\CustomController ;

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

    $piedpageMessagePriver = '<br/><br/>Merci de nous accorder votre confiance.';
    //
    //
    // Mairie
    //
    //
    if($objet == 'inscript_mairie'){//si c'est une demande d'inscritpion de mairie

      $array['objet'] = 'AS-CO-MA - Inscription de Mairie'; //Ca cera l'objet afficher dan le mail , si tu souhaite le revoir

      if(is_numeric($pseudo)){// si on accepte et la demande vien d'un membre deja inscrit

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et sommes très heureux de pouvoir
        vous compter parmi nos nouveaux membres !
        Nous venons par cet e-mail vous confirmer l\'acceptation de votre demande. Vous pouvez dès à présent
        <a href="'.$urlConnection.'">cliquez ici</a> pour vous connecter. <br/>
        Rendez-vous dans l\'onglet "Mairie" de votre l\'administration sur le site pour y trouver un lien qui vous
         mènera au formulaire pour compléter les informations de votre Mairie.
        Une fois vos informations enregistrées, un temps de modération nous sera nécessaire pour nous assurer
        de la validité des donnée saisies, après quoi votre Mairie sera visible sur AS-CO-MA. <br/>
        Dès que votre mairie sera en ligne, vous pourrez recevoir des demandes d\'inscriptions provenant
        d\'associations ou envoyer vous-mêmes ces invitations.';

      }else {//si on accepte mais que la demande vien d'un email non enregistrer
        $array['contenu'] = 'Nous serions ravis de compter votre Mairie parmi nous.
        Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous
        inscrire comme utilisateur. Nous vous attribuerons alors les droits pour créer votre
         Mairie au travers d\'une nouvelle demande via l\'adresse e-mail renseignée lors de votre inscription.<br/>
        Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel.
        Les informations de la Mairie seront à saisir lors de l\'étape suivante.';
      }
    //
    //
    // assoc
    //
    //
  }elseif($objet == 'inscript_assoc'){//inscription d'une association

      $array['objet'] = 'AS-CO-MA - Inscrire mon Association';//objet du mail

      if(is_numeric($pseudo)){//si la demande vien d'un utilisateur

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\'Association
        auprès de notre Mairie et sommes très heureux de pouvoir vous compter parmi nous.<br/>
        Nous venons par cet e-mail vous confirmer l\'acceptation de votre demande. Vous
        pouvez dès à présent <a href="'.$urlConnection.'">cliquez ici</a> afin de vous connecter.<br/>
        Rendez-vous dans votre onglet d\'administration, rubrique "Association". Vous y
        trouverez un lien pour remplir les informations de votre Association. Une fois vos
        informations enregistrées, un temps de modération nous sera nécessaire afin de nous
        assurer de la validité des données saisies. Votre association sera alors visible
        sur AS-CO-MA et vous pourrez ainsi recevoir des demandes d\'inscription de membres
         ou envoyer vous-mêmes ces invitations.';

      }else {//sinon on dit ok mais inscrivez vous

        $array['contenu'] = 'Nous serions ravis d\'enregistrer votre Association auprès de
        votre Mairie. Pour cela, rendez-vous <a href="'.$urlInscription.'">à cette adresse</a>
         afin de vous inscrire comme utilisateur. Nous vous attribuerons alors les droits pour
          créer votre Association au travers d\'une nouvelle demande via l\'adresse e-mail
           renseignée lors de votre inscription.<br/>
        Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel.
         Les informations de l\'Association seront à saisir lors de l\'étape suivante.';
      }
    //
    //
    // MEMBRE
    //
    //
  }elseif($objet == 'inscript_membre'){//demande pour devenir membre

      $array['objet'] = 'AS-CO-MA - Devenir membre de l\'Association';//objet du mail

      if(is_numeric($pseudo)){//si c'est un utilisateur du site

        $array['contenu'] = 'Nous avons bien reçu votre demande pour devenir membre
         de notre Association et sommes très heureux de pouvoir vous compter parmi
         nous. Nous venons par cet e-mail vous confirmer l\'acceptation de votre demande.<br/>
        Vous faites dès à présent partie de l\'Association en tant qu\'utilisateur.
        Vous pouvez nous contacter par message privé au travers de votre espace
        personnel et vous recevrez les informations désirées via l\'adresse e-mail
         reseignée lors de votre inscription.';

      }else {//si il ne fais pas parti du site

        $array['contenu'] = 'Nous serions ravis de vous compter parmi les membres de notre Association.<br/>
        Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a>
        afin de vous inscrire comme utilisateur. Nous vous attribuerons alors les
        droits d\'accès à votre Association au travers d\'une nouvelle demande via
         l\'adresse e-mail renseignée lors de votre inscription.';
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


  public function generatePlusInfo($objet,$pseudo)
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

    $piedpageMessagePriver = '<br/><br/>Merci de nous accorder votre confiance.';//en message priver il peu nous repondre ^^
    //
    //
    // Mairie
    //
    //
  if($objet == 'inscript_mairie'){//si c'est une demande d'inscritpion de mairie

    $array['objet'] = 'AS-CO-MA - Inscription de Mairie'; //Ca cera l'objet afficher dan le mail , si tu souhaite le revoir

    if(is_numeric($pseudo)){// si on accepte et la demande vien d'un membre deja inscrit

      $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et nous serion très heureux de pouvoir
      vous compter parmi nos nouveaux membres !
      Nous ne pouvons cependant pas accepter votre demande en l\'etat. Nous souhaiterion plus d\'information sur votre mairie
      ainsi que sur vous meme. <br/>
      Les information utile sont :<br/>
      votre role a la mairie<br/>
      La commune de la mairie<br/>
      Le numeros de telephone de la mairie<br/>
      C\'est information nous sont nessessaire pour des raison de securiter et pour nous assurer
      de la legitimiter de votre demande
      Rendez-vous sur notre <a href="'.$urlContact.'">formulaire de contact</a> afin
      de nous soumettre une nouvelle demande.';

    }else {//si on accepte mais que la demande vien d'un email non enregistrer
      $array['contenu'] = 'Nous serions ravis de compter votre Mairie parmi nous.
      Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur.<br/>
      Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel.
      Les informations de la Mairie seront à saisir lors de l\'étape suivante.

      Une fois votre compte creer, rendez vous de nouveau sur notre <a href="'.$urlContact.'">formulaire de contact</a>
      afin de nous refaire une demande plus complete, car nous manquon actuelemen d\'information<br/>
      Les information utile sont :<br/>
      Votre nom et prenom<br/>
      votre role a la mairie<br/>
      La commune de la mairie<br/>
      Le numeros de telephone de la mairie<br/>
      C\'est information nous sont nessessaire pour des raison de securiter et pour nous assurer
      de la legitimiter de votre demande<br/>';
    }
    //
    //
    // assoc
    //
    //
  }elseif($objet == 'inscript_assoc'){//inscription d'une association

      $array['objet'] = 'AS-CO-MA - Inscrire mon Association';//objet du mail

      if(is_numeric($pseudo)){//si la demande vien d'un utilisateur

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\'Association auprès de notre Mairie et
        serions très heureux de pouvoir vous compter parmi nous.<br/>
        Malheureusement nous manquon d\information sur votre association pour pouvoir accepter actuelement<br/>
        Les information utlil sont <br/>
        Le nom de votre association<br/>
        Une description explicativ <br/>
        Une estimation du nombre de membre actuel ou futur estimer<br/>
        Rendez-vous sur notre formulaire de contact afin
        de nous soumettre une nouvelle demande.';

      }else {//sinon on dit ok mais inscrivez vous

        $array['contenu'] = 'Nous serions très heureux de pouvoir vous compter parmi nous.<br/>
        Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur.<br/>
        Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel.
        Les informations de l\association seront à saisir lors de l\'étape suivante.

        Et nous manquon actuelement d\information sur votre association pour pouvoir accepter votre demande<br/>
        Les information utile sont :<br/>
        Le nom de votre association<br/>
        Une description explicativ <br/>
        Une estimation du nombre de membre actuel ou futur estimer<br/>
        C\'est information nous sont nessessaire pour savoir si votre association correspond au bon esprit commun de notre ville';
      }
    //
    //
    // MEMBRE
    //
    //
  }elseif($objet == 'inscript_membre'){//demande pour devenir membre

      $array['objet'] = 'AS-CO-MA - Devenir membre de l\'Association';//objet du mail

      if(is_numeric($pseudo)){//si c'est un utilisateur du site

        $array['contenu'] = 'Nous avons bien reçu votre demande pour devenir membre de notre Association et
        serion très heureux de pouvoir vous compter parmi nous.
        cependant nous manquons d\'information pour pouvoir accepter votre demande en l\'etat.
        Je vous invite donc a nous refaire une nouvelle demande sur notre
         en devrivant vos motivations
        et dans quel but souhaiter vous faire partie de notre communauté.';

      }else {//si il ne fais pas parti du site

        $array['contenu'] = 'Nous serions ravis de vous compter parmi les membres de cette Association.<br/>
        Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur.
        Nous manquon d\'information pour pouvoir accepter votre demande en l\'etat.
        Je vous invite donc a nous refaire une demande une fois inscrit en devrivant vos motivations
        et dans quel but souhaiter vous faire partie de notre communauté.
        Apres acceptation nous vous attribuerons alors les droits d\'accès à notre Association au travers d\'une nouvelle
        demande via l\'adresse e-mail renseignée lors de votre inscription.';
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


// on refuse
  public function generateRefus($objet,$pseudo)
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

    $piedpageMessagePriver = '<br/><br/>Merci de nous accorder votre confiance.';//en message priver il peu nous repondre ^^
    //
    //
    // Mairie
    //
    //
  if($objet == 'inscript_mairie'){//si c'est une demande d'inscritpion de mairie

    $array['objet'] = 'AS-CO-MA - Inscription de Mairie'; //Ca cera l'objet afficher dan le mail , si tu souhaite le revoir

    if(is_numeric($pseudo)){// si on accepte et la demande vien d'un membre deja inscrit

      $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et somme
      desoler de ne pas pouvoir donnee suite a cette derniere.
      Vous pourez si vous le souhaiter nous reformuler une demande ulterieurement
      via notre <a href="'.$urlContact.'">formulaire de contact</a> .';

    }else {//si on accepte mais que la demande vien d'un email non enregistrer
      $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et somme
      desoler de ne pas pouvoir donnee suite a cette derniere.
      Vous pourez si vous le souhaiter nous reformuler une demande ulterieurement
      via notre <a href="'.$urlContact.'">formulaire de contact</a> apres vous etes inscrit sur notre
      site a <a href="'.$urlInscription.'">à cette adresse</a> afin de pouvoir donnee suite a votre prochaine
      demande si nous le pouvons .';
    }
    //
    //
    // assoc
    //
    //
  }elseif($objet == 'inscript_assoc'){//inscription d'une association

      $array['objet'] = 'AS-CO-MA - Inscrire mon Association';//objet du mail

      if(is_numeric($pseudo)){//si la demande vien d'un utilisateur

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\'Association auprès de notre Mairie et
        somme desoler de ne pas pouvoir donnee suite a cette derniere.<br/>
        Vous pourez si vous le souhaiter nous reformuler une demande ulterieurement
        via notre formulaire de contact .';

      }else {//sinon on dit ok mais inscrivez vous

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\association et somme
        desoler de ne pas pouvoir donnee suite a cette derniere.
        Vous pourez si vous le souhaiter nous reformuler une demande ulterieurement
        via notre formulaire de contact apres vous etes inscrit sur le
        site a <a href="'.$urlInscription.'">à cette adresse</a> afin de pouvoir donnee suite a votre prochaine
        demande si nous le pouvons .';
      }
    //
    //
    // MEMBRE
    //
    //
  }elseif($objet == 'inscript_membre'){//demande pour devenir membre

      $array['objet'] = 'AS-CO-MA - Devenir membre de l\'Association';//objet du mail

      if(is_numeric($pseudo)){//si c'est un utilisateur du site

        $array['contenu'] = 'Nous avons bien reçu votre demande pour devenir membre de notre Association et
        somme desoler de ne pouvoir donnee suite a cette derniere.
        Vous pourez si vous le souhaiter nous reformuler une demande ulterieurement
        via notre formulaire de contact';

      }else {//si il ne fais pas parti du site

        $array['contenu'] = 'Nous avons bien reçu votre demande pour devenir membre de notre Association et
        somme desoler de ne pouvoir donnee suite a cette derniere.
        Vous pourez si vous le souhaiter nous reformuler une demande ulterieurement
        via notre formulaire de contact apres vous etes inscrit sur le
        site a <a href="'.$urlInscription.'">à cette adresse</a> afin que nous puission donnee suite a votre prochaine
        demande si nous le pouvons .';
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
}
