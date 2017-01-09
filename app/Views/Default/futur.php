<!-- PAGE DES CONDITIONS GENERALES D'UTILISATION DU SITE -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Avenir du site']) ?>
<!-- tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_home.css'); ?>">
<?php $this->stop('main_head') ?>


<?php $this->start('main_content') ?>

<!-- BLOC DES CGU. Se déroule et se cache au click du bouton dérouler -->
<div class="row">
  <blockquote class="cgu">
    <h2 class="text-center">L'Avenir d'AS-CO-MA</h2>
    <p>
      Ici le futur du site
    </p>

    <footer><strong>Les Administrateurs</strong>, <cite title="Source Title">AS-CO-MA</cite></footer>
    <br>
  </blockquote>
</div>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
<!-- //ici les script js de la Page courante UNIQUEMENT
//si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
