<?php $this->layout('layout_back', ['title' => 'User','orga' => isset($orga),'slug' => isset($slug)]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->
<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>

<?php

if(isset($acces)){
  echo '<h1 class="titreusers">Information du membre</h1><br/>';
}else{
echo '<h1 class="titreusers">Vos informations personnelles</h1><br/>';
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
        }else{ ?>
          <div class="container">
            <div class="row alignement">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-6 toppad" >
                <div class="panel panel-info">
                  <div class="panel-heading"><?php
                    echo '<h3 classe"userpseudo">Votre Pseudo  : '.$donnee['pseudo'].'</h3><br/>'; ?>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-12 col-lg-12 " align="center">
                        <!-- <img alt="User Pic" src="<?php //echo $donnee['avatar'] ; ?>" class="img-circle img-responsive"> -->
                        <img alt="User Pic" src="https://cdn.pixabay.com/photo/2012/04/13/21/07/user-33638_960_720.png"
                        class="img-circle img-responsive col-md-3">
                        <div class=" col-md-9 col-lg-9 cartevisite">
                          <table class="table table-user-information">
                            <tbody>
                              <tr><td>Nom:</td><td><?php echo $donnee['nom'] ; ?></td></tr>
                              <tr><td>Prénom</td><td><?php echo $donnee['prenom'] ; ?></td></tr>
                              <tr><td>Email</td><td><a href="mailto:<?php echo $donnee['mail'] ; ?>"><?php echo $donnee['mail'] ; ?></a></td></tr>
                              <tr><td>Adresse</td><td><?php echo $donnee['adresse'] ; ?></td></tr>
                              <tr><td>Code postal</td><td><?php echo $donnee['code_postal'] ; ?></td></tr>
                              <tr><td>Ville</td><td><?php echo $donnee['ville'] ; ?></td></tr> <?php
                              echo (empty($donnee['fix']))? '<tr><td>Téléphone : </td><td>Non renseigné</td></tr>' : '<tr><td>Téléphone :</td><td> '.$donnee['fix'].'</td></tr>';
                              echo (empty($donnee['mobile']))? '<tr><td>Portable : </td><td>Non renseigné</td></tr>' : '<tr><td>Portable :</td><td> '.$donnee['mobile'].'</td></tr>'; ?>
                            </tbody>
                          </table><?php
                          if(isset($edition) && !isset($acces)){
                            echo '<input type="submit" name="submit" value="Enregistrer"><br/>';
                            echo '</form>';
                          }else{
                            if(!isset($acces)){
                              echo '<span class="centrer"><a href="'.$this->url('admin_monCompte_edition').'"><button >EDITER</button></a>';
                              echo '<a href="'.$this->url('admin_monCompte_edition').'"><button >SUPPRIMER</button></a></span>';
                            }
                          } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> <?php
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
