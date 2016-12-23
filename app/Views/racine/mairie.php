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
						<button class="btn btn-success btn-sm mairieLien"><?php echo $value['code_postal'].', '.$value['nom']; ?></button>
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
		<div class="row table-responsive">

			<h2 class="text-center">Vous êtes sur la page de la <strong><?php echo $this->unslug($slug); //unslug du slug mairie ?></strong></h2>
			<br>

			<table class="table table-striped table-bordered">
				<tr>
					<th>Nom</th>
					<th>Adresse</th>
					<th>Code Postal</th>
					<th>Ville</th>
					<th>Téléphone</th>
					<th>Mail</th>
					<th>Contact</th>
				</tr>
				<tr>

<?php			echo '<td>' . $donnees['nom'] . '</td>';
					echo '<td>' . $donnees['adresse'] . '</td>';
					echo '<td>' . $donnees['code_postal'] . '</td>';
					echo '<td>' . $donnees['ville'] . '</td>';
					echo '<td><a href="tel:'.$donnees['fix'].'">'.$donnees['fix'].'</a></td>';
					echo '<td><a href="mailto:'.$donnees['mail'].'">'.$donnees['mail'] . '</a></td>'; ?>
					<td>
						<a href="<?php echo $this->url('racine_contact',['orga' => 'mairie' ,'slug' => $slug]); ?>">
							<button class="btn btn-success btn-xs">Contacter la Mairie</button>
						</a>
					</td>
				</tr>
<!-- Deuxieme ligne tableau info mairie -->
				<tr>
					<th>Lundi</th>
					<th>Mardi</th>
					<th>Mercredi</th>
					<th>Jeudi</th>
					<th>Vendredi</th>
					<th>Samedi</th>
					<th>Dimanche</th>
				</tr>
				<tr>
<?php		foreach (unserialize($donnees['horaire']) as $key => $value) {
					echo '<td>' . $key.' : '.$value . '</td>';
				} ?>
				</tr>
			</table>

		</div>
		<!-- Fin div infos mairie -->
<?php
		} else {
			echo $donnees;
		}
	}
} ?>

<!-- Lien vers contact d'inscription de mairie -->
<br>
<div class="row">
	<blockquote class="quoteMairie blockquote-reverse">
		<p>
			Vous souhaitez inscrire votre Mairie et pouvoir remplir vos informations ?
			<a href='<?php echo $this->url('racine_contact',['orga' => 'All', 'slug' => 'All']) ;?>'>Contactez-nous !</a>
		</p>
		<footer><strong>Les Administrateurs</strong>, <cite title="Les Administrateurs">AS-CO-MA</cite></footer>
	</blockquote>
</div>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
