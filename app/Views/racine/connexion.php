<!-- PAGE DE FORMULAIRE DE CONNEXION UTILISATEUR  -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Connexion']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_login.css'); ?>">
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>

  <div class="row">
    <form class="formFront" action="<?php echo $this->url('racine_connexion'); ?>" method="POST">

      <fieldset>
        <legend><h2 class="text-center"><b>Connectez-vous à votre compte sur AS-CO-MA :</b></h2></legend>

        <!-- PSEUDO ou EMAIL DE CONNEXION -->
        <div class="form-group">
          <label for="pseudo">Pseudo ou Email : </label><span class="errorForm"><?php if(isset($error)){ echo $error; } ?></span>
          <input class="form-control" type="text" name="pseudo" value="<?php if(isset($saisi['pseudo'])) { echo $saisi['pseudo']; } ?>">
        </div>

        <!-- MDP DE CONNEXION -->
        <div class="form-group">
          <label for="password">Password : </label>
          <input class="form-control" type="password" name="password" value="<?php if(isset($saisi['password'])) { echo $saisi['password']; } ?>">
        </div>

        <button class="btn btn-success btn-md col-xs-offset-5" type="submit" name="submit">Se Connecter</button>
      </fieldset>

      <!-- Si pas encore de compte, redirection formulaire inscription -->
      <p>Pas encore de compte ? <a href="<?php echo $this->url('racine_inscriptForm'); ?>">Rejoignez-nous !</a></p>
      <!-- Lien vers formulaire d'oubli de mdp -->
      <a href="<?php echo $this->url('racine_mdpForm'); ?>">Mot de passe oublié ?</a>

    </form>
  </div>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
