<?php
if(is_numeric($slugRecepteur)){ $id = $slugRecepteur ;}

if($w_current_route == 'admin_assoc_contact_mairie' || ($orga == 'assoc' && !isset($id))){
  $quiContacter = '<h3 class="titrecontact">Contacter la '.$this->unslug($slugRecepteur).'</h3>';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur,'slugR' => $slugRecepteur]);

}elseif($w_current_route == 'admin_mairie_contact_assoc' || ($orga == 'mairie' && $slugRecepteur != 'Webmaster')) {
  $quiContacter = '<h3 class="titrecontact">Contacter l\'association '.$this->unslug($slugRecepteur).'</h3>';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur,'slugR' => $slugRecepteur]);

}elseif($w_current_route == 'admin_assoc_contact_membre' || (isset($id)) ) {
  $quiContacter = '<h3 class="titrecontact">Contacter le membre</h3>';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur,'id' => $id]);

}elseif($w_current_route == 'admin_mairie_contact_Webmaster' || $orga == 'site' || $slugRecepteur == 'Webmaster') {
  $quiContacter = '<h3 class="titrecontact">Contacter le Webmaster</h3>';
  $orga = 'mairie';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur,'slugR' => $slugRecepteur]);

}elseif($w_current_route == 'admin_assoc_contact_tout_membres' || $mailRecepteur == 'Tous les membres') {
  $quiContacter = '<h3 class="titrecontact">Message à tous les membres</h3>';
  $orga = 'assoc';
  $urlDePost = $this->url($w_current_route,['slugE' => $slugEmeteur]);
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



<!-- // debut du formulaire intégré -->

<div class="container-fluid fichecontact">

    <div class="col-xs-12 col-xs-offset-0 col-lg-10 col-lg-offset-1 col-centered ">
      <div class="panel panel-default ">
        <form class="" action="<?php echo $urlDePost; ?>" method="post">
          <div class="panel-body">

            <div class="form-group">
              <?php if(isset($error['destinataire_mailOrId'])){ echo '<span style="color:red;">'.$error['destinataire_mailOrId'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope blue"></i></span>
                <input type="text" name="destinataire_mailOrId" placeholder="Destinataire" class="form-control" value="<?php echo $mailRecepteur ;?>" readonly>
              </div>
            </div>

            <div class="form-group">
              <?php if(isset($error['objet'])){ echo '<span style="color:red;">'.$error['objet'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
                <input type="text" name="objet" placeholder="Objet" class="form-control" autofocus="autofocus" value="<?php if(isset($donnee['objet'])){ echo $donnee['objet'] ; } ?>">
              </div>
            </div>

            <div class="form-group">
              <?php if(isset($error['contenu'])){ echo '<span style="color:red;">'.$error['contenu'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-comment blue"></i></span>
                <textarea name="contenu" rows="6" cols="80" class="form-control" type="text" required><?php if(isset($donnee['contenu'])){ echo $donnee['contenu'] ; } ?></textarea>
              </div>
            </div>

            <div class="">
              <input type="hidden" name="capcha" value="">
              <input type="submit" name="submit" class="btn btn-info pull-right" value="envoyer">
              <button type="reset" value="Reset" name="reset" class="btn">Effacer <span class="glyphicon glyphicon-refresh"></span></button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>

<!-- // fin du formulaire intégré -->



<?php
}else {
	echo $confirmation;
} ?>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
