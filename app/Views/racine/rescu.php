<?php $this->layout('layout', ['title' => 'Récupération de mot de passe']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<h1>Page recuperation mot de passe</h1><br/>

<form action="<?php echo $this->url('racine_mdpPost'); ?>" method="POST">

  <span><?php if(isset($error['email'])){ echo $error['email'] ;} ?></span>
  <label for="email">Email : </label>
  <input type="email" name="email" value=""><br/>
  <input type="hidden" name="capcha" value="">

  <input type="submit" name="submit" value="Envoyer">
</form>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
