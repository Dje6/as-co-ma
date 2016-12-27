<?php
if(!isset($slug)){ $slug = 'user' ;}
if(!isset($orga)){ $orga = 'user' ;}
$this->layout('layout_back', ['title' => 'Message','slug' => $slug,'orga' => $orga]);
 ?>
<!-- //tableau de données que l'on peut faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content');

if(isset($orga) && ($orga == 'mairie' || $orga == 'assoc' || $orga == 'webmaster')){
  $urlSend = $this->url('admin_message_send_'.$orga,['slug' => $slug,'orga' => $orga,'page' => 1]);
  $urlReceive = $this->url('admin_message_'.$orga,['slug' => $slug,'orga' => $orga,'page' => 1]);
}else{
  $urlSend = $this->url('admin_message_send',['page' => 1]);
  $urlReceive = $this->url('admin_message',['page' => 1]);
}?>


<!-- l'affichage commence ici ,avec les deux boutons pour les messages recus ou envoyés -->
	<h1 class="titreback">Messagerie</h1><br/>

  <div class="container-fluid">
    <div class="row messageall">
      <div class="bouton_env">
        <a href="<?php echo $urlSend ; ?>"><button  class="btn btn-default ">Messages Envoyés</button></a>
      </div>
      <div class="bouton_rec">
        <a href="<?php echo  $urlReceive; ?>"><button  class="btn btn-default ">Messages Reçus</button></a>
      </div>
    </div>
  </div>

  <?php

  // ensuite on affiche les données retournées par sql
if(isset($donnees)){
	if(!empty($donnees)){
		if(is_array($donnees)){ // si donnee est un array on explore , sinon on affiche le message qu'il contient

			if(isset($pagination)){ //si il y a assez d'element , la pagination s'active toute seul
        //si tu a besoin de diminuer le nombre d'affichage c'est dan le MessageController
        //les ligne avec '$limit', si tu es sur la messagerie :
        //user : methode home (message recu)
        //              homeSend (message envoyer)
        //orga :        orga(message recu)
        //              orgaSend (message envoyer)
        //tout le systeme de message fonctionne ormi les boutons accepter refuser et plus info , lu suppr et rep c ok
        //donc si besoin tu peut ecrire des messages pour remplir les messageries
        // pense a faire la mise a jour de la table contact si tu l'avais pas fait

				echo '<div id="page">' .$pagination. '</div>' ;

      }
      ?>


      <div class="container affichageMairie"><?php
  			foreach ($donnees as $key => $value) {

          if(isset($value['destinataire_pseudo'])){
          // si on est dans les message envoyer il affiche ca
            echo 'Destinataire : '.$value['destinataire_pseudo'].'<br/>';
            echo 'Email : '.$value['destinataire_mail'].'<br/>';
          }else {
          //sinon c'est ca
            echo 'Emeteur : '.$value['emeteur_pseudo'].'<br/>';
            echo 'Email : '.$value['emeteur_mail'].'<br/>';
          }
  				echo 'Objet : '.$value['objet'].'<br/>';
  				echo 'Message : '.$value['contenu'].'<br/>';
  				echo 'Envoye le : '.$value['date_envoi'].'<br/><br/>';
          if($value['status'] == 'lu'){
          //si le statu est a lu , on affiche la date de lecture
            echo 'Lu le : '.$value['date_lecture'].'<br/>';
          }elseif ($value['status'] != 'lu' && $value['status'] != 'non-lu') {
          //si une reponse a ete faite a ce message on indique la date de reponse
          //qui es la meme date que pour la lecture mais mise a jour
            echo 'Repondu le : '.$value['date_lecture'].'<br/>';
          }
          echo 'Status : '.$value['status'].'<br/>';

          preg_match_all('/inscript/', $value['objet'], $matches);
          // on detect si il s'agit dune demande d'inscription

          if(!empty($matches[0]) && $value['status'] == 'non-lu' && !isset($value['destinataire_pseudo'])){
          //si oui on affiche les bouton de decision ?>

            <a href="<?php echo $this->url('admin_accepte',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
              <button class="btn btn-success">Accepter</button>
            </a>
            <a href="<?php echo $this->url('admin_plus_info',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
              <button class="btn btn-warning">Manque d'informations</button>
            </a>
            <a href="<?php echo $this->url('admin_refuse',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
              <button class="btn btn-danger">Refuser</button>
            </a><?php

          }else{
          //sinon j'affiche les autre bouton
            if($orga == 'user'){
            //si on es un user , on ne peu que repondre , declarer Lu ou le supprimer
              if(!isset($value['destinataire_pseudo'])){ ?>
                <a href="<?php echo $this->url('admin_repondre_User',['id'=> $value['id']]) ; ?>">
                  <button class="btn btn-primary">Répondre</button>
                </a><?php
              }
            }else {
            //sinon le bouton repondre s'adapte au fait que l'on es un organisme mais reste afficher identique
              if(!isset($value['destinataire_pseudo']) && ($value['status'] == 'non-lu' || $value['status'] == 'lu')){
                // le bouton repondre quan on es un organisme ne safiche que sous plusieur condition ?>
                <a href="<?php echo $this->url('admin_repondre',['id'=> $value['id'],'orga' => $orga,'slug' => $slug]) ; ?>">
                  <button class="btn btn-primary">Répondre</button>
                </a><?php
              }
            }
            if($value['status'] == 'non-lu' && !isset($value['destinataire_pseudo'])){
            //le bouton pour declarer le message comme lu ne safiche QUE si on es mode boite de reception et si le message
            // n'a pas encor ete lu ?>
              <a href="<?php echo $this->url('admin_message_asSeen',['id'=> $value['id'],'orga' => $orga,'slug' => $slug,'page' => $page]) ; ?>">
                <button class="btn btn-success">Lu</button>
              </a><?php
            }
            //le bouton supprimer lui saffiche tout le temp dés lors que ce n'est pas une demande dinscritpion ou
            //Si s'en est une ,il ne saffiche qui si la demande a ete traiter ?>
            <a href="<?php echo $this->url('admin_message_delete',['id'=> $value['id'],'orga' => $orga,'slug' => $slug,'page' =>$page]) ; ?>">
              <button class="btn btn-danger">supprimer</button>
            </a><?php
          }?>
          <br/>
          <br/>
          <br/><?php
  			}//fin du foreach ?>
      </div><?php
			if(isset($pagination)){ //si il y a assez d'element , la pagination s'active toute seul
				echo $pagination;
			}
		}
	}else{
    echo '<h3 class="titreback">Aucun messages</h3>';
  }
}
?>
 <a href="#" class="btn btn-info return">Retour Menu</a>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
