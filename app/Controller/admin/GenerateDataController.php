<?php
namespace Controller\admin ;
use \Controller\CustomController ;

class GenerateDataController extends CustomController
{

  ///////////////////////////////////////////////////////////////////////////////////////////////
  //ACCEPTER LA DEMANDE RECUE
  ///////////////////////////////////////////////////////////////////////////////////////////////
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

    $piedpageMessagePriver = '<br/><br/>Merci de nous accorder votre confiance. A bientôt sur AS-CO-MA !';
    //
    //
    // Mairie
    //
    //
    if($objet == 'inscript_mairie'){//si c'est une demande d'inscritpion de mairie

      $array['objet'] = 'AS-CO-MA - Inscription de Mairie'; //Ca cera l'objet afficher dan le mail , si tu souhaite le revoir

      if(is_numeric($pseudo)){// si on accepte et la demande vien d'un membre deja inscrit

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et sommes très heureux de pouvoir vous compter parmi nous.<br/>
        Nous venons par cet e-mail vous confirmer l\'acceptation de votre demande. Vous pouvez dès à présent
        <a href="'.$urlConnection.'">cliquez ici</a> pour vous connecter. <br/>
        Rendez-vous dans l\'onglet "Mairie" de votre administration sur le site pour y trouver un lien qui vous mènera au formulaire pour compléter les informations de votre Mairie. Une fois vos informations enregistrées, un temps de modération nous sera nécessaire pour nous assurer de la validité des donnée saisies, après quoi votre Mairie sera visible sur AS-CO-MA. <br/>
        Dès que votre mairie sera en ligne, vous pourrez recevoir des demandes d\'inscriptions provenant d\'associations ou en envoyer vous-même.';

      }else {//si on accepte mais que la demande vien d'un email non enregistrer
        $array['contenu'] = 'Nous serions ravis de compter votre Mairie parmi nous. Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur du site. Nous vous attribuerons alors les droits pour créer votre Mairie au travers d\'une nouvelle demande via l\'adresse e-mail renseignée lors de votre inscription.<br/>
        Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel. Les informations de la Mairie seront à saisir lors de l\'étape suivante.';
      }
    //
    //
    // assoc
    //
    //
  }elseif($objet == 'inscript_assoc'){//inscription d'une association

      $array['objet'] = 'AS-CO-MA - Inscription d\'Association';//objet du mail

      if(is_numeric($pseudo)){//si la demande vien d'un utilisateur

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\'Association auprès de cette Mairie et sommes très heureux de pouvoir vous compter parmi nous.<br/>
        Nous venons par cet e-mail vous confirmer l\'acceptation de votre demande. Vous pouvez dès à présent <a href="'.$urlConnection.'">cliquez ici</a> afin de vous connecter.<br/>
        Rendez-vous dans votre onglet d\'administration, rubrique "Association". Vous y trouverez un lien pour remplir les informations de votre Association. Une fois vos informations enregistrées, un temps de modération nous sera nécessaire afin de nous assurer de la validité des données saisies. Votre Association sera alors visible sur AS-CO-MA et vous pourrez ainsi recevoir des demandes d\'inscription de membres ou en envoyer vous-même.';

      }else {//sinon on dit ok mais inscrivez vous

        $array['contenu'] = 'Nous serions ravis d\'enregistrer votre Association auprès de cette Mairie. Pour cela, rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur du site. Nous vous attribuerons alors les droits pour créer votre Association au travers d\'une nouvelle demande via l\'adresse e-mail renseignée lors de votre inscription.<br/>
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
        Vous faites dès à présent partie de l\'Association en tant qu\'utilisateur. Vous pouvez utiliser le formulaire de contact mis à disposition dans votre espace personnel et vous recevrez les informations désirées via l\'adresse e-mail reseignée lors de votre inscription.';

      }else {//si il ne fais pas parti du site

        $array['contenu'] = 'Nous serions ravis de vous compter parmi les membres de cette Association.<br/>
        Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur du site. Nous vous attribuerons alors les droits d\'accès à votre Association au travers d\'une nouvelle demande via l\'adresse e-mail renseignée lors de votre inscription.';
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


///////////////////////////////////////////////////////////////////////////////////////////
  // DEMANDER PLUS D'INFOS A LA DEMANDE RECUE
  /////////////////////////////////////////////////////////////////////////////////////
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

    $piedpageMessagePriver = '<br/><br/>Merci de nous accorder votre confiance. A bientôt sur AS-CO-MA !';//en message priver il peu nous repondre ^^
    //
    //
    // Mairie
    //
    //
  if($objet == 'inscript_mairie'){//si c'est une demande d'inscritpion de mairie

    $array['objet'] = 'AS-CO-MA - Inscription de Mairie'; //Ca cera l'objet afficher dan le mail , si tu souhaite le revoir

    if(is_numeric($pseudo)){// si on accepte et la demande vien d'un membre deja inscrit

      $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et sommes très heureux de pouvoir vous compter parmi nous. <br/>
      Nous ne pouvons cependant pas accepter votre demande en l\'état. Nous souhaiterions avoir plus d\'informations au sujet de votre Mairie ainsi que sur vous-même. <br/>
      Les informations utile sont notamment : <br/>
      - Votre rôle au sein de la Mairie, <br/>
      - Le nom de votre Commune, <br/>
      - Le numéro de téléphone de la Mairie. <br/>
      Ces informations nous sont nécessaires pour des raisons de sécurité et pour nous assurer de la légitimité de votre demande. <br/>
      Rendez-vous sur notre <a href="'.$urlContact.'">formulaire de contact</a> afin de soumettre une demande plus complète.';

    }else {//si on accepte mais que la demande vien d'un email non enregistrer
      $array['contenu'] = 'Nous serions ravis de compter votre Mairie parmi nous. Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur du site.<br/>
      Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel. Les informations de la Mairie seront à saisir lors de l\'étape suivante. <br/><br/>

      Une fois votre compte créé, rendez-vous de nouveau sur notre <a href="'.$urlContact.'">formulaire de contact</a> afin de soumettre une demande plus complète, car nous manquons actuellement d\'informations.<br/>
      Les informations utiles sont notamment :<br/>
      - Votre NOM et Prénom, <br/>
      - Votre rôle au sein de la Mairie, <br/>
      - Le nom de votre Commune, <br/>
      - Le numéro de téléphone de votre Mairie.<br/>
      Ces informations nous sont nécessaires pour des raisons de sécurité et pour nous assurer de la légitimité de votre demande. <br/>';
    }
    //
    //
    // assoc
    //
    //
  }elseif($objet == 'inscript_assoc'){//inscription d'une association

      $array['objet'] = 'AS-CO-MA - Inscription d\'Association';//objet du mail

      if(is_numeric($pseudo)){//si la demande vien d'un utilisateur

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\'Association auprès de cette Mairie et sommes très heureux de pouvoir vous compter parmi nous.<br/>
        Nous ne pouvons cependant pas accepter votre demande en l\'état. Nous souhaiterions avoir plus d\'informations au sujet de votre Association ainsi que sur vous-même.<br/>
        Les informations utiles sont notamment : <br/>
        - Le nom de votre Association, <br/>
        - Une description de votre activité, <br/>
        - Votre rôle au sein de l\'Associtation, <br/>
        - Une estimation du nombre de membres attendus.<br/>
        Ces informations nous sont nécessaires pour des raisons de sécurité et pour nous assurer de la légitimité de votre demande. Rendez-vous sur notre <a href="'.$urlContact.'">formulaire de contact</a> afin de nous soumettre une demande plus complète.';

      }else {//sinon on dit ok mais inscrivez vous

        $array['contenu'] = 'Nous serions très heureux de pouvoir vous compter parmi nous. Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur du site.<br/>
        Il est important d\'utiliser votre e-mail personnel ! Votre compte sera personnel. Les informations de l\'Association seront à saisir lors de l\'étape suivante.<br/>

        Nous ne pouvons cependant pas accepter votre demande d\'inscription en l\'état. Nous souhaiterions avoir plus d\'informations au sujet de votre Association ainsi que sur vous-même.<br/>
        Les informations utiles sont notamment : <br/>
        - Le nom de votre Association, <br/>
        - Une description de votre activité, <br/>
        - Votre rôle au sein de l\'Associtation, <br/>
        - Une estimation du nombre de membres attendus.<br/>
        Ces informations nous sont nécessaires pour des raisons de sécurité et pour nous assurer de la légitimité de votre demande. Rendez-vous sur notre <a href="'.$urlContact.'">formulaire de contact</a> afin de nous soumettre une demande plus complète.';
      }
    //
    //
    // MEMBRE
    //
    //
  }elseif($objet == 'inscript_membre'){//demande pour devenir membre

      $array['objet'] = 'AS-CO-MA - Devenir membre de l\'Association';//objet du mail

      if(is_numeric($pseudo)){//si c'est un utilisateur du site

        $array['contenu'] = 'Nous avons bien reçu votre demande pour devenir membre de cette Association et sommes très heureux de pouvoir vous compter parmi nous.<br/>
        Nous ne pouvons cependant pas accepter votre demande en l\'état. Nous souhaiterions avoir plus d\'informations à votre sujet.<br/>
        Nous vous invitons donc à soumettre une nouvelle demande en décrivant les motivations qui vous poussent à vouloir faire partie de cette communauté.';

      }else {//si il ne fais pas parti du site

        $array['contenu'] = 'Nous serions ravis de vous compter parmi les membres de cette Association. Pour cela rendez-vous <a href="'.$urlInscription.'">à cette adresse</a> afin de vous inscrire comme utilisateur du site.<br/>
        Nous ne pouvons cependant pas accepter votre demande en l\'état. Nous souhaiterions avoir plus d\'informations à votre sujet.<br/>
        Nous vous invitons donc à soumettre une nouvelle demande en décrivant les motivations qui vous poussent à vouloir faire partie de cette communauté.<br/>
        Apres acceptation, nous vous attribuerons les droits d\'accès à cette Association au travers d\'une nouvelle demande via l\'adresse e-mail renseignée lors de votre inscription.';
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


  ///////////////////////////////////////////////////////////////////////////////////////////
    // REFUS DE LA DEMANDE RECUE
    /////////////////////////////////////////////////////////////////////////////////////
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

    $piedpageMessagePriver = '<br/><br/>Merci de nous accorder votre confiance. A bientôt sur AS-CO-MA !';//en message priver il peu nous repondre ^^
    //
    //
    // Mairie
    //
    //
  if($objet == 'inscript_mairie'){//si c'est une demande d'inscritpion de mairie

    $array['objet'] = 'AS-CO-MA - Inscription de Mairie'; //Ca cera l'objet afficher dan le mail , si tu souhaite le revoir

    if(is_numeric($pseudo)){// si on accepte et la demande vien d'un membre deja inscrit

      $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et sommes au regret de ne pas pouvoir donner suite à votre demande.<br/>
      Vous pourrez, si vous le souhaitez, effectuer ultérieurement une nouvelle demande via notre <a href="'.$urlContact.'">formulaire de contact</a>.';

    }else {//si on accepte mais que la demande vien d'un email non enregistrer
      $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription de Mairie et sommes au regret de ne pas pouvoir donner suite à votre demande.<br/>
      Vous pourrez, si vous le souhaitez, effectuer une nouvelle demande via notre <a href="'.$urlContact.'">formulaire de contact</a> après vous être inscrit sur notre site <a href="'.$urlInscription.'">à cette adresse</a>.';
    }
    //
    //
    // assoc
    //
    //
  }elseif($objet == 'inscript_assoc'){//inscription d'une association

      $array['objet'] = 'AS-CO-MA - Inscription d\'Association';//objet du mail

      if(is_numeric($pseudo)){//si la demande vien d'un utilisateur

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\'Association auprès de cette Mairie et sommes au regret de ne pas pouvoir donner suite à votre demande.<br/>
        Vous pourrez, si vous le souhaitez, effectuer ultérieurement une nouvelle demande via notre <a href="'.$urlContact.'">formulaire de contact</a>.';

      }else {//sinon on dit ok mais inscrivez vous

        $array['contenu'] = 'Nous avons bien reçu votre demande d\'inscription d\'Association et sommes au regret de ne pas pouvoir donner suite à votre demande.<br/>
        Vous pourrez, si vous le souhaitez, effectuer une nouvelle demande via notre <a href="'.$urlContact.'">formulaire de contact</a> après vous être inscrit sur le site <a href="'.$urlInscription.'">à cette adresse</a>.';
      }
    //
    //
    // MEMBRE
    //
    //
  }elseif($objet == 'inscript_membre'){//demande pour devenir membre

      $array['objet'] = 'AS-CO-MA - Devenir membre de l\'Association';//objet du mail

      if(is_numeric($pseudo)){//si c'est un utilisateur du site

        $array['contenu'] = 'Nous avons bien reçu votre demande pour devenir membre de cette Association et
        sommes au regret de ne pas pouvoir donner suite à votre demande.<br/>
        Vous pourrez, si vous le souhaitez, effectuer ultérieurement une nouvelle demande via notre <a href="'.$urlContact.'">formulaire de contact</a>.';

      }else {//si il ne fais pas parti du site

        $array['contenu'] = 'Nous avons bien reçu votre demande pour devenir membre de cette Association et
        sommes au regret de ne pas pouvoir donner suite à votre demande.<br/>
        Vous pourrez, si vous le souhaitez, effectuer une nouvelle demande via notre <a href="'.$urlContact.'">formulaire de contact</a> après vous être inscrit sur le site <a href="'.$urlInscription.'">à cette adresse</a>.';
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
