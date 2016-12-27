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
  if(is_array($donnee)){ //si la base de donnee retourne un array
    ?>
      <div class="container-fluid">
        <div class="row ">
         <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
            <div class="panel panel-info">
              <div class="panel-heading"><?php
                echo '<h3 classe"userpseudo">Votre Pseudo  : '.$_SESSION['user']['pseudo'].'</h3><br/>'; ?>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 col-lg-12 " align="center">
                    <!-- <img alt="User Pic" src="<?php //echo $donnee['avatar'] ; ?>" class="img-circle img-responsive"> -->
                    <img alt="User Pic" src="https://cdn.pixabay.com/photo/2012/04/13/21/07/user-33638_960_720.png"
                    class="img-circle img-responsive col-md-3">
                    <div class=" col-md-9 col-lg-9 cartevisite">

                      <?php
                        if(isset($edition) && !isset($acces)){ ?>
                          <form method="POST" action="<?php echo $this->url('admin_monCompte_edition_post') ; ?>">
                            <table class="table table-user-information">
                              <tbody>


                              <?php if(isset($error['nom']) && !empty($error['nom'])){ echo '<tr><td>Erreur </td><td>'.$error['nom'].'</td></tr>'; } ?>
                              <tr><td><label class ="couleur_bleue"for="nom">Nom</label></td>
                              <td><input type="text" name="nom" value="<?php echo $donnee['nom'] ; ?>"><td/></tr>

                              <?php if(isset($error['prenom'])&& !empty($error['prenom'])){ echo '<tr><td>Erreur </td><td>'.$error['prenom'].'</td></tr>'; } ?>
                              <tr><td><label class ="couleur_bleue" for="prenom">Prenom</label></td>
                              <td><input type="text" name="prenom" value="<?php echo $donnee['prenom'] ; ?>"><td/></tr>

                              <?php if(isset($error['mail'])&& !empty($error['mail'])){ echo '<tr><td>Erreur </td><td>'.$error['mail'].'</td></tr>'; } ?>
                              <tr><td><label class ="couleur_bleue" for="mail">mail</label></td>
                              <td><input type="text" name="mail" value="<?php echo $donnee['mail'] ; ?>"><td/></tr>

                              <?php if(isset($error['adresse'])&& !empty($error['adresse'])){ echo '<tr><td>Erreur </td><td>'.$error['adresse'].'</td></tr>'; } ?>
                              <tr><td><label class ="couleur_bleue" for="adresse">adresse</label></td>
                              <td><input type="text" name="adresse" value="<?php echo $donnee['adresse'] ; ?>"><td/></tr>

                              <?php if(isset($error['code_postal'])&& !empty($error['code_postal'])){ echo '<tr><td>Erreur </td><td>'.$error['code_postal'].'</td></tr>'; } ?>
                              <tr><td><label class ="couleur_bleue" for="code_postal">code postal</label></td>
                              <td><input type="text" name="code_postal" value="<?php echo $donnee['code_postal'] ; ?>"><td/></tr>

                              <?php if(isset($error['ville'])&& !empty($error['ville'])){ echo '<tr><td>Erreur </td><td>'.$error['ville'].'</td></tr>'; } ?>
                              <tr><td><label class ="couleur_bleue" for="ville">ville</label></td>
                              <td><input type="text" name="ville" value="<?php echo $donnee['ville'] ; ?>"><td/></tr>

                              <?php if(isset($error['mobile'])&& !empty($error['mobile'])){ echo '<tr><td>Erreur </td><td>'.$error['mobile'].'</td></tr>'; } ?>
                              <tr><td><label class ="couleur_bleue" for="mobile">mobile</label></td>
                              <td><input type="text" name="mobile" value="<?php echo $donnee['mobile'] ; ?>"><td/></tr>

                              <?php if(isset($error['fix'])&& !empty($error['fix'])){ echo '<tr><td>Erreur </td><td>'.$error['fix'].'</td></tr>'; } ?>
                              <tr><td><label class ="couleur_bleue" for="fix">fix</label></td>
                              <td><input type="text" name="fix" value="<?php echo $donnee['fix'] ; ?>"><td/></tr>

                              </tbody>
                            </table>
                              <input type="submit" name="submit" class="btn btn-success" value="Enregistrer">
                        </form>
                    </div> <?php
                          }else{ ?>

                            <form method="POST" enctype="multipart/form-data" action="<?php echo $this->url('admin_monCompte_edition_avatar_post') ; ?>">
                              <input type="file" name="image" value="image"/>
                              <input type="submit" value="Changer d'avatar"/>
                            </form>

                            <table class="table table-user-information">
                              <tbody>

                            <tr><td class ="couleur_bleue">Nom:</td><td><?php echo $donnee['nom'] ; ?></td></tr>
                            <tr><td class ="couleur_bleue">Prénom</td><td><?php echo $donnee['prenom'] ; ?></td></tr>
                            <tr><td class ="couleur_bleue">Email</td><td><a href="mailto:<?php echo $donnee['mail'] ; ?>"><?php echo $donnee['mail'] ; ?></a></td></tr>
                            <tr><td class ="couleur_bleue">Adresse</td><td><?php echo $donnee['adresse'] ; ?></td></tr>
                            <tr><td class ="couleur_bleue">Code postal</td><td><?php echo $donnee['code_postal'] ; ?></td></tr>
                            <tr><td class ="couleur_bleue">Ville</td><td><?php echo $donnee['ville'] ; ?></td></tr> <?php
                            echo (empty($donnee['fix']))? '<tr><td class ="couleur_bleue">Téléphone </td><td>Non renseigné</td></tr>' : '<tr><td>Téléphone </td><td> '.$donnee['fix'].'</td></tr>';
                            echo (empty($donnee['mobile']))? '<tr><td class ="couleur_bleue">Portable </td><td>Non renseigné</td></tr>' : '<tr><td>Portable </td><td> '.$donnee['mobile'].'</td></tr>';

                        ?></tbody>
                        </table>
                      </div><?php
                            if(!isset($acces)){
                              echo '<span class="centrer"><a href="'.$this->url('admin_monCompte_edition').'"><button class="btn btn-primary">EDITER</button></a>';
                              echo '<a href="'.$this->url('admin_monCompte_edition').'"><button class="btn btn-danger">SUPPRIMER</button></a></span><br/>';
                              // echo'<a href="#" class="btn btn-info return">Retour en haut</a>';
                            }
                          } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <?php
  }else{
    echo '<p>'.$donnee.'</p>';
  }
  echo '</div>';
}

?>
<a href="#" class="btn btn-info return">Retour en haut</a>
<?php $this->stop('main_content') ?>

<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
