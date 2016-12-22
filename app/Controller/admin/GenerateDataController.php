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
    $entete = 'Bonjour<br/><br/>';
    $piedpage = '<br/><br/>Merci pour votre confiance, a biento<br/> Merci de ne pas repondre a cette email
    pour nous contacter <a href="'.$urlContact.'">cliquez ici</a>';
    //
    //
    // Mairie
    //
    //
    if($objet == 'inscript_mairie'){//si c'est une demande d'inscritpion de mairie

      $array['objet'] = 'Inscrire ma Mairie'; //Ca cera l'objet afficher dan le mail , si tu souhaite le revoir

      if(is_numeric($pseudo)){// si on accepte et la demande vien d'un membre deja inscrit

        $array['contenu'] = 'Nous avons bien recu votre demande pour inscrire votre mairie
        sur notre site et nous somme tres heureux de pouvoir vous compter parmi nos nouveaux abonnees
        Nous venons par ce mail vous confirmer l\'acceptation de votre demande , vous pouvez des a present
        <a href="'.$urlConnection.'">cliquez ici</a> afin de vous connecter
        Rendez vous sur l\'onglet mairie, vous y trouverai a present un lien pour votre mairie qui
        vous menera au formulaire pour completer les information
        Une fois vos information enregistrer, un temp de moderation nous sera nessessaire afin de nous assurer
        de la bonne qualiter des donnee saisi , apres quoi votre mairie sera visible sur notre site ,
        vous pouvez dés lors que votre mairie est en ligne recevoir des demande d\association ou envoyer des invitation';

      }else {//si on accepte mais que la demande vien d'un email non enregistrer
        $array['contenu'] = 'Nous serion ravi de compter votre mairie parmi notre site ,
        pour cela rendez vous <a href="'.$urlInscription.'">a cette adresse</a> afin de vous inscrire comme utilisateur ,
         nous vous attribueron alors les droit pour creer votre mairie au travers d\' nouvelle demande avec votre
         email via le quel votre compte utilisateur sera creer, il es important d\'utiliser votre email personnel!
         Votre compte sera personnel, les information de la mairie seront a saisir a l\etape suivante
         l\'inscrition est totalement gratuite ';
      }
    //
    //
    // assoc
    //
    //
    }elseif($objet == 'inscript_assoc'){//inscrition d'une association

      $array['objet'] = 'Inscrire mon Association';//objet du mail

      if(is_numeric($pseudo)){//si la demande vien d'un utilisateur

        $array['contenu'] = 'Nous avons bien recu votre demande pour inscrire votre association
        dans notre mairie et nous somme tres heureux de pouvoir vous compter parmi nous
        Nous venons par ce mail vous confirmer l\'acceptation de votre demande , vous pouvez des a present
        <a href="'.$urlConnection.'">cliquez ici</a> afin de vous connecter , rendez vous sur l\'onglet association
        vous y trouverai un lien pour remplir les information de votre association
        Une fois vos information enregistrer, un temp de moderation nous sera nessessaire afin de nous assurer
        de la bonne qualiter des donnee saisi , apres quoi votre assocaition sera visible sur notre site ,
        vous pouvez dés lors que votre association est en ligne recevoir des demande de membre ou envoyer des invitation';

      }else {//sinon on dit ok mais inscrivez vous

        $array['contenu'] = 'Nous serion ravi de compter votre association parmi notre mairie ,
        pour cela rendez vous <a href="'.$urlInscription.'">a cette adresse</a> afin de vous inscrire comme utilisateur ,
         nous vous attribueron alors les droit pour creer votre association au travers d\' nouvelle demande avec votre
         email via le quel votre compte utilisateur sera creer, il es important d\'utiliser votre email personnel!
         Votre compte sera personnel, les information de l\'association seront a saisir a l\etape suivante
         l\'inscrition est totalement gratuite ';
      }
    //
    //
    // MEMBRE
    //
    //
  }elseif($objet == 'inscript_membre'){//demande pour devenir membre

      $array['objet'] = 'Devenir membre de l\'association';//objet du mail

      if(is_numeric($pseudo)){//si c'est un utilisateur du site

        $array['contenu'] = 'Nous avons bien recu votre demande pour devenir membre de notre association
        et nous somme tres heureux de pouvoir vous compter parmi nous
        Nous venons par ce mail vous confirmer l\'acceptation de votre demande , vous faite des a present
        partie de notre association en tant qu\'utilisateur, vous pouvez maintenant nous contacter par
        message priver au traver de votre espace personnel et vous recevrai nos actualiter par email';

      }else {//si il ne fais pas parti du site

        $array['contenu'] = 'Nous serion ravi de vous compter parmi notre membre ,
        pour cela rendez vous <a href="'.$urlInscription.'">a cette adresse</a> afin de vous inscrire comme utilisateur ,
         nous vous attribueron alors les droit d\'acces a notre association au travers d\' nouvelle demande avec votre
         email via le quel votre compte utilisateur sera creer
         l\'inscrition est totalement gratuite ';
      }

    }
    //on concataine l'entete le contenu et le pied de page
    $array['contenu'] = $entete.$array['contenu'].$piedpage;
    //puis on renvoi le tout!
    return $array;
  }


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
