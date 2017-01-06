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
	<h1 class="titreback">Messagerie</h1>

  <div class="container-fluid col-md-12 col-offset-0 col-lg-10 col-lg-offset-1">
    <div class="row center">
      <a class="bouton_env " href="<?php echo $urlSend ; ?>">
        <button  class="btn btn-default ">Messages Envoyés</button>
      </a>
      <a class="bouton_rec" href="<?php echo $urlReceive; ?>">
        <button  class="btn btn-default ">Messages Reçus</button>
      </a>
    </div>

  <?php

  // ensuite on affiche les données retournées par sql
if(isset($donnees)){
	if(!empty($donnees)){
		if(is_array($donnees)){ // si donnee est un array on explore , sinon on affiche le message qu'il contient ?>

      <div class="row affichageMairie"><?php
        if(isset($pagination)){  ?>
          <div class="container-fluid"><?= $pagination ?></div> <?php
        }
  			foreach ($donnees as $key => $value) {

          if(isset($value['destinataire_pseudo'])){
          // si on est dans les message envoyer il affiche ca ?>
            <h3 class="padleft4">Destinataire : <?= $value['destinataire_pseudo']; ?></h3>
            <p class="padleft4">Email : <?= $value['destinataire_mail']; ?></p><br/>
          <?php }else {
          //sinon c'est ca ?>
            <h3 class="padleft4">Emetteur : <?= $value['emeteur_pseudo']; ?></h3>
            <p class="padleft4">Email : <?= $value['emeteur_mail']; ?></p><br/>
          <?php } ?>
    				<p class="padleft4">Objet : <?= $value['objet']; ?></p>
    				<p class="padleft4">Message : <?= $value['contenu']; ?></p>
    				<p class="padleft4">Envoye le : <?= $value['date_envoi']; ?></p><br/>
        <?php if($value['status'] == 'lu'){
          //si le statu est a lu , on affiche la date de lecture ?>
            <p class="padleft4">Lu le : <?= $value['date_lecture']; ?></p><br/>
        <?php }elseif ($value['status'] != 'lu' && $value['status'] != 'non-lu') {
          //si une reponse a ete faite a ce message on indique la date de reponse
          //qui es la meme date que pour la lecture mais mise a jour ?>
            <p class="padleft4">Repondu le : <?= $value['date_lecture']; ?></p><br/>
          <?php } ?>
          <p class="padleft4">Status : <?= $value['status']; ?></p><br/><br>
          <?php
          preg_match_all('/inscript/', $value['objet'], $matches);
          // on detect si il s'agit dune demande d'inscription
          preg_match_all('/Invitation/', $value['objet'], $matches2);
          //ou si il s'agit dune invitation

          if(!empty($matches[0]) && $value['status'] == 'non-lu' && !isset($value['destinataire_pseudo'])){
          //si oui on affiche les bouton de decision ?>

            <a href="<?php echo $this->url('admin_decide',['id' => $value['id'],'orga' => $orga,
            'slug' => $slug,'decision'=>'Accepter']); ?> ">
              <button class="btn btn-success margin1">Accepter</button>
            </a>
            <a href="<?php echo $this->url('admin_decide',['id' => $value['id'],'orga' => $orga,
            'slug' => $slug,'decision'=>'Plus-Info']); ?> ">
              <button class="btn btn-warning margin1">Manque d'informations</button>
            </a>
            <a href="<?php echo $this->url('admin_decide',['id' => $value['id'],'orga' => $orga,
            'slug' => $slug,'decision'=>'Refuser']); ?> ">
              <button class="btn btn-danger margin1">Refuser</button>
            </a><?php

          }elseif ((!empty($matches2[0]) && $value['status'] == 'non-lu' && $orga == 'user')) {
            ?>
             <a href="<?php echo $this->url('admin_invitation_decision',['id' => $value['id'],'decision'=>'Accepter']); ?> ">
               <button class="btn btn-success margin1">Accepter</button>
             </a>
             <a href="<?php echo $this->url('admin_invitation_decision',['id' => $value['id'],'decision'=>'Refuser']); ?> ">
               <button class="btn btn-danger margin1">Refuser</button>
             </a><?php
          }else{
          //sinon j'affiche les autre bouton
            if($orga == 'user' && empty($matches2[0])){
            //si on es un user , on ne peu que repondre , declarer Lu ou le supprimer
              if(!isset($value['destinataire_pseudo'])){ ?>
                <a href="<?php echo $this->url('admin_repondre_User',['id'=> $value['id']]) ; ?>">
                  <button class="btn btn-primary margin1">Répondre</button>
                </a><?php
              }
            }else {
            //sinon le bouton repondre s'adapte au fait que l'on es un organisme mais reste afficher identique
              if(!isset($value['destinataire_pseudo']) && ($value['status'] == 'non-lu' || $value['status'] == 'lu')){
                // le bouton repondre quan on es un organisme ne safiche que sous plusieur condition ?>
                <a href="<?php echo $this->url('admin_repondre',['id'=> $value['id'],'orga' => $orga,'slug' => $slug]) ; ?>">
                  <button class="btn btn-primary margin1">Répondre</button>
                </a><?php
              }
            }
            if($value['status'] == 'non-lu' && !isset($value['destinataire_pseudo'])){
            //le bouton pour declarer le message comme lu ne safiche QUE si on es mode boite de reception et si le message
            // n'a pas encor ete lu ?>
              <a href="<?php echo $this->url('admin_message_asSeen',['id'=> $value['id'],'orga' => $orga,'slug' => $slug,'page' => $page]) ; ?>">
                <button class="btn btn-success margin1">Lu</button>
              </a><?php
            }
            //le bouton supprimer lui saffiche tout le temp dés lors que ce n'est pas une demande dinscritpion ou
            //Si s'en est une ,il ne saffiche qui si la demande a ete traiter ?>
            <a href="<?php echo $this->url('admin_message_delete',['id'=> $value['id'],'orga' => $orga,'slug' => $slug,'page' =>$page]) ; ?>">
              <button class="btn btn-danger margin1">supprimer</button>
            </a><?php
          }?>
          <br/>
          <br/>
          <br/><?php
  			}//fin du foreach
        if(isset($pagination)){ //si il y a assez d'element , la pagination s'active toute seul ?>
        <div ><?= $pagination ?></div><?php
      } ?>
      </div><?php
		}
	}else{ ?>
    <h3 class="titreback">Aucun messages</h3>
  <?php }
}
?>
</div>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
