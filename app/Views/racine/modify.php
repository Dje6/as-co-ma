<?php $this->layout('layout', ['title' => 'AS-CO-MA - Modifier mot de passe']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<h1>Page modification de mot de passe</h1><br/>
<?php if(empty($mail)){ $mail = $donnee['mail']; } ?>
<?php if(empty($token)){ $token = $donnee['token']; } ?>

<form action="<?php echo $this->url('racine_modifyPost'); ?>" method="POST">

  <?php if(isset($error['password'])){ echo '<span>'.$error['password'].'</span>' ;} ?>
  <label for="password">Password : </label>
  <input type="text" name="password" value=""><br/>
  <label for="repeat_password">Repeat password :</label>
  <input type="text" name="repeat_password" value=""><br/>

  <input type="hidden" name="capcha" value="">
  <?php if(isset($error['mail'])){ echo '<span>'.$error['mail'].'</span>' ;} ?>
  <input type="hidden" name="mail" value="<?= $mail ;?>">
    <?php if(isset($error['token'])){ echo '<span>'.$error['token'].'</span>' ;} ?>
  <input type="hidden" name="token" value="<?= $token ;?>">

  <input type="submit" name="submit" value="Envoyer">
</form>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
