<?php $this->layout('layout', ['title' => 'AS-CO-MA - Accueil']) ?>
<!-- tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
	<?php $this->assetUrl('css_front/style_home.css'); ?>
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
	<!-- Titre page d'accueil -->
	<div class="row">
		<h1 class="text-center titre_home">Bienvenue sur AS-CO-MA</h1>
	</div>
	<br>

	<!-- CAROUSEL -->
	<div class="row">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		      <a href="<?= $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>"><img src="<?= $this->assetUrl('img/bourneville.png'); ?>" alt="Première image slider"></a>
		      <div class="carousel-caption">
						<h2>Consultez les Mairies</h2>
		      </div>
		    </div>
		    <div class="item">
		      <a href="<?= $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>"><img src="<?= $this->assetUrl('img/flokkr.png'); ?>" alt="Deuxième image slider"></a>
		      <div class="carousel-caption">
						<h2>Consultez les Associations</h2>
		      </div>
		    </div>
				<div class="item">
		      <img src="<?= $this->assetUrl('img/want-you.jpg'); ?>" alt="Troisième image slider">
		      <div class="carousel-caption">
						<!-- <h2>Tentez l'expérience AS-CO-MA !<br><span class="glyphicon glyphicon-hand-down"></span></h2> -->
		      </div>
		    </div>
		  </div>

		  <!-- Controls -->
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

	<!-- Bouton vers INSCRIPTION -->
	<br><hr><br>
	<div class="row">
		<a href="<?= $this->url('racine_inscriptForm'); ?>">
			<button type="button" class="btn btn-success btn-lg btn-block">Inscrivez-vous !</button>
		</a>
	</div>


<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
