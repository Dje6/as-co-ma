<?php $this->layout('layout', ['title' => 'AS-CO-MA - Connexion']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>



  <form action="<?php echo $this->url('racine_connexion'); ?>" method="POST">

    <fieldset>
      <legend><h1 class="text-center">Connectez-vous à votre compte sur AS-CO-MA : </h1></legend>

      <div class="form-group">
        <label for="pseudo">Pseudo ou Email : </label><span class="errorForm"><?php if(isset($error)){ echo $error; } ?></span>
        <input class="form-control" type="text" name="pseudo" value="">
      </div>
      <br>

      <div class="form-group">
        <label for="password">Password : </label>
        <input class="form-control" type="text" name="password" value="">
      </div>
      <br>

      <button class="btn btn-success btn-md" type="submit" name="submit">Se Connecter</button>
    </fieldset>
  </form>
  <br>

  Pas encore de compte ? <a href="<?php echo $this->url('racine_inscriptForm'); ?>">Rejoignez-nous !</a>
  <br>

  <a href="<?php echo $this->url('racine_mdpForm'); ?>">Mot de passe oublié ?</a>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
