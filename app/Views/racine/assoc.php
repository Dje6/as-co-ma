<?php $this->layout('layout', ['title' => 'AS-CO-MA - Association']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- ici le style de l'img en background des articles suivant le slug de l'assoc -->
<style media="screen">
	<?php if($slug == 'les-rois-du-volant') { ?>
		.thumbnail {
			background-image: url('<?= $this->assetUrl('img/volants.jpg'); ?>');
		}
	<?php } elseif ($slug == 'les-seconds') { ?>
		.thumbnail {
			background-image: url('<?= $this->assetUrl('img/seconds.jpg'); ?>');
		}
	<?php } else { ?>
		.thumbnail {
			background-image: url('<?= $this->assetUrl('img/flokkr.jpg'); ?>');
		}
<?php } ?>
</style>
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_assoc.css'); ?>">
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php if($slug == 'All'){ ?>

	<!-- Form recherche d'assoc -->
	<div class="row">
		<form class="formFront form-inline" action="<?php echo $this->url('racine_assoc_search',['orga' => $orga ,'slug' => $slug]) ; ?>" method="post">

			<div class="form-group">
				<label for="cp">Saisissez le code postal ou le nom de l'Association recherchée : </label>

				<input type="text" class="form-control" name="cp" value="">
				<input type="hidden" class="form-control" name="capcha" value="">
			</div>

			<button class="btn btn-success btn-md" type="submit" name="submit">Rechercher</button>
		</form>
	</div>

<!-- ////////////////////////////////////////////////////////////////////// -->

	<!-- Quand recherche soumise, affiche les liens vers Mairies concernées -->
<br>
<div class="row text-center">
<?php if(isset($donnees)) {
		if(is_array($donnees)) {
			foreach ($donnees as $key => $value) { ?>
				<a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]) ; ?>">
					<button class="btn btn-success btn-sm assocLien"><?php echo '"'.$value['nom'].'" - enregistrée en '.$value['mnom'].', '.$value['mCP']; ?></button>
				</a>
<?php }
		} else {
			echo '<span class="errorForm">' . $donnees . '</span>';
		}
	} ?>
</div>

<?php } else {

////////////////////////////////////////////////////////////////////////////////

	//affichage des contenus de l'association cliquée
	if(isset($donnees)) {
		if(is_array($donnees)) { ?>
		<div class="row">

			<h2 class="text-center"><strong>"<?php echo $this->unslug($slug); // unslug du slug assoc ?>"</strong></h2>
			<br>

			<div class="table-responsive">
				<!-- Tableau infos assoc -->
				<table class="table table-striped table-bordered">
					<tr>
						<th>Nom</th>
						<th>Adresse</th>
						<th>Code Postal</th>
						<th>Ville</th>
						<th>Téléphone</th>
						<th>Contact</th>
					</tr>
					<tr>

		<?php	echo '<td>' . $donnees['nom'] . '</td>';
					echo '<td>' . $donnees['adresse'] . '</td>';
					echo '<td>' . $donnees['code_postal'] . '</td>';
					echo '<td>' . $donnees['ville'] . '</td>';
					echo '<td><a href="tel:'.$donnees['fix'].'">'.$donnees['fix'].'</a></td>'; ?>
						<td>
							<a href="<?php echo $this->url('racine_contact',['orga' => 'assoc' ,'slug' => $slug]); ?>"><button class="btn btn-success btn-xs">Contacter l'association</button></a>
						</td>
					</tr>
				</table>
			</div>

<?php	} else {
			echo $donnees;
		}
	} ?>
		</div>
		<!-- end row -->
		<!-- Fin tableau infos assoc -->

<!-- ///////////////////////////////////////////////////////////////// -->

	<!-- Display des articles/news des assoc -->
	<!-- Style thumbnail -->
	<hr>
	<!-- Row se crée dans le foreach -->
<?php if(isset($news)){
		if(is_array($news)){
			foreach ($news as $key => $value) {
				// Format de date
				$dateCreaNews = date("d M Y à H:i", strtotime($value['created_at']));
				$dateModifNews = date("d M Y à H:i", strtotime($value['updated_at']));?>

			<div class="row">
				<div class="col-xs-12">
			    <div class="thumbnail">
						<!-- Pour l'instant Flokkr est un test
						Mettre le background avec l'image de l'association -->
						<!-- php : chercher la picture de l'assoc en bdd -->

			      <div class="caption text-center">
							<!-- Titre de la news -->
							<h2 class=""><b><?= $value['title']; ?></b></h2>

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
								<?= $value['content']; ?>
								<!-- effet de flou pour masquer le reste du texte -->
								<div class="blank"></div>
							</h3>

							<!-- Dates (Creation et modif (si y'en a une sinon 'Pas encore de modif')) -->
							<p>
								- <b>Rédigé le :</b> <?= $dateCreaNews; ?><br>
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
			echo '<h3 class="text-center"><b>' . $news . '. N\'hésitez pas à contacter votre président d\'Association pour suggérer un article !</b></h3>';
			echo '</div>';
		}
	}?>
<?php } ?>
<!-- fin du display des contenus de l'association -->


<!-- /////////////////////////////////////////////////////// -->


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
