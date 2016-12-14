<?php $this->layout('layout', ['title' => 'Connexion']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<h1>Page recuperation mot de passe</h1><br/>

<form action="<?php echo $this->url('racine_mdpPost'); ?>" method="POST">

  <span><?php if(isset($error)){ echo $error ;} ?></span>
  <label for="pseudo">Email : </label>
  <input type="text" name="pseudo" value=""><br/>

  <input type="submit" name="" value="conecter">
</form>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
