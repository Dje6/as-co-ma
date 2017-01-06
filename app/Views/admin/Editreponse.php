
<?php

if($w_current_route == 'admin_repondre_User'){
  $urldePost = $this->url($w_current_route,['id' => $leMessage['id']]);
  $quiContacter = '<div class="col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1 col-centered couleur_bleue"><h3 class="titrecontact"> Répondre à '.$this->unslug($leMessage['emeteur_pseudo']).'</h3></div>';
  $orga = NULL;
}elseif($w_current_route == 'admin_repondre'){
  $urldePost = $this->url($w_current_route,['id' => $leMessage['id'],'slug' => $slug,'orga' => $orga]);
  $quiContacter = '<div class="col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1 col-centered couleur_bleue"><h3 class="titrecontact"> Répondre à '.$this->unslug($leMessage['emeteur_pseudo']).'</h3></div>';
}

$this->layout('layout_back', ['title' => 'Message','slug' => $slug,'orga' => $orga]);
?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>

	<h3><?php echo $quiContacter ;?></h3><br/>

<?php
if(!isset($confirmation)){ ?>

<!-- // debut du formulaire intégré -->

<div class="container-fluid fichecontact">
  <div class="row">
    <div class="col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1 col-centered ">
      <div class="panel panel-default">
        <form class="" action="<?php echo $urldePost; ?>" method="post">
          <div class="panel-body">

            <div class="form-group">
            <?php if(isset($error['destinataire_mailOrId'])){ echo '<span style="color:red;">'.$error['destinataire_mailOrId'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope blue"></i></span>
                <input type="text" name="destinataire_mailOrId" placeholder="Destinataire" class="form-control" value="<?php echo $mailRecepteur ;?>" readonly>
              </div>
            </div>

            <div class="form-group">
              <?php if(isset($error['objet'])){ echo '<span style="color:red;">'.$error['objet'].'</span>' ;} ?><br/>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
                <input type="text" name="objet" placeholder="Objet" class="form-control" autofocus="autofocus" value="<?php if(isset($donnee['objet'])){
                        echo $donnee['objet'] ;
                      }elseif(isset($leMessage['objet'])){
                        echo 'Re:'.$leMessage['objet'];
                      } ?>" readonly>
              </div>
            </div>

            <div class="form-group">
              <p class="couleur_bleue">Message reçu le : </p><?php echo $leMessage['date_envoi']; ?><br/>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-comment blue"></i></span>
                <textarea name="contenu" rows="6" cols="80" class="form-control"><?php if(isset($leMessage['contenu'])){ echo $leMessage['contenu'] ; } ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <?php if(isset($error['contenu'])){ echo '<span style="color:red;">'.$error['contenu'].'</span>' ;} ?><br/>
                <p class="couleur_bleue">Votre réponse : </p>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-comment blue"></i></span>
                <textarea name="contenu" rows="6" cols="80" class="form-control" type="text" required><?php if(isset($donnee['contenu'])){ echo $donnee['contenu'] ; } ?></textarea>
              </div>
            </div>

            <div class="">
              <input type="hidden" name="capcha" value="">
              <input type="submit" name="submit" class="btn btn-info pull-right" value="Envoyer">
              <button type="reset" value="Reset" name="reset" class="btn couleur_bleue">Effacer <span class="glyphicon glyphicon-refresh"></span></button>
            </div>
          </div>
        </form>
      </div>
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
