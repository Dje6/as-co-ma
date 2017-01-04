<?php
if(isset($creation)){
  $this->layout('layout_back', ['title' => 'AdminAssoc','slug' => $slug,'orga' => $orga,'creation' => true]) ;
}else {
  $this->layout('layout_back', ['title' => 'AdminAssoc','slug' => $slug,'orga' => $orga]);
}  ?>
<!-- //tableau de donnee que l'on peut faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1 class="titreback ">Administration</h1><br/><?php

if(isset($donnee)){
  if(is_array($donnee)){
    if(isset($edition) && !isset($acces)){
      if(isset($bug)){ echo $bug ; } ?>

      <div class="container fichecontact">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
              <form method="POST" enctype="multipart/form-data" action="<?php echo $this->url('admin_assoc_edit_post',['slug' => $slug]);?>">
                <div class="panel-body"><?php

                if(isset($creation)){ ?>
                  <div class="form-group">
                    <div class="input-group">
                      <?php if(isset($error['nom']) && !empty($error['nom'])){ echo '<span>'.$error['nom'].'</span><br>' ;} ?>
                      <span class="input-group-addon">Nom</span>
                      <input type="text" name="nom" class="form-control" value="<?php echo $donnee['nom'] ; ?>">
                    </div>
                  </div><?php
                } ?>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Adresse</i></span>
                      <?php if(isset($error['adresse']) && !empty($error['adresse'])){ echo '<span>'.$error['adresse'].'</span><br>' ;} ?>
                      <input type="text" name="adresse" class="form-control" value="<?php echo $donnee['adresse'] ; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Code Postal</span>
                      <?php if(isset($error['code_postal']) && !empty($error['code_postal'])){ echo '<span>'.$error['code_postal'].'</span><br>' ;} ?>
                      <input type="text" name="code_postal" class="form-control" value="<?php echo $donnee['code_postal'] ; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Ville</span>
                      <?php if(isset($error['ville']) && !empty($error['ville'])){ echo '<span>'.$error['ville'].'</span><br>' ;} ?>
                      <input type="text" name="ville" class="form-control" value="<?php echo $donnee['ville'] ; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Fix</span>
                      <?php if(isset($error['fix']) && !empty($error['fix'])){ echo '<span>'.$error['fix'].'</span><br>' ;} ?>
                      <input type="text" name="fix" class="form-control" value="<?php echo $donnee['fix'] ; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Email</span>
                      <?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span>'.$error['mail'].'</span><br>' ;} ?>
                      <input type="text" name="mail" class="form-control" value="<?php echo $donnee['mail'] ; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Description</span>
                      <?php if(isset($error['description']) && !empty($error['description'])){ echo '<span>'.$error['description'].'</span><br>' ;} ?>
                      <input type="text" name="description" class="form-control" value="<?php echo $donnee['description'] ; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class=" col-xs-12 col-md-2 ">
                        <?php if(isset($donnee['avt'])){ $avt = $donnee['avt']; }
                              elseif(isset($donnee['avatar'])){ $avt = $donnee['avatar']; }
                              else { $avt = 'img/neutre.jpg';} ?>
                        <img alt="User Pic" src="<?= $this->assetUrl($avt) ?>"
                        class="img-circle img-responsive col-xs-12"><br/>
                        <!-- //formulaire d'envoi d'image -->
                      </span>
                      <?php //if(isset($error['description']) && !empty($error['description'])){ echo '<span>'.$error['description'].'</span><br>' ;} ?>
                      <input type="file" name="avatar"  class="col-xs-12 col-sm-9" value=""/>

                      <input type="hidden" name="avt" value="<?php echo $avt ;?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class=" col-xs-12 col-md-2">
                        <?php if(isset($donnee['bg'])){ $bg = $donnee['bg']; }
                              elseif(isset($donnee['background'])){ $bg = $donnee['background']; }
                              else { $bg = 'img/neutre.jpg';} ?>

                        <img alt="User Pic" src="<?= $this->assetUrl($bg) ?>"
                        class="img-circle img-responsive col-xs-12 "><br/>
                        <!-- //formulaire d'envoi d'image -->
                      </span>
                      <?php //if(isset($error['description']) && !empty($error['description'])){ echo '<span>'.$error['description'].'</span><br>' ;} ?>
                      <input type="file" name="background" class="col-xs-12 col-sm-9" value=""/>

                      <input type="hidden" name="bg" value="<?php echo $bg ;?>">
                    </div>
                  </div>

                  <div class="">
                    <input type="submit" name="submit" class="btn btn-info pull-right" value="Enregistrer"><br>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php
    }else { ?>
      <div class="container affichageMairie">
        <div class="col-md-12 col-lg-12"><?php
          //affichage de lavatar de la mairie
          //si il ny en pas on affiche une image neutre
          if(empty($donnee['avatar'])){ $donnee['avatar'] = 'img/neutre.jpg';} ?>
          <img alt="User Pic" src="<?= $this->assetUrl($donnee['avatar']) ?>"
          class="img-circle img-responsive col-md-offset-2 col-lg-offset-2 col-md-3 col-lg-3 pad padd"><br/>
          <!-- //formulaire d'envoi d'image -->
          <?php
          if(empty($donnee['background'])){ $donnee['background'] = 'img/neutre.jpg';} ?>
          <img alt="User Pic" src="<?= $this->assetUrl($donnee['background']) ?>"
          class="img-responsive col-md-offset-2 col-lg-offset-2 col-md-3 col-lg-3 pad "><br/>
        </div>
        <div class="row">
          <div class='colxs-12 col-md-5 col-md-offset-2'>
            <?php if(empty($donnee['nom'])){ $donnee['nom'] = 'Non Renseigné' ;} ?>
              <h3 >Nom : <?php echo $donnee['nom'] ; ?></h3>
            <?php if(empty($donnee['adresse'])){ $donnee['adresse'] = 'Non Renseignée' ;} ?>
              <h3 >Adresse : <?php echo $donnee['adresse'] ;?></h3>
            <?php if(empty($donnee['code_postal'])){ $donnee['code_postal'] = 'Non Renseigné' ;} ?>
              <h3 >Code postal : <?php echo $donnee['code_postal']; ?></h3>
            <?php if(empty($donnee['ville'])){ $donnee['ville'] = 'Non Renseignée' ;} ?>
              <h3 >Ville : <?php echo $donnee['ville'] ; ?></h3>
            <?php if(empty($donnee['fix'])){ $donnee['fix'] = 'Non Renseigné' ;} ?>
              <h3 >Téléphone : <?php echo $donnee['fix'] ; ?></h3>
            <?php if(empty($donnee['mail'])){ $donnee['mail'] = 'Non Renseigné' ;} ?>
              <h3 >Email : <?php echo $donnee['mail'] ; ?></h3>
            <?php if(empty($donnee['description'])){ $donnee['description'] = 'Non Renseignée' ;} ?>
              <h3 >statut : <?php echo $donnee['status'] ; ?></h3>
              <h3 >Description : <?php echo $donnee['description'] ; ?></h3>
            <?php

            if(!isset($acces)){ ?>
              <a href="<?php echo $this->url('admin_assoc_edit_form', ['slug' => $slug]) ; ?>">
                <button class="btn btn-primary centerBut2">Modifier</button>
              </a><?php
            } ?>
          </div>
        </div>
      </div><?php
    }
  }else{ ?>
    <div class="container affichageAsso">
      <p><?php echo $donnee ; ?></p>
    </div><?php
  }
} ?>

<a href="#" class="btn btn-info return">Retour en haut</a>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
