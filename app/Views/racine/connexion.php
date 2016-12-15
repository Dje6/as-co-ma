<?php $this->layout('layout', ['title' => 'Connexion']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<h1>bienvenu sur la page de connection Users</h1><br/>
<form action="<?php echo $this->url('racine_connexion'); ?>" method="POST">
  <?php if(isset($error)){ echo '<span>'.$error.'</span> <br>' ;} ?>
  <label for="pseudo">Pseudo/Email : </label>
  <input type="text" name="pseudo" value=""><br/>
  <label for="password">Password : </label>
  <input type="text" name="password" value=""><br/>

  <input type="submit" name="" value="connecter">
</form><br/>

<a href="<?php echo $this->url('racine_inscriptForm'); ?>">Inscription</a><br/>

<a href="<?php echo $this->url('racine_mdpForm'); ?>">Mot de passe oublier</a>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
