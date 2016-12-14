<?php $this->layout('layout_back', ['title' => 'AdminMairie','slug' => $slug,'orga' => $orga]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1>Administration</h1><br/><?php


if(isset($donnee)){
  if(is_array($donnee)){
    $masquer = array('id_user','slug','departement','id','token','created_at');
    //liste des element que je ne souhaite pas voir afficher dans le foreach
    foreach ($donnee as $key => $value) {
      if(!in_array($key,$masquer)){// filtre les cle quil ne doit pas afficher grace au tableau $masquer
        if(empty($value)){
          $value = 'Non renseigner' ;
        }
        if($key == 'horaire'){
          echo '<br/>'.$key.' : <br/>';
          foreach (unserialize($value) as $key => $value) { // transforme la string en array pour afficher
            echo $key.' : '.$value.'<br/>';
          }
          echo '<br/>';
        }else{
          echo $key.' : '.$value.'<br/>';
        }
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
