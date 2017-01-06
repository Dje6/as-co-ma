<!-- PAGE D'ACCUEIL A L'ARRIVEE SUR LE SITE -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Accueil']) ?>
<!-- tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_home.css'); ?>">
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>

<!-- CAROUSEL AVEC LIEN VERS MAIRIES, ASSOC et/ou FORMULAIRE D'INSCRIPTION -->
<!-- Le slider se pause au survol de la souris -->
<div class="row">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<!-- Boutons indicateurs en bas du slider -->
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<?php if(!isset($_SESSION['user'])){ ?>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			<?php } ?>
		</ol>

		  <!-- Items du sliders, 3 SLIDES -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		      <img src="<?= $this->assetUrl('img/rouen.jpg'); ?>" alt="Première image slider">
		      <div class="carousel-caption">
						<button type="button" class="btn btn-success btn-xs">
							<a href="<?= $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>"><span>Consulter les Mairies</span></a>
						</button>
		      </div>
		    </div>
		    <div class="item">
		      <img src="<?= $this->assetUrl('img/flokkr.jpg'); ?>" alt="Deuxième image slider">
		      <div class="carousel-caption">
						<button type="button" class="btn btn-success btn-xs">
							<a href="<?= $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>"><span>Consulter les Associations</span></a>
						</button>
		      </div>
		    </div>
				<!-- Si l'utilisateur est deja connecté, on masque le 3e slide vers formulaire d'inscription -->
				<?php if(!isset($_SESSION['user'])){ ?>
					<div class="item">
						<img src="<?= $this->assetUrl('img/want-you.jpg'); ?>" alt="Troisième image slider">
						<div class="carousel-caption">
							<button type="button" class="btn btn-success btn-xs">
								<a href="<?= $this->url('racine_inscriptForm'); ?>"><span>Tentez l'expérience !</span></a>
							</button>
						</div>
					</div>
				<?php } ?>

		  </div>

		  <!-- Fleches de controle du slider -->
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class=""></span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class=""></span>
		  </a>
		</div>
	</div>
	<!-- Fin du carousel -->

	<!-- Qui sommes-nous? Cadre présentation explication du site -->
	<br><br>
	<div class="row">
		<blockquote class="presentSite blockquote-reverse">
		  <p class="text-justify">
				<strong>AS-CO-MA</strong> offre la possibilité à des utilisateurs (Maire, Conseil municipal...) d'enregistrer la mairie qu'ils administrent. Il laisse également la possibilité aux présidents d'associations de les inscrire auprès des mairies dont ils dépendent.<br>
				Aux utilisateurs du site appartenant à ces associations, nous leur laissons la possibilité de consulter les derniers articles postés par les mairies, les associations, mais aussi d'avoir accès à un système de contact simple d'utilisation.<br>
				Toutes les informations (adresses, contacts, horaires d'ouverture, articles...) sont libres d'accès, mais dès lors que vous souhaitez participer à la vie active du site, une inscription vous sera demandée avec vos informations personnelles, permettant ainsi à tout utilisateur (ainsi qu'à l'équipe du site) de vous contacter rapidement.
			</p>
		  <footer><strong>Les Administrateurs</strong>, <cite title="Les Administrateurs">AS-CO-MA</cite></footer>
		</blockquote>
	</div>



		<!-- Bouton vers formulaire INSCRIPTION disparait si l'utilisateur est déjà connecté-->
		<?php if(!isset($_SESSION['user'])) { ?>

			<hr><br>
			<div class="row">
				<a href="<?= $this->url('racine_inscriptForm'); ?>">
					<button type="button" class="btn btn-success btn-lg btn-block">Rejoignez-nous !</button>
				</a>
			</div>
			<br>
			<?php } ?>


			<?php $this->stop('main_content') ?>



			<?php $this->start('main_script') ?>
			<!-- //ici les script js de la Page courante UNIQUEMENT
			//si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
			<?php $this->stop('main_script') ?>
