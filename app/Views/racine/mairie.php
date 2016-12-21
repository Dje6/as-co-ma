<?php $this->layout('layout', ['title' => 'AS-CO-MA - Mairie']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_mairie.css'); ?>">
<?php $this->stop('main_head') ?>


<?php $this->start('main_content') ?>

<?php if($slug == 'All') { ?>

	<div class="row">
		<!-- Formulaire pour rechercher mairie -->
		<form class="formFront form-inline" action="<?php echo $this->url('racine_mairie_search',['orga'=>'Mairie','slug' => $slug]) ; ?>" method="post">
			<!-- Recherche par CP -->
			<div class="form-group">
				<label for="cp">Saisissez le code postal ou le numéro de département de la Mairie recherchée : </label>
				<input type="text" class="form-control" name="cp" value="" width="20%">

				<input type="hidden" class="form-control" name="capcha" value="">
			</div>

			<button type="submit" class="btn btn-success btn-md" name="submit">Rechercher</button>
		</form>
	</div>

<!-- Quand recherche soumise, affiche liens vers Mairie concernée -->
<br>
<div class="row text-center">
	<?php if(isset($donnees)) {
		if(is_array($donnees)) {
			foreach ($donnees as $key => $value) { ?>
					<a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => $value['slug']]) ; ?>">
						<button class="btn btn-success btn-sm"><?php echo $value['code_postal'].', '.$value['nom']; ?></button>
					</a>

	<?php }
		} else {
			echo '<span class="errorForm">' . $donnees . '</span>';
		}
	} ?>
</div>

<?php
// Quand lien cliqué, affiche les infos de la mairie
} else{

	if(isset($donnees)){
		if(is_array($donnees)){ ?>

			<h2>Vous êtes sur la page de la <?php echo $this->unslug($slug); //unslug du slug mairie ?></h2>

			<li><a href="<?php echo $this->url('racine_contact',['orga' => 'mairie' ,'slug' => $slug]); ?>">Contacter la Mairie</a></li>

<?php	echo '<article>';
			echo $donnees['nom'].'<br/>';
			echo $donnees['adresse'].'<br/>';
			echo $donnees['code_postal'].'<br/>';
			echo $donnees['ville'].'<br/>';
			echo '<a href="tel:'.$donnees['fix'].'">'.$donnees['fix'].'</a><br/>';
				foreach (unserialize($donnees['horaire']) as $key => $value) {
					echo $key.' : '.$value.'<br/>';
				}
			echo '<a href="mailto:'.$donnees['mail'].'">'.$donnees['mail'].'</a><br/>';
			echo '</article><br/><br/>';
		} else {
			echo $donnees;
		}
	}
} ?>

<!-- Lien vers contact d'inscription de mairie -->
<br>
<div class="row">
	<blockquote class="quoteMairie blockquote-reverse">
		<p><i>
			Vous souhaitez inscrire votre Mairie et pouvoir remplir vos informations ?
			<a href='<?php echo $this->url('racine_contact',['orga' => 'All', 'slug' => 'All']) ;?>'>Contactez-nous !</a></i>
		</p>
		<footer><strong>Les Administrateurs</strong>, <cite title="Les Administrateurs">AS-CO-MA</cite></footer>
	</blockquote>
</div>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
