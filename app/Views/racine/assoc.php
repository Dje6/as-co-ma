<?php $this->layout('layout', ['title' => 'AS-CO-MA - Association']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_assoc.css'); ?>">
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php if($slug == 'All'){ ?>

	<div class="row">
		<!-- Form recherche d'assoc -->
		<form class="formFront form-inline" action="<?php echo $this->url('racine_assoc_search',['orga' => $orga ,'slug' => $slug]) ; ?>" method="post">

			<div class="form-group">
				<label for="cp">Saisissez le code postal ou le nom de l'Association recherchée : </label>

				<input type="text" class="form-control" name="cp" value="">
				<input type="hidden" class="form-control" name="capcha" value="">
			</div>

			<button class="btn btn-success btn-md" type="submit" name="submit">Rechercher</button>
		</form>
	</div>

	<!-- Quand recherche soumise, affiche un lien vers Mairie concernée -->
<br>
<div class="row text-center">
<?php if(isset($donnees)) {
		if(is_array($donnees)) {
			foreach ($donnees as $key => $value) { ?>
				<a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]) ; ?>">
					<button class="btn btn-success btn-sm"><?php echo '"'.$value['nom'].'" - enregistrée en '.$value['mnom'].', '.$value['mCP']; ?></button>
				</a>
<?php }
		} else {
			echo '<span class="errorForm">' . $donnees . '</span>';
		}
	} ?>
</div>

<?php } else {
	//affichage des contenus de l'association cliquée
	if(isset($donnees)) {
		if(is_array($donnees)) { ?>
		<div class="row">

			<h2>Vous êtes sur la page de l'association <?php echo $this->unslug($slug); // unslug du slug assoc ?></h2>

			<li><a href="<?php echo $this->url('racine_contact',['orga' => 'assoc' ,'slug' => $slug]); ?>">Contacter l'association</a></li>

<?php echo '<article>';
			echo $donnees['nom'].'<br/>';
			echo $donnees['adresse'].'<br/>';
			echo $donnees['code_postal'].'<br/>';
			echo $donnees['ville'].'<br/>';
			echo '<a href="tel:'.$donnees['fix'].'">'.$donnees['fix'].'</a><br/>';
			echo '</article><br/><br/>';
		} else {
			echo $donnees;
		}
	} ?>
	</div>
	<!-- fin du display des contenus de l'association -->
<?php } ?>

<!-- Lien vers contact d'inscription d'assoc -->
<br>
<div class="row">
	<blockquote class="quoteAssoc blockquote-reverse">
		<p>
			Vous souhaitez inscrire votre Association ? <a href='<?php echo $this->url('racine_mairie',['orga' => 'All', 'slug' => 'All']) ;?>'>Cliquez ici</a> pour contacter la Mairie dont elle dépend.
		</p>
		<footer><strong>Les Administrateurs</strong>, <cite title="Les Administrateurs">AS-CO-MA</cite></footer>
	</blockquote>
</div>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT -->
  <!-- //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
