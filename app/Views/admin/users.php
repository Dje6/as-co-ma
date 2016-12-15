<?php $this->layout('layout_back', ['title' => 'User','orga' => $orga,'slug' =>$slug]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->
<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>

<?php

if(isset($acces)){
  echo '<h1>Information du membre</h1><br/>';
}else{
echo '<h1>Vos informations personnelles</h1><br/>';
}

if(isset($donnee)){
  echo '<div>';
  if(is_array($donnee)){
    //debug($donnee);
    echo '<p class="">pseudo : '.$donnee['pseudo'].'</p>';
    echo '<p class="">nom : '.$donnee['nom'].'</p>';
    echo '<p class="">pseudo : '.$donnee['pseudo'].'</p>';
    echo '<p class="">pseudo : '.$donnee['pseudo'].'</p>';
    echo '<p class="">pseudo : '.$donnee['pseudo'].'</p>';
    echo '<p class="">pseudo : '.$donnee['pseudo'].'</p>';


  }else{
    echo '<p>'.$donnee.'</p>';
  }
  echo '</div>';
}

?>

<?php $this->stop('main_content') ?>

<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
