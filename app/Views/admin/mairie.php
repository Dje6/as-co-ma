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
                <div class="panel-body">

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

                  <?php if(isset($creation)){ ?>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Ville</span>
                      <?php if(isset($error['ville']) && !empty($error['ville']) ){ echo '<span>'.$error['ville'].'</span><br>' ;} ?>
                      <input type="text" name="ville" value="<?php echo $donnee['ville']?>"><br>
                    </div>
                  </div>
                  <?php }else { ?>
                          <input type="hidden" name="ville" value="<?php echo $donnee['ville']?>" readonly>
                  <?php } ?>

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



                  <input type="submit" name="submit" class="btn btn-info pull-right" value="Enregistrer"><br>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php
    }else {
     echo '<div class="container affichageMairie">';
      echo '<h3 class="centragetitre"> '.$donnee['nom'].'</h3><br/>';

      echo '<h3>Adresse : '.$donnee['adresse'].'</h3>';
      echo '<h3>Code Postal : '.$donnee['code_postal'].'</h3>';
      echo '<h3>ville : '.$donnee['ville'].'</h3>';
      echo '<h3>Téléphone : '.$donnee['fix'].'</h3>';


      echo '</h3><br>';
      echo '<h3>Email : '.$donnee['mail'].'</h3><br/>';
      if(is_array($donnee['horaire'])){
        echo '<h3>Horaire d\'ouverture: ';
        foreach (unserialize($donnee['horaire']) as $key => $value) {
          echo '<div class="horaires"><h4>'.$key.' : '.$value.'</h4></div>';
        }
      }else {
        echo '<h3>Horaire d\'ouverture: Non renseigné';
      }
      echo '<h3>Statut : '.$donnee['status'].'</h3><br/>';
      if(!isset($acces)){

        echo '<a href="'.$this->url('admin_mairie_edit_form', ['slug' => $slug]).'">
        <button class="btn btn-primary centerBut">Modifier</button></a>';

     echo '</div">';

      }
    }
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
