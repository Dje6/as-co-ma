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
    if(isset($edition) && !isset($acces)){
      if(isset($bug)){ echo $bug ; } ?>
      <form method="POST" action="<?php echo $this->url('admin_assoc_edit_post',['slug' => $slug]);?>">
      <label for="nom">Nom</label><br>
      <?php if(isset($error['nom'])){ echo '<span>'.$error['nom'].'</span><br>' ;} ?>
      <input type="text" name="nom" value="<?php echo $donnee['nom'] ; ?>"><br>

      <label for="adresse">Adresse</label><br>
      <?php if(isset($error['adresse'])){ echo '<span>'.$error['adresse'].'</span><br>' ;} ?>
      <input type="text" name="adresse" value="<?php echo $donnee['adresse'] ; ?>"><br>

      <label for="code_postal">Code postal</label><br>
      <?php if(isset($error['code_postal'])){ echo '<span>'.$error['code_postal'].'</span><br>' ;} ?>
      <input type="text" name="code_postal" value="<?php echo $donnee['code_postal'] ; ?>"><br>

      <label for="ville">Ville</label><br>
      <?php if(isset($error['ville'])){ echo '<span>'.$error['ville'].'</span><br>' ;} ?>
      <input type="text" name="ville" value="<?php echo $donnee['ville'] ; ?>"><br>

      <label for="fix">Fixe</label><br>
      <?php if(isset($error['fix'])){ echo '<span>'.$error['fix'].'</span><br>' ;} ?>
      <input type="text" name="fix" value="<?php echo $donnee['fix'] ; ?>"><br>

      <label for="description">Description</label><br>
      <?php if(isset($error['description'])){ echo '<span>'.$error['description'].'</span><br>' ;} ?>
      <input type="text" name="description" value="<?php echo $donnee['description'] ; ?>"><br>

      <input type="submit" name="submit" value="Enregistrer"><br>
      </form>
      <?php
    }else {
      echo '<abc>Nom : '.$donnee['nom'].'</abc><br>';
      echo '<abc>Adresse : '.$donnee['adresse'].'</abc><br>';
      echo '<abc>Code postal : '.$donnee['code_postal'].'</abc><br>';
      echo '<abc>Ville : '.$donnee['ville'].'</abc><br>';
      echo '<abc>Fixe : '.$donnee['fix'].'</abc><br>';
      echo '<abc>Description : '.$donnee['description'].'</abc><br>';
      echo '<abc>statut : '.$donnee['status'].'</abc><br>';
      if(!isset($acces)){
        echo '<a href="'.$this->url('admin_assoc_edit_form', ['slug' => $slug]).'"><button>Modifier</button></a><br>';
      }
    }
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
