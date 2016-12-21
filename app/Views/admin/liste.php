<?php $this->layout('layout_back', ['title' => 'Liste','slug' => $slug,'orga' => $orga]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1 class="titreback">Administration</h1><br/><?php
// liste soccupe dafficher les bouton dans liste menbre et liste association , sur le back
echo '<div class="container affichage">';
if($orga == 'mairie'){
  if(isset($donnee)){
    if(is_array($donnee)){
      echo '<table>';
      foreach ($donnee as $key => $value) { ?>
        <tr>
          <td><?php echo $value['nom']; ?></td>
          <td><a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]);?>"><button class="btn btn-info bouge">Consulter</button></a></td>
          <td><a href="<?php echo $this->url('admin_mairie_contact_assoc',['slugE' => $slug,'slugR' => $value['slug']]);?>"><button class="btn btn-info bouge">Contacter</button></a></td>
          <?php if($value['status'] == 'Actif'){ ?>
            <td><a href="<?php echo $this->url('admin_mairie_edit_status',['slug' => $slug,'slugA' => $value['slug']]);?>"><button class="btn btn-warning bouge">Suspendre</button></a></td>
          <?php }else { ?>
            <td><a href="<?php echo $this->url('admin_mairie_edit_status',['slug' => $slug,'slugA' => $value['slug']]);?>"><button class="btn btn-success bouge">Activer</button></a></td>
          <?php } ?>
          <td><a href="<?php echo $this->url('admin_mairie_delete_assoc',['slug' => $slug, 'slugA' => $value['slug']]);?>"><button class="btn btn-danger bouge">Supprimer</button></a></td>

        </tr><?php
      }
      echo '</table>';
    }else{
      echo $donnee;
    }
  }
}elseif ($orga == 'assoc') {
  if(isset($donnee)){
    if(is_array($donnee)){
      echo '<table>';
      foreach ($donnee as $key => $value) { ?>

        <tr>

          <td class="bouge"><?php echo $value['pseudo'].' : '.$value['role']; ?></td>

          <td><a href="<?php echo $this->url('admin_assoc_membre',['slug' => $slug ,'id' => $value['id']]) ;?>"><button class="btn btn-info bouge">Consulter</button></a></td>
          <td><a href="<?php echo $this->url('admin_assoc_contact_membre',['slugE' => $slug,'id' => $value['id']]);?>"><button class="btn btn-info bouge">Contacter</button></a></td>
          <td><a href="<?php echo $this->url('admin_assoc_edit_user_role',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-warning bouge">Suspendre</button></a></td>
          <td><a href="<?php echo $this->url('admin_assoc',['slug' => $value['slug']]);?>"><button class="btn btn-danger bouge">Supprimer</button></a></td>
        </tr>
        <?php

      }
      echo '</table>';
    }else{
      echo $donnee;
    }
  }
}
echo '</div>';
?>
<a href="#" class="btn btn-info return">Retour en haut</a>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
