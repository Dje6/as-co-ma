<!-- PAGE DES MAIRIES. Recherche + affichage des informations de la mairie et ses articles liés -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Mairie']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- ici le style de l'img en background des articles suivant le slug de la mairie -->
<style media="screen">
<?php if(is_array($donnees) && !empty($donnees['background'])){  ?>
				.thumbnail {
					background-image: url('<?= $this->assetUrl($donnees['background']); ?>');
				}		<?php
			} ?>
</style>
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_mairie.css'); ?>">
<?php $this->stop('main_head') ?>


<?php $this->start('main_content') ?>

<?php if($slug == 'All') { ?>

	<!-- FORMULAIRE DE RECHERCHE DE MAIRIE par CP ou Departement -->
	<div class="row">
		<form class="formFront form-inline" action="<?php echo $this->url('racine_mairie',['orga'=>'Mairie','slug' => $slug]) ; ?>" method="post">
			<!-- Recherche par CP/departement -->
			<div class="form-group">
				<label for="cp">Saisissez le code postal ou le numéro de département de la Mairie recherchée : </label>
				<input type="text" class="form-control" name="cp" value="" width="20%">

				<input type="hidden" class="form-control" name="capcha" value="">
			</div>

			<button type="submit" class="btn btn-success btn-md" name="submit">Rechercher</button>
		</form>
	</div>

	<!-- ///////////////////////////////////////////////////////////////// -->


<!-- QUAND RECHERCHE SOUMISE, AFFICHE LES LIENS VERS MAIRIES ENREGISTREES -->
<br>
<div class="row text-center">
	<?php if(isset($donnees)) {
		if(is_array($donnees)) {
			foreach ($donnees as $key => $value) { ?>
					<a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => $value['slug']]) ; ?>">
						<button class="btn btn-success btn-sm mairieLien"><?php echo $value['code_postal'].', '.$value['nom']; ?></button>
					</a>

<?php }
		} else { ?>
		<!-- Sinon, erreur aucune mairie trouvée -->
			<span class="errorForm"><?= $donnees; ?></span>
<?php	}
		} ?>
</div>

<!-- ///////////////////////////////////////////////////////////////// -->

<!-- QUAND LIEN CLIQUE, AFFICHE INFOS DE MAIRIE ET ARTICLES LIES -->

