<?php $this->layout('layout', ['title' => 'Perdu ?']) ?>

<?php $this->start('main_content'); ?>
  <div class="row">
    <h2 class="text-center"><strong><i>Cette page n'existe pas :(</i></strong></h2>
    <img src="<?= $this->assetUrl('img/404.png'); ?>" alt="404" class="img-responsive" width="100%">
  </div>
<?php $this->stop('main_content'); ?>
