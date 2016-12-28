<?php $this->layout('layout', ['title' => 'AS-CO-MA - Mairie']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_mairie.css'); ?>">
<?php $this->stop('main_head') ?>


<?php $this->start('main_content') ?>

<?php if($slug == 'All') { ?>

	<!-- Formulaire pour rechercher mairie -->
	<div class="row">
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

			<h2 class="text-center"><strong>Vous êtes sur la page de la <?php echo $this->unslug($slug); //unslug du slug mairie ?></strong></h2>
			<br>

			<!-- Premiere ligne tableau info mairie -->
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
					echo '<td>' . $value . '</td>';
				} ?>
				</tr>
			</table>

		</div>
		<!-- Fin div infos mairie -->
<?php
		} else {
			echo $donnees;
		}
	} ?>

	<!-- Display des articles/news des mairies -->
	<hr>
	<div class="row">
<?php if(isset($news)){
			if(is_array($news)){
				foreach ($news as $key => $value) {
					// Format de date
					$dateCreaNews = date("d M Y à H:i", strtotime($value['created_at']));
					$dateModifNews = date("d M Y à H:i", strtotime($value['updated_at']));?>

				<div class="row">
					<div class="col-xs-12">
						<div class="thumbnail" style="background-image: url('<?= $this->assetUrl('img/bourneville.png'); ?>')">
							<!-- Pour l'instant Bourneville est un test
							Mettre le background avec l'image de la mairie -->
							<!-- php : chercher la picture de l'assoc en bdd -->

							<div class="caption text-center">
								<!-- Titre de la news -->
								<h2 class=""><b><?php echo $value['title']; ?></b></h2>

								<img id="newsImg" src="http://placehold.it/550x300" alt="<?= $value['title']; ?>" width="550" height="300">
								<!-- Fenetre modale (pop up qui zoom) -->
									<div id="myModal" class="modal">

									  <!-- Close Button -->
									  <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>

									  <!-- Modal Content (The Image) -->
									  <img class="modal-content" id="img01">

									  <!-- Modal Caption (Image Text) -->
									  <div id="caption"></div>
									</div>

								<!-- Contenu de la news -->
								<h3 class="text-justify">
									<?php echo $value['content']; ?>
									<!-- effet de flou pour masquer le reste du texte -->
									<div class="blank"></div>
								</h3>

								<!-- Dates (Creation et modif (si y'en a une sinon 'Pas encore de modif')) -->
								<p>
									- <b>Rédigé le :</b> <?php echo $dateCreaNews; ?><br>
									- <b>Dernière modification :</b> <?php if(!empty($value['updated_at'])) { echo $dateModifNews; } else { echo 'Pas encore de modification.'; }?>
								</p>
							</div>
						</div>
					</div>
				</div>
				<!-- end row -->

					<?php
				}
			}else {
				//Sinon "Pas encore de news"
				echo '<div class="row">';
				echo '<h3 class="text-center"><b>' . $news . '. N\'hésitez pas à contacter votre Maire pour suggérer un article !</b></h3>';
				echo '</div>';
			}
		}
	} ?>
	</div>

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
