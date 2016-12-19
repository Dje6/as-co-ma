<?php $this->layout('layout', ['title' => 'Récupération de mot de passe']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>

<!-- FORMULAIRE OUBLI DE MOT DE PASSE -->
<form action="<?php echo $this->url('racine_mdpPost'); ?>" method="POST">
  <legend><h2>Mot de passe oublié ?</h2></legend>

  <div class="form-group">
    <label for="email">Adresse E-mail : </label>
    <span><?php if(isset($error['email'])){ echo $error['email'] ;} ?></span>

    <input type="email" class="form-control" name="email" value=""><br/>
    <input type="hidden" class="form-control" name="capcha" value="">
  </div>

  <button type="submit" class="btn btn-success btn-md" name="submit">Envoyer</button>
</form>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
