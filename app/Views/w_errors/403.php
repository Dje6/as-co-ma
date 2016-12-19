<?php $this->layout('layout_back', ['title' => 'Nothing to see here']) ?>


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content'); ?>
<h1>403. Vous n'êtes pas autorisé à accéder à ce contenu.</h1>
<?php $this->stop('main_content'); ?>


<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
