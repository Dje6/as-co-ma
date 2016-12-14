<?php $this->layout('layout', ['title' => 'Connexion']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<h1>Page inscription</h1><br/>

<?php if(isset($confirmation)){
  echo $confirmation;

}else{ ?>
  <form action="<?php echo $this->url('racine_inscriptPost'); ?>" method="POST">

    <?php if(isset($error['capcha'])){ echo '<span>'.$error['capcha'].'</span>' ;} ?>
    <?php if(isset($error['donnee'])){ echo '<span>'.$error['donnee'].'</span>' ;} ?>

    <label for="pseudo">Pseudo* : <?php if(isset($error['pseudo'])){ echo '<span>'.$error['pseudo'].'</span>' ;} ?>
    <br/><input type="text" name="pseudo" value="<?php if(isset($saisi['pseudo'])){ echo $saisi['pseudo'] ;} ?>"></label><br/>

    <label for="mail">mail* : <?php if(isset($error['mail'])){ echo '<span>'.$error['mail'].'</span>' ;} ?>
    <br/><input type="text" name="mail" value="<?php if(isset($saisi['mail'])){ echo $saisi['mail'] ;} ?>"></label><br/>

    <label for="password">Mot de passe* : <?php if(isset($error['password'])){ echo '<span>'.$error['password'].'</span>' ;} ?>
    <br/><input type="text" name="password" value="<?php if(isset($saisi['password'])){ echo $saisi['password'] ;} ?>"></label><br/>

    <label for="r_password">Mot de passe* : <?php if(isset($error['r_password'])){ echo '<span>'.$error['r_password'].'</span>' ;} ?>
    <br/><input type="text" name="r_password" value="<?php if(isset($saisi['r_password'])){ echo $saisi['r_password'] ;} ?>"></label><br/>

    <label for="nom">Nom* : <?php if(isset($error['nom'])){ echo '<span>'.$error['nom'].'</span>' ;} ?>
    <br/><input type="text" name="nom" value="<?php if(isset($saisi['nom'])){ echo $saisi['nom'] ;} ?>"></label><br/>

    <label for="prenom">Prenom* : <?php if(isset($error['prenom'])){ echo '<span>'.$error['prenom'].'</span>' ;} ?>
    <br/><input type="text" name="prenom" value="<?php if(isset($saisi['prenom'])){ echo $saisi['prenom'] ;} ?>"></label><br/>

    <label for="adresse">Adresse* : <?php if(isset($error['adresse'])){ echo '<span>'.$error['adresse'].'</span>' ;} ?>
    <br/><input type="text" name="adresse" value="<?php if(isset($saisi['adresse'])){ echo $saisi['adresse'] ;} ?>"></label><br/>

    <label for="code_postal">Code postal* : <?php if(isset($error['code_postal'])){ echo '<span>'.$error['code_postal'].'</span>' ;} ?>
    <br/><input type="text" name="code_postal" value="<?php if(isset($saisi['code_postal'])){ echo $saisi['code_postal'] ;} ?>"></label><br/>

    <label for="ville">Ville* : <?php if(isset($error['ville'])){ echo '<span>'.$error['ville'].'</span>' ;} ?>
    <br/><input type="text" name="ville" value="<?php if(isset($saisi['ville'])){ echo $saisi['ville'] ;} ?>"></label><br/>

    <label for="fix">Telephone : <?php if(isset($error['fix'])){ echo '<span>'.$error['fix'].'</span>' ;} ?>
    <br/><input type="text" name="fix" value="<?php if(isset($saisi['fix'])){ echo $saisi['fix'] ;} ?>"></label><br/>

    <label for="mobile">Mobile : <?php if(isset($error['mobile'])){ echo '<span>'.$error['mobile'].'</span>' ;} ?>
    <br/><input type="text" name="mobile" value="<?php if(isset($saisi['mobile'])){ echo $saisi['mobile'] ;} ?>"></label><br/>

    <input type="hidden" name="capcha" value=""><br/>

    <input type="submit" name="" value="inscription">
  </form>
  <?php
} ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
