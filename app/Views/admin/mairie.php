<?php $this->layout('layout_back', ['title' => 'AdminMairie','slug' => $slug,'orga' => $orga]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1 class="titreback">Administration</h1><br/>




<?php


if(isset($donnee)){
  if(is_array($donnee)){
    if(isset($edition) && !isset($acces)){ ?>

      <div class="container fichecontact">
        <div class="row">
          <div class="col-sm-6 col-centered ">
            <div class="panel panel-default">

              <form method="POST" action ="<?php echo $this->url('admin_mairie_edit_post', ['slug' => $slug]);?>">
                <div class="panel-body">

                  <div class="form-group">
                    <div class="input-group"
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
                      <?php if(isset($error['nom'])){ echo '<span>'.$error['nom'].'</span><br>' ;} ?>
                      <input type="text" name="nom" value="<?php echo $donnee['nom']?>"><br>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group"
                      <span class="input-group-addon"><i class="glyphicon glyphicon glyphicon-road blue"></i></span>
                      <?php if(isset($error['adresse'])){ echo '<span>'.$error['adresse'].'</span><br>' ;} ?>
                      <input type="text" name="adresse" value="<?php echo $donnee['adresse']?>"><br>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group"
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope blue"></i></span>
                      <?php if(isset($error['code_postal'])){ echo '<span>'.$error['code_postal'].'</span><br>' ;} ?>
                      <input type="text" name="code_postal" value="<?php echo $donnee['code_postal']?>"><br>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group"
                      <span class="input-group-addon"><i class="glyphicon glyphicon glyphicon-home blue"></i></span>
                      <?php if(isset($error['ville'])){ echo '<span>'.$error['ville'].'</span><br>' ;} ?>
                      <input type="text" name="ville" value="<?php echo $donnee['ville']?>"><br>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group"
                      <span class="input-group-addon"><i class="glyphicon glyphicon glyphicon-earphone blue"></i></span>
                      <?php if(isset($error['fix'])){ echo '<span>'.$error['fix'].'</span><br>' ;} ?>
                      <input type="text" name="fix" value="<?php echo $donnee['fix']?>"><br>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group"
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope blue"></i></span>
                      <?php if(isset($error['mail'])){ echo '<span>'.$error['mail'].'</span><br>' ;} ?>
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
      echo '<h3>Statut : '.$donnee['status'].'</h3><br/>';
      echo '<h3>Horaire d\'ouverture: ';
      foreach (unserialize($donnee['horaire']) as $key => $value) {
        echo '<div class="horaires"><h4>'.$key.' : '.$value.'</h4></div>';
      }
      if(!isset($acces)){
        echo '<a href="'.$this->url('admin_mairie_edit_form', ['slug' => $slug]).'"><button class="centerBut">Modifier</button></a>';
        

        echo '<div class="container ">
                <div class="row">

                </div>
              </div>';


     echo '</div">';
      }
    }
  }else{
    echo '<p>'.$donnee.'</p>';
  }
  echo '</div>';
}
?>





<a href="#" class="btn btn-info return">Retour Menu</a>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
