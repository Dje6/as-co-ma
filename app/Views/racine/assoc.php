<!-- PAGE DES ASSOCIATIONS. Recherche + affichage des informations de l'association et ses articles liés -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Association']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- ici le style de l'img en background des articles suivant le slug de l'assoc en url -->
<style media="screen">
<?php if(is_array($donnees) && !empty($donnees['background'])){  ?>
	.thumbnail {
		background-image: url('<?= $this->assetUrl($donnees['background']); ?>');
		}		<?php
	} ?>
</style>
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_assoc.css'); ?>">
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
	<?php if($slug == 'All'){ ?>

		<!-- Formulaire recherche d'assoc par code postal ou nom de l'assoc-->
		<div class="row">
			<form class="formFront form-inline" action="<?php echo $this->url('racine_assoc',['orga' => $orga ,'slug' => $slug]) ; ?>" method="post">

				<div class="form-group">
					<label for="cp">Saisissez le code postal ou le nom de l'Association recherchée : </label>

					<input type="text" class="form-control" name="cp" value="">
					<input type="hidden" class="form-control" name="capcha" value="">
				</div>

				<button class="btn btn-success btn-md" type="submit" name="submit">Rechercher</button>
			</form>
		</div>

		<!-- ////////////////////////////////////////////////////////////////////// -->

		<!-- Quand recherche soumise, affiche les liens vers Associations concernées -->
		<br>
		<div class="row text-center">
<?php if(isset($donnees)) {
				if(is_array($donnees)) {
					foreach ($donnees as $key => $value) { ?>
						<a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]) ; ?>">
							<button class="btn btn-success btn-sm assocLien"><?php echo '"'.$value['nom'].'" - enregistrée en '.$value['mnom'].', '.$value['mCP']; ?></button>
						</a>
						<?php
						}
					} else { ?>
						<span class="errorForm"><?= $donnees; ?></span>
				 <?php
					}
				} ?>
			</div>

			<?php } else {

				////////////////////////////////////////////////////////////////////////////////

				// AFFICHAGE TABLEAU D'INFORMATIONS DE L'ASSOCIATION CLIQUEE ?>
				<div class="row">
	<?php if(isset($donnees)) {
					if(is_array($donnees)) { ?>

							<div class="table-responsive">
								<!-- Tableau infos assoc -->
								<table class="table table-striped table-bordered">
									<tr>
										<th>Adresse</th>
										<th>Code Postal</th>
										<th>Ville</th>
										<th>Téléphone</th>
										<th>Contact</th>
										<th>S'inscrire à la newsletter</th>
									</tr>

									<tr>
										<td> <?= $donnees['adresse']; ?> </td>
										<td> <?= $donnees['code_postal']; ?> </td>
										<td> <?= $donnees['ville']; ?> </td>
									 	<td><a href="tel: <?= $donnees['fix']; ?>"> <?= $donnees['fix']; ?> </a></td>
										<td>
											<a href="<?php echo $this->url('racine_contact',['orga' => 'assoc' ,'slug' => $slug]); ?>"><button class="btn btn-success btn-xs">Contacter <?= $donnees['nom']; ?></button></a>
										</td>
										<td>
											<!-- Formulaire abonnement newsletter des articles assoc -->
											<form class="form-inline" action="<?php $this->url('racine_assoc',['orga'=>$orga,'slug'=>$slug]) ; ?>" method="post">
												<?php if(isset($confirmation)){ echo '<span class="confirmForm">'.$confirmation.'</span><br/>'; } ?>
												<?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span class="errorForm">'.$error['mail'].'</span><br/>' ; } ?>

												<div class="form-group">
													<input type="text" name="mail" class="form-control" placeholder="exemple@mail.com" value="">
												</div>

												<button class="btn btn-success btn-xs" type="submit" name="submit_news">Envoyer</button>
											</form>
										</td>
									</tr>
							 </table>
						 </div>

							<?php	} else {
								// Si aucun résultat de recherche d'assoc (notamment par slug), redirection vers l'accueil
								header('location: '. $this->url('default_home'));
							}
						} ?>
					 </div>
						<!-- end row -->
						<!-- Fin tableau infos assoc -->


						<!-- ///////////////////////////////////////////////////////////////// -->


						<!-- AFFICHAGE DES ARTICLES PUBLIES PAR L'ASSOCIATION -->
						<!-- Style thumbnail -->
					<hr>

					<?php if(isset($news)){
						if(is_array($news)){
							foreach ($news as $key => $value) {
								// Format de date pour creation et modification des articles
								$dateCreaNews = date("d M Y à H:i", strtotime($value['created_at']));
								$dateModifNews = date("d M Y à H:i", strtotime($value['updated_at']));?>

								<div class="row">
									<div class="col-xs-12">
										<div class="thumbnail">
											<div class="caption text-center">
												<!-- Titre de la news -->
												<h2 class=""><b><?= $value['title']; ?></b></h2>

												<?php if(!empty($value['picture'])){  ?>
													<img class="newsImg img-responsive" src="<?= $this->assetUrl($value['picture']); ?>" alt="<?= $value['title']; ?>"
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
														- <b>Rédigé le :</b> <?= $dateCreaNews; ?><br>
														- <b>Dernière modification :</b> <?php if(!empty($value['updated_at'])) { echo $dateModifNews; } else { echo 'Pas encore de modification.'; }?>
													</p>
											</div>
										</div>
									</div>
								</div>
									<!-- end row des news -->

									<?php
								}
							}else { ?>
								<!-- Si pas de d'articles publiés par l'assoc, affichage message -->
								<div class="row">
									<h3 class="text-center"><b><?= $news ?>. N'hésitez pas à contacter votre président d'Association pour suggérer un article !</b></h3>
								</div>
						<?php	}
						} ?>
	<?php } ?>
						<!-- fin du display des contenus de l'association -->


						<!-- /////////////////////////////////////////////////////// -->


						<!-- QUOTE POUR INSCRIRE UNE ASSOCIATON. Redirection formulaire de contact ciblé vers une mairie -->
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
<script type="text/javascript" src="<?= $this->assetUrl('js/app-news.js'); ?>"></script>
<?php $this->stop('main_script') ?>
