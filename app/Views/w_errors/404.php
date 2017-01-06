<!-- PAGE D'ERREUR 404 SI LE SITE NE TROUVE AUCUNE PAGE A RETOURNER SUIVANT L'URL -->
<?php $this->layout('layout', ['title' => 'Perdu ?']) ?>

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content'); ?>
<!-- Titre et image personnalisée a l'erreur -->
<div class="row errorPage">
  <h2><b><i>Cette page n'existe pas :(</i></b></h2>
  <img src="<?= $this->assetUrl('img/404.png'); ?>" alt="404" class="img-responsive" width="100%">
</div>
<?php $this->stop('main_content'); ?>


<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
