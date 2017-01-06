<!-- PAGE D'ERREUR 403 SI L'UTILISATEUR N'A PAS LES DROITS D'ACCEDER A UNE PAGE -->
<?php $this->layout('layout_back', ['title' => 'Nothing to see here']) ?>


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content'); ?>
<!-- Titre et image personnalisée au type d'erreur -->
<div class="row errorPage">
  <h2><b><i>Vous n'êtes pas autorisé à afficher cette page !</i></b></h2>
  <img src="<?= $this->assetUrl('img/403.jpg'); ?>" alt="403" class="img-responsive" width="100%">
</div>
<?php $this->stop('main_content'); ?>


<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
