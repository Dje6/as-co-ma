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
      echo '<form method="POST" action="'.$this->url('admin_assoc_edit_post').'">';
      echo '<label for="nom">Nom</label><br>';
      echo '<input type="text" name="nom" value="'.$donnee['nom'].'"><br>';

      echo '<label for="adresse">Adresse</label><br>';
      echo '<input type="text" name="adresse" value="'.$donnee['adresse'].'"><br>';

      echo '<label for="code_postal">Code postal</label><br>';
      echo '<input type="text" name="code_postal" value="'.$donnee['code_postal'].'"><br>';

      echo '<label for="ville">Ville</label><br>';
      echo '<input type="text" name="ville" value="'.$donnee['ville'].'"><br>';

      echo '<label for="fix">Fixe</label><br>';
      echo '<input type="text" name="fix" value="'.$donnee['fix'].'"><br>';

      echo '<label for="description">Description</label><br>';
      echo '<input type="text" name="description" value="'.$donnee['description'].'"><br>';

      echo '<label for="status">Statut</label><br>';
      echo '<input type="text" name="status" value="'.$donnee['status'].'"><br>';

      echo '<input type="submit" name="submit" value="Enregistrer"><br>';
      echo '</form>';
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
