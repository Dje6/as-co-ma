<?php
if($w_current_route == 'admin_assoc_contact_mairie' || $orga == 'assoc'){
  $quiContacter = '<p>Contacter la '.$slugRecepteur.'</p>';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur,'slugR' => $slugRecepteur]);

}elseif($w_current_route == 'admin_mairie_contact_assoc' || ($orga == 'mairie' && $slugRecepteur != 'Webmaster')) {
  $quiContacter = '<p>Contacter l\'association '.$slugRecepteur.'</p>';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur,'slugR' => $slugRecepteur]);

}elseif($w_current_route == 'admin_assoc_contact_menbre' ) {
  $quiContacter = '<p>Contacter le menbre</p>';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur,'slugR' => $slugRecepteur]);

}elseif($w_current_route == 'admin_mairie_contact_Webmaster' || $orga == 'site' || $slugRecepteur == 'Webmaster') {
  $quiContacter = '<p>Contacter le Webmaster</p>';
  $orga = 'mairie';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur,'slugR' => $slugRecepteur]);
}

$this->layout('layout_back', ['title' => 'Message','slug' => $slug,'orga' => $orga]);
 ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>

	<h1><?php echo $quiContacter ;?></h1><br/>
<?php
if(!isset($confirmation)){ ?>

  <form class="" action="<?php echo $urlDePost; ?>" method="post">

    <label for="destinatire">Destinataire </label>
    <?php if(isset($error['destinataire_mailOrId'])){ echo '<span style="color:red;">'.$error['destinataire_mailOrId'].'</span>' ;} ?><br/>
		<input type="text" name="destinataire_mailOrId" value="<?php echo $mailRecepteur ;?>" readonly><br/>

    <label for="objet">Objet</label>
    <?php if(isset($error['objet'])){ echo '<span style="color:red;">'.$error['objet'].'</span>' ;} ?><br/>
    <input type="text" name="objet" value="<?php if(isset($donnee['objet'])){ echo $donnee['objet'] ; } ?>"><br/>

    <label for="contenu">Message</label>
    <?php if(isset($error['contenu'])){ echo '<span style="color:red;">'.$error['contenu'].'</span>' ;} ?><br/>
    <textarea name="contenu" rows="8" cols="80"><?php if(isset($donnee['contenu'])){ echo $donnee['contenu'] ; } ?></textarea><br/>

		<input type="hidden" name="capcha" value="">
    <input type="submit" name="submit" value="envoyer">

  </form><?php
}else {
	echo $confirmation;
} ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
