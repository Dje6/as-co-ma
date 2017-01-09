<?php
$this->layout('layout_back', ['title' => 'AS-CO-MA - News','slug' => $slug,'orga' => $orga]);
 ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>

<?php
if(isset($id) && !empty($id)){
  $urlPost = $this->url($w_current_route,['slug' => $slug,'orga' => $orga,'id' => $id]);
}else {
  $urlPost = $this->url($w_current_route,['slug' => $slug,'orga' => $orga]);
}
if(!isset($confirmation)){ ?>

<!-- // debut du formulaire intégré -->

<div class="container-fluid col-md-10 col-md-offset-2 fichecontact">
    <div class="col-md-10 col-md-offset-2 col-centered ">
      <div class="panel panel-default ">
        <form class="" enctype="multipart/form-data"  action="<?php echo $urlPost; ?>" method="post">
          <div class="panel-body">

            <div class="form-group">
              <?php if(isset($error['title'])){ echo '<span style="color:red;">'.$error['title'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon">Titre</span>
                <input type="text" name="title" placeholder="Titre" class="form-control"
                value="<?php if(isset($donnee['title'])){ echo $donnee['title'] ; } ?>">
              </div>
            </div>

            <div class="form-group">
              <?php if(isset($error['content'])){ echo '<span style="color:red;">'.$error['content'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon">Contenu</span>
                <textarea name="content" rows="6" cols="80" class="form-control" placeholder="Contenu"
                type="text"><?php if(isset($donnee['content'])){ echo $donnee['content'] ; } ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <?php if(isset($error['status'])){ echo '<span style="color:red;">'.$error['status'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon">En ligne ? </span>

                  <select name="status" class="form-control">
                    <option value="Activer" <?php if(isset($donnee['status']) && !empty($donnee['status'])
                    && $donnee['status'] == 'Activer'){ echo 'selected' ; } ?>>Oui</option>
                    <option value="Desactiver" <?php if(isset($donnee['status']) && !empty($donnee['status'])
                    && $donnee['status'] == 'Desactiver'){ echo 'selected' ; } ?>>Non</option>
                  </select>
              </div>
            </div>

            <div class="form-group">
              <?php if(isset($error['picture'])){ echo '<span style="color:red;">'.$error['picture'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon">Image</span>
                <input type="file" name="image" class="form-control" value=""/>
              </div>
            </div>

            <div class="">
              <input type="hidden" name="capcha" value="">
              <input type="submit" name="submit" class="btn btn-info pull-right" value="envoyer">
              <button type="reset" value="Reset" name="reset" class="btn">Effacer
                <span class="glyphicon glyphicon-refresh"></span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
<!-- // fin du formulaire intégré -->
<?php
}else {
	echo $confirmation;
} ?>
<?php $this->stop('main_content') ?>

<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