<?php } else {

	if(isset($donnees)){
		if(is_array($donnees)){ ?>
		<div class="row">
			<!-- TABLEAU informations de la mairie -->
			<div class="table-responsive">
				<!-- Premiere ligne tableau info mairie -->
				<table class="table table-striped table-bordered">
					<tr>
						<th>Adresse</th>
						<th>Code Postal</th>
						<th>Ville</th>
						<th>Téléphone</th>
						<th>Mail</th>
						<th>Contact</th>
						<th>S'inscrire à la newsletter</th>
					</tr>
					<tr>

	      		<td><?= $donnees['adresse']; ?></td>
						<td><?= $donnees['code_postal']; ?></td>
						<td><?= $donnees['ville']; ?></td>
						<td><a href="tel:<?= $donnees['fix']; ?>"><?= $donnees['fix']; ?></a></td>
						<td><a href="mailto:<?= $donnees['mail']; ?>"><?= $donnees['mail']; ?></a></td>
						<td>
							<a href="<?php echo $this->url('racine_contact',['orga' => 'mairie' ,'slug' => $slug]); ?>">
								<button class="btn btn-success btn-xs">Contacter la <?= $donnees['nom']; ?></button>
							</a>
						</td>
						<td>
						<!-- Form abonnement newsletter des articles mairie -->
							<form class="form-inline" action="<?php $this->url('racine_mairie',['orga'=>$orga,'slug'=>$slug]) ; ?>" method="post">
								<?php if(isset($confirmation)){ echo '<span class="confirmForm">'.$confirmation.'</span><br/>'; } ?>
								<?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span class="errorForm">'.$error['mail'].'</span><br/>' ; } ?>

								<div class="form-group">
									<input type="text" name="mail" class="form-control" placeholder="exemple@mail.com">
								</div>

								<button class="btn btn-success btn-xs" type="submit" name="submit_news">Envoyer</button>
							</form>
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
	<?php		foreach (unserialize($donnees['horaire']) as $key => $value) { ?>
						<td><?= $value; ?></td>
						<?php
					} ?>
					</tr>
				</table>
			</div>

		</div>
		<!-- Fin tableau infos mairie -->

		<!-- ///////////////////////////////////////////////////////////////// -->


		<!-- GOOGLE MAPS DES MAIRIES SUIVANT LE SLUG (A AMELIORER CAR FIXE) -->
		<div class="row text-center">
			<?php if($slug == 'mairie-de-rouen') { ?>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1297.0962810775059!2d1.098189548172286!3d49.44307742382861!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e0ddd5c7e15663%3A0x6bc2b11371fda7d8!2s2+Place+du+G%C3%A9n%C3%A9ral+de+Gaulle%2C+76000+Rouen!5e0!3m2!1sfr!2sfr!4v1483022647507" width="600" height="250" style="border:0" allowfullscreen></iframe>
			<?php } elseif ($slug == 'mairie-de-bourneville') { ?>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5193.9894418604845!2d0.6184841296266613!3d49.390091859464555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e0549bb805dc1f%3A0x22ac955b307c448a!2s1+Place+de+la+Mairie%2C+27500+Bourneville!5e0!3m2!1sfr!2sfr!4v1483023852000" width="600" height="250" style="border:0" allowfullscreen></iframe>
			<?php } elseif ($slug = 'mairie-d-epaignes') { ?>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2602.8388259038547!2d0.43869151379403665!3d49.27945117336963!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf6c2f6bfa27f06f5!2sMairie!5e0!3m2!1sfr!2sfr!4v1483023362144" width="600" height="250" style="border:0" allowfullscreen></iframe>
			<?php } ?>
		</div>

<?php
		} else {
			// Si aucun résultat de recherche de mairie (notamment par slug), redirection vers l'accueil
			header('location: '. $this->url('default_home'));
		}
	} ?>


	<!-- ///////////////////////////////////////////////////////////////// -->


	<!-- AFFICHAGE DES ARTICLES LIES A LA MAIRIE -->
	<hr>
<?php if(isset($news)){
			if(is_array($news)){
				foreach ($news as $key => $value) {
					// Format de date pour creation / modif des articles
					$dateCreaNews = date("d M Y à H:i", strtotime($value['created_at']));
					$dateModifNews = date("d M Y à H:i", strtotime($value['updated_at']));?>

				<div class="row">
					<div class="col-xs-12">
						<div class="thumbnail">
							<div class="caption text-center">
								<!-- Titre de la news -->
								<h2 class=""><b><?php echo $value['title']; ?></b></h2>
								<?php if(!empty($value['picture'])){  ?>
									<img class="newsImg" src="<?= $this->assetUrl($value['picture']); ?>" alt="<?= $value['title']; ?>"
									width="550" height="300">
								<?php } ?>
								<!-- Fenetre modale au clic sur une image d'article -->
									<div id="myModal" class="modal">

										<!-- Bouton fermer en haut a droite -->
									  <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>

										<!-- Image, contenu de la modale -->
									  <img class="modal-content" id="img01">

										<!-- Texte descriptif modale (titre de l'article) -->
									  <div id="caption"></div>
									</div>

								<!-- Contenu de la news -->
								<h3 class="text-justify">
									<?= nl2br($value['content']); ?>
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
				//Si pas d'articles, message erreur "Pas encore de news" ?>
				<div class="row">
					<h3 class="text-center"><b> <?= $news; ?> N'hésitez pas à contacter votre Maire pour suggérer un article !</b></h3>
				</div>
	<?php
			}
		}
	} ?>


	<!-- /////////////////////////////////////////////////////// -->


<!-- QUOTE POUR INSCRIRE UNE MAIRIE. Redirection formulaire de contact ciblé vers les admins -->
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
	<script type="text/javascript" src="<?= $this->assetUrl('js/app-news.js'); ?>"></script>
<?php $this->stop('main_script') ?>
