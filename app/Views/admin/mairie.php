<?php
if(isset($creation)){
  $this->layout('layout_back', ['title' => 'AdminMairie','slug' => $slug,'orga' => $orga,'creation' => true]) ;
}else {
  $this->layout('layout_back', ['title' => 'AdminMairie','slug' => $slug,'orga' => $orga]);
}  ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1 class="titreback">Administration</h1>

<?php

if(isset($donnee)){
  if(is_array($donnee)){
    if(isset($edition) && !isset($acces)){ ?>

      <div class="container-fluid fichecontact ">
        <div class="row ">
          <div class="col-sm-8 col-sm-offset-2 col-centered ">
            <div class="panel panel-default">

              <form method="POST" action ="<?php echo $this->url('admin_mairie_edit_post', ['slug' => $slug]);?>">
                <div class="panel-body"><?php
                if(!isset($creation)){ //uniquement si la creation es deja faite ?>
                  Si suite a un regroupement communal ou un renomement de la commune ,
                  votre ville change , merci de nous contacter en cliquant sur 'Contacter Le webmaster' ci-dessu<?php
                } ?>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Adresse</span>
                      <?php if(isset($error['adresse']) && !empty($error['adresse'])){ echo '<span>'.$error['adresse'].'</span><br>' ;} ?>
                      <input type="text" name="adresse" value="<?php echo $donnee['adresse']?>"><br>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Code Postal</span>
                      <?php if(isset($error['code_postal']) && !empty($error['code_postal'])){ echo '<span>'.$error['code_postal'].'</span><br>' ;} ?>
                      <input type="text" name="code_postal" value="<?php echo $donnee['code_postal']?>"><br>
                    </div>
                  </div>

                  <?php if(isset($creation)){//visible uniquement lors de la creation ?>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Ville</span>
                      <?php if(isset($error['ville']) && !empty($error['ville']) ){ echo '<span>'.$error['ville'].'</span><br>' ;} ?>
                      <input type="text" name="ville" value="<?php echo $donnee['ville']?>"><br>
                    </div>
                  </div>
                  <?php }?>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Fix</span>
                      <?php if(isset($error['fix']) && !empty($error['fix'])){ echo '<span>'.$error['fix'].'</span><br>' ;} ?>
                      <input type="text" name="fix" value="<?php echo $donnee['fix']?>"><br>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Mail</span>
                      <?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span>'.$error['mail'].'</span><br>' ;} ?>
                      <input type="text" name="mail" value="<?php echo $donnee['mail']?>"><br>
                    </div>
                  </div>

                  <div class="form-group">Pencez a preciser 'Fermer' les jour de fermeture<br/>
                    <div class="input-group">
                      <span class="input-group-addon">Horaire</span>
                      <?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span>'.$error['mail'].'</span><br>' ;} ?>
                      <?php $horaire = unserialize($donnee['horaire']); ?>

                      <div class="input-group">
                        <span class="input-group-addon">Lundi</span>
                          <input type="text" name="horaire[Lundi]" value="<?php echo $horaire['Lundi']?>">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" >Mardi</span>
                          <input type="text" name="horaire[Mardi]" value="<?php echo $horaire['Mardi']?>">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" >Mercredi</span>
                          <input type="text" name="horaire[Mercredi]" value="<?php echo $horaire['Mercredi']?>">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" >Jeudi</span>
                          <input type="text" name="horaire[Jeudi]" value="<?php echo $horaire['Jeudi']?>">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" >Vendredi</span>
                          <input type="text" name="horaire[Vendredi]" value="<?php echo $horaire['Vendredi']?>">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" >Samedi</span>
                          <input type="text" name="horaire[Samedi]" value="<?php echo $horaire['Samedi']?>">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" >Dimanche</span>
                          <input type="text" name="horaire[Dimanche]" value="<?php echo $horaire['Dimanche']?>">
                      </div>
                    </div>
                  </div>

                  <input type="submit" name="submit" class="btn btn-info pull-right" value="Enregistrer"><br>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php
    }else { ?>
      <div class="container affichageMairie"><?php

        if(!empty($donnee['nom'])){//si le nom es vide c'est une inscritpion , on ne laffiche pas ?>
         <h3 class="centragetitre"><?php echo $donnee['nom'] ; ?></h3><?php
        }
        if(empty($donnee['adresse'])){ $donnee['adresse'] = 'Non Renseigner' ; } ?>
        <h3>Adresse : <?php echo $donnee['adresse'] ; ?></h3><?php

        if(empty($donnee['code_postal'])){ $donnee['code_postal'] = 'Non Renseigner' ; } ?>
        <h3>Code Postal : <?php echo $donnee['code_postal'] ; ?></h3><?php

        if(empty($donnee['ville'])){ $donnee['ville'] = 'Non Renseigner' ; } ?>
        <h3>ville : <?php echo $donnee['ville'] ; ?></h3><?php

        if(empty($donnee['fix'])){ $donnee['fix'] = 'Non Renseigner' ; } ?>
        <h3>Téléphone : <?php echo $donnee['fix'] ; ?></h3><?php

        if(empty($donnee['mail'])){ $donnee['mail'] = 'Non Renseigner' ; } ?>
        <h3>Email : <?php echo $donnee['mail'] ; ?></h3>

        <h3>Horaire d'ouverture: </h3><?php

          foreach (unserialize($donnee['horaire']) as $key => $value) {
            if(empty($value)){ $value = 'Non Renseigner' ; } ?>
              <div class="horaires">
                <h4><?php echo $key.' : '.$value ; ?></h4>
              </div><?php
          } ?>

        <h3>Statut : <?php echo $donnee['status'] ; ?></h3><br/><?php

        if(!isset($acces)){
          echo '<a href="'.$this->url('admin_mairie_edit_form', ['slug' => $slug]).'">
          <button class="btn btn-primary centerBut">Modifier</button></a>';
        }?>
      </div><?php
    }
  }else{ ?>
    <div class="container affichageMairie">
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
