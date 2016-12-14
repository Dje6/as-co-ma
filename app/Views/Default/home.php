<?php $this->layout('layout', ['title' => 'Accueil']) ?>
<!-- tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
	<p>Vous avez atteint la page d'accueil.<br/><br/>
<?php if(!isset($_SESSION['user'])){
	?><a href="<?php echo $this->url('racine_connexion'); ?>">connection users</a></p><?php
} ?>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
