<?php $this->layout('layout', ['title' => 'AS-CO-MA - Desinscription']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php
if(isset($confirmation)){
  echo $confirmation;
}else { ?>

  <form class="formFront" action="<?php echo $this->url('default_desinscription',['orga'=>$orga,'slug'=>$slug]); ?>" method="POST">

    <legend><h2>Vous desinscrire de la newsletter</h2></legend>

    <div class="form-group">
      <label for="mail">Adresse email :</label>
      <input type="text" class="form-control" name="mail" value="
      <?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span>'.$error['mail'].'</span><br/>' ; } ?>"><br/>
    </div>

    <input type="hidden" name="capcha" value="">

    <button type="submit" name="submit">Desinscrire</button>
  </form>
  <?php
} ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
