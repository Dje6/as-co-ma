<?php $this->layout('layout_back', ['title' => 'AdminAssoc','slug' => $slug,'orga' => $orga]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1>Administration</h1><br/><?php

if(isset($donnee)){
  if(is_array($donnee)){
    $masquer = array('id_mairie','id_user','slug','id','token','created_at', 'avatar', 'background');
    //liste des element que je ne souhaite pas voir afficher dans le foreach
    foreach ($donnee as $key => $value) {
      if(!in_array($key,$masquer)){ // affiche toute les cle sauf celle specifier dans le tableau $masquer
        if(empty($value)){//si la valeur es vide , on affiche "non renseigner"
          $value = 'Non renseigner' ;
        }
        echo $key.' : '.$value.'<br/>';
      }
    }
  }else{
    echo $donnee;
  }
}

?>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
