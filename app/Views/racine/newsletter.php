<!-- PAGE DE DESINSCRIPTION A LA NEWSLETTER DES ARTICLES ABONNES apres reception d'un mail chez l'utilisateur -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Se désinscrire de la newsletter']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php
if(isset($confirmation)){ ?>
  <!-- Message de confirmation de bonne désinscription -->
  <div class="row">
    <h2 class="confirmForm"><?= $confirmation; ?></h2>
  </div>
  <?php
}else { ?>

  <div class="row">
    <form class="formFront" action="<?php echo $this->url('default_desinscription',['orga'=>$orga,'slug'=>$slug]); ?>" method="POST">

        <fieldset>
          <legend>
            <h2 class="text-center"><b>Vous désinscrire de la newsletter</b></h2>
          </legend>

          <!-- EMAIL UTILISATEUR -->
          <div class="form-group">
            <label for="mail">Adresse e-mail :</label><span class="errorForm"><?php if(isset($error['mail']) && !empty($error['mail'])){ echo $error['mail']; } ?></span>
            <input type="text" class="form-control" name="mail" value=""><br/>
          </div>

          <input type="hidden" name="capcha" value="">
          <button class="btn btn-success btn-sm" type="submit" name="submit">Se désinscrire</button>

        </fieldset>
    </form>
  </div>
  <?php
} ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
