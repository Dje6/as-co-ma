<!-- PAGE DE FORMULAIRE D'INSCRIPTION SUR LE SITE -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Inscription']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>

<?php if(isset($confirmation)) { ?>
  <div class="row">
    <h2 class="confirmForm"><?= $confirmation ?></h2>
  </div>

<?php } else { ?>

  <div class="row">
    <form class="formFront" action="<?php echo $this->url('racine_inscriptPost'); ?>" method="POST">
      <legend><h2 class="text-center"><strong>Créez votre compte sur AS-CO-MA : </strong></h2></legend>

      <?php if(isset($error['capcha'])){ echo '<span class="errorForm">'.$error['capcha'].'</span>' ;} ?>
      <?php if(isset($error['donnee'])){ echo '<span class="errorForm">'.$error['donnee'].'</span>' ;} ?>

      <!-- PSEUDO obligatoire -->
      <div class="form-group">
        <label for="pseudo">Pseudo * : </label>
        <span class="errorForm"><?php if(isset($error['pseudo'])) { echo $error['pseudo']; } ?></span>
        <input type="text" class="form-control" name="pseudo" value="<?php if(isset($saisi['pseudo'])) { echo $saisi['pseudo']; } ?>">
      </div>
      <br>

      <!-- EMAIL  obligatoire -->
      <div class="form-group">
        <label for="mail">Adresse Mail * : </label>
        <span class="errorForm"><?php if(isset($error['mail'])) { echo $error['mail']; } ?></span>
        <input type="text" class="form-control" name="mail" placeholder="exemple@mail.com" value="<?php if(isset($saisi['mail'])) { echo $saisi['mail']; } ?>">
      </div>
      <br>

      <!-- PASSWORD obligatoire -->
      <div class="form-group">
        <label for="password">Mot de passe * : </label>
        <span class="errorForm"><?php if(isset($error['password'])) { echo $error['password']; } ?></span>
        <input type="password" class="form-control" name="password" placeholder="5 caractères minimum" value="<?php if(isset($saisi['password'])) { echo $saisi['password']; } ?>">
      </div>
      <br>

      <!-- REPEAT PASSWORD sécurité correspondance -->
      <div class="form-group">
        <label for="r_password">Répétez votre mot de passe * : </label>
        <span class="errorForm"><?php if(isset($error['r_password'])){ echo $error['r_password']; } ?></span>
        <input type="password" class="form-control" name="r_password" placeholder="5 caractères minimum" value="<?php if(isset($saisi['r_password'])) { echo $saisi['r_password']; } ?>">
      </div>
      <br>

      <!-- Infos persos de l'utilisateur  -->
      <fieldset>
        <legend class="text-center">Informations Personnelles</legend>

        <!-- NOM FAMILLE obligatoire -->
        <div class="form-group col-xs-6">
          <label for="nom">NOM * : </label>
          <span class="errorForm"><?php if(isset($error['nom'])) { echo $error['nom']; } ?></span>
          <input type="text" class="form-control" name="nom" value="<?php if(isset($saisi['nom'])){ echo $saisi['nom']; } ?>">
        </div>

        <!-- PRENOM obligatoire -->
        <div class="form-group col-xs-6">
          <label for="prenom">Prénom * : </label>
          <span class="errorForm"><?php if(isset($error['prenom'])){ echo $error['prenom']; } ?></span>
          <input type="text" class="form-control" name="prenom" value="<?php if(isset($saisi['prenom'])){ echo $saisi['prenom'] ;} ?>">
        </div>

        <!-- ADRESSE obligatoire -->
        <div class="form-group col-xs-6">
          <label for="adresse">Adresse * : </label>
          <span class="errorForm"><?php if(isset($error['adresse'])){ echo $error['adresse']; } ?></span>
          <input type="text" class="form-control" name="adresse" value="<?php if(isset($saisi['adresse'])){ echo $saisi['adresse'] ;} ?>">
        </div>

        <!-- CODE POSTAL obligatoire -->
        <div class="form-group col-xs-6">
          <label for="code_postal">Code Postal * : </label>
          <span class="errorForm"><?php if(isset($error['code_postal'])){ echo $error['code_postal']; } ?></span>
          <input type="text" class="form-control" name="code_postal" value="<?php if(isset($saisi['code_postal'])){ echo $saisi['code_postal']; } ?>">
        </div>

        <!-- VILLE obligatoire -->
        <div class="form-group col-xs-12">
          <label for="ville">Ville * : </label>
          <span class="errorForm"><?php if(isset($error['ville'])){ echo $error['ville']; } ?>
          <input type="text" class="form-control" name="ville" value="<?php if(isset($saisi['ville'])){ echo $saisi['ville'] ;} ?>">
        </div>

        <!-- TELEPHONE -->
        <div class="form-group col-xs-6">
          <label for="fix">Téléphone : </label>
          <span class="errorForm"><?php if(isset($error['fix'])){ echo $error['fix']; } ?></span>
          <input type="text" class="form-control" name="fix" value="<?php if(isset($saisi['fix'])){ echo $saisi['fix'] ;} ?>">
        </div>

          <!-- MOBILE -->
          <div class="form-group col-xs-6">
            <label for="mobile">Mobile : </label>
            <span class="errorForm"><?php if(isset($error['mobile'])){ echo $error['mobile']; } ?>
            <input type="text" class="form-control" name="mobile" value="<?php if(isset($saisi['mobile'])){ echo $saisi['mobile'] ;} ?>">
          </div>
          <br>

      </fieldset>

      <input type="hidden" name="capcha" value=""><br/>
      <button type="submit" name="submit" class="btn btn-success btn-lg col-xs-offset-5">Créer mon compte</button>

    </form>
  </div>
<?php } ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
<!-- //ici les script js de la Page courante UNIQUEMENT
//si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
