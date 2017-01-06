<!-- PAGE DE MODIFICATION DE MDP OUBLIE APRES RECEPTION D'UN MAIL DE CHEZ L'UTILISATEUR -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Modifier mot de passe']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>

<?php if(empty($mail)){ $mail = $donnee['mail']; } ?>
<?php if(empty($token)){ $token = $donnee['token']; } ?>

<!-- FORM MODIFY PASSWORD -->
<div class="row">
  <form class="formFront" action="<?php echo $this->url('racine_modifyPost'); ?>" method="POST">

    <legend><h2>Modifiez votre mot de passe</h2></legend>

    <!-- PASSWORD MODIFY -->
    <div class="form-group">
      <label for="password">Nouveau mot de passe : </label><span class="errorForm"><?php if(isset($error['password'])){ echo $error['password']; } ?></span>
      <input type="password" class="form-control" name="password" value=""><br/>
    </div>

    <!-- REPEAT PASSWORD MODIFY -->
    <div class="form-group">
      <label for="repeat_password">Répétez votre nouveau mot de passe :</label>
      <input type="password" class="form-control" name="repeat_password" value=""><br/>
    </div>


    <input type="hidden" name="capcha" value="">

    <!-- MAIL HIDDEN -->
    <div class="form-group">
      <input type="hidden" name="mail" value="<?= $mail ;?>">
      <span class="errorForm"><?php if(isset($error['mail'])){ echo $error['mail']; } ?></span>
    </div>

    <!-- TOKEN HIDDEN -->
    <div class="form-group">
      <input type="hidden" name="token" value="<?= $token ;?>">
      <span class="errorForm"><?php if(isset($error['token'])){ echo '<span>'.$error['token'].'</span>' ;} ?></span>
    </div>

    <button type="submit" name="submit">Modifier</button>
  </form>
</div>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
