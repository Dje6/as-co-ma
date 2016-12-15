<?php $this->layout('layout_back', ['title' => 'User','orga' => isset($orga),'slug' => isset($slug)]) ?>
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


if(isset($donnee)){//si la base de donnee retourne des information , array comme string
  if(is_array($donnee)){//si la base de donnee retourne un array
    if(isset($edition) && !isset($acces)){
      echo '<form method="POST" action="'.$this->url('admin_monCompte_edition_post').'">';
    }
        if(isset($edition) && !isset($acces)){
          echo '<label for="pseudo">pseudo</label><br>';
          echo '<input type="text" name="pseudo" value="'.$donnee['pseudo'].'"><br/>';

          echo '<label for="mail">mail</label><br>';
          echo '<input type="text" name="mail" value="'.$donnee['mail'].'"><br/>';

          echo '<label for="adresse">adresse</label><br>';
          echo '<input type="text" name="adresse" value="'.$donnee['adresse'].'"><br/>';

          echo '<label for="code_postal">code postal</label><br>';
          echo '<input type="text" name="code_postal" value="'.$donnee['code_postal'].'"><br/>';

          echo '<label for="ville">ville</label><br>';
          echo '<input type="text" name="ville" value="'.$donnee['ville'].'"><br/>';

          echo '<label for="mobile">mobile</label><br>';
          echo '<input type="text" name="mobile" value="'.$donnee['mobile'].'"><br/>';

          echo '<label for="fix">fix</label><br>';
          echo '<input type="text" name="fix" value="'.$donnee['fix'].'"><br/>';

          echo '<label for="avatar">avatar</label><br>';
          echo '<input type="text" name="avatar" value="'.$donnee['avatar'].'"><br/>';
        }else{
          echo '<abc>pseudo : '.$donnee['pseudo'].'</abc><br/>';
          echo '<abc>nom : '.$donnee['nom'].'</abc><br/>';
          echo '<abc>prenom : '.$donnee['prenom'].'</abc><br/>';
          echo '<abc>mail : '.$donnee['mail'].'</abc><br/>';
          echo '<abc>adresse : '.$donnee['adresse'].'</abc><br/>';
          echo '<abc>code postal : '.$donnee['code_postal'].'</abc><br/>';
          echo '<abc>ville : '.$donnee['ville'].'</abc><br/>';
          echo (empty($donnee['fix']))? '<abc>fix : Non renseigner</abc><br/>' : '<abc>fix : '.$donnee['fix'].'</abc><br/>';
          echo (empty($donnee['mobile']))? '<abc>mobile : Non renseigner</abc><br/>' : '<abc>mobile : '.$donnee['mobile'].'</abc><br/>';
        }

    if(isset($edition) && !isset($acces)){
      echo '<input type="submit" name="submit" value="Enregistrer"><br/>';
      echo '</form>';
    }else{
      if(!isset($acces)){
        echo '<a href="'.$this->url('admin_monCompte_edition').'"><button>Modifier</button></a><br/>';
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
