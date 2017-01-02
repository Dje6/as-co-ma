<?php $this->layout('layout_back', ['title' => 'Perdu ?']) ?>

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content'); ?>
<div class="row errorPage">
  <?php if(is_array($error)){ ?>
    <h2><b><i>Un problème est survenu... Toutes nos excuses : <br><?php foreach ($error as $key => $value) {
      echo $value.' <br>';
    } ?></i></b></h2><?php
  }else { ?>
    <h2><b><i>Un problème est survenu... Toutes nos excuses : <?php echo $error; ?></i></b></h2><?php
  } ?>
  <img src="<?= $this->assetUrl('img/loading.gif'); ?>" alt="409" class="img-responsive">
</div>
<?php $this->stop('main_content'); ?>


<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
