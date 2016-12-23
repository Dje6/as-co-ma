<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->e($title) ?></title>
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" > -->
	<link rel="stylesheet" href="<?= $this->assetUrl('css_front/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css_front/slicknav.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style.css') ?>">

	<?= $this->section('main_head') ?>

</head>
<body>
	<!-- HEADER LAYOUT FRONT -->
	<header class="container-fluid">
		<div class="row">
			<!-- <div class="container"> -->
				<!-- Partie haute logo phrase -->
				<div class="col-xs-3 col-xs-offset-1 logo">
					<a href="<?= $this->url('default_home'); ?>"><img class="img-responsive" src="<?= $this->assetUrl('img/logo-ascoma-transparent.png') ?>" alt="Logo ASCOMA"></a>
				</div>
				<div class="col-xs-offset-6 description_home">
					<h1 class="slogan">Votre Gestion d'Associations</h1>
				</div>
			<!-- </div> -->
		</div>

		<!-- Menu haut -->
		<div class="row">
			<div>
				<ul id="menu" class="menu_home nav nav-tabs">
					<li><a href="<?php echo $this->url('default_home'); ?>">Accueil</a></li>
				<?php	if(isset($_SESSION['user'])){ ?>
					<li><a href="<?php echo $this->url('admin_monCompte'); ?>">Administration</a></li>
					<li><a href="<?php echo $this->url('racine_unlog'); ?>">Deconnexion</a></li>
					<?php
				}else{ ?>
					<li><a href="<?php echo $this->url('racine_connexion'); ?>">Connexion</a></li><?php
				} ?>
					<li><a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>">Mairie</a></li>
					<li><a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>">Association</a></li>
					<li><a href="<?php echo $this->url('racine_contact',['orga' => 'All' ,'slug' => 'All']); ?>">Contact</a></li>
					<li><a href="<?php echo $this->url('racine_inscriptForm'); ?>">Nous Rejoindre</a></li>
				</ul>
			</div>
		</div>
	</header>

		<section class="container main_content">
			<?= $this->section('main_content') ?>
		</section>
		<br><br>


		<!-- FOOTER LAYOUT FRONT -->
	<footer class="container-fluid">
		<!-- Premiere ligne footer -->
		<div class="row footer_haut">
			<!-- MENU DANS FOOTER -->
			<!-- <div> -->
				<ul class="menu_footer">
					<li><a href="<?php echo $this->url('default_home'); ?>">Accueil</a></li>
				<?php	if(isset($_SESSION['user'])){ ?>
					<li><a href="<?php echo $this->url('admin_monCompte'); ?>">Administration</a></li>
					<li><a href="<?php echo $this->url('racine_unlog'); ?>">Deconnexion</a></li>
					<?php
				}else{ ?>
					<li><a href="<?php echo $this->url('racine_connexion'); ?>">Connexion</a></li><?php
				} ?>
					<li><a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>">Mairie</a></li>
					<li><a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>">Association</a></li>
					<li><a href="<?php echo $this->url('racine_inscriptForm'); ?>">Nous Rejoindre</a></li>
				</ul>
			<!-- </div> -->

			<!-- Footer bouton contact -->
			<div class="bouton_contact">
				<a href="<?= $this->url('racine_contact',['orga' => 'All' ,'slug' => 'All']) ?>">
					<button type="button" class="btn btn-success btn-md">Contactez-nous</button>
				</a>
			</div>

			<!-- Lien vers CGU -->
			<div class="bouton_cgu">
				<a href="<?= $this->url('default_cgu'); ?>">
					<button type="button" class="btn btn-success btn-md">CGU</button>
				</a>
			</div>

			<!-- Reseaux sociaux -->
			<div class="reseaux_sociaux">
				<!-- Facebook -->
				<button type="button" class="btn btn-sm">
					<a href="http://facebook.com"><img src="<?= $this->assetUrl('img/facebook.png'); ?>" alt="Facebook"></a>
				</button>
				<!-- Twitter -->
				<button type="button" class="btn btn-sm">
					<a href="http://twitter.com"><img src="<?= $this->assetUrl('img/twitter.png'); ?>" alt="Twitter"></a>
				</button>
				<!-- Google -->
				<button type="button" class="btn btn-sm">
					<a href="http://plus.google.com"><img src="<?= $this->assetUrl('img/google.png'); ?>" alt="Google"></a>
				</button>
				<!-- linkedin -->
				<button type="button" class="btn btn-md">
					<a href="http://linkedin.com"><img src="<?= $this->assetUrl('img/linkedin.png'); ?>" alt="Linkedin"></a>
				</button>
			</div>
		</div>

		<hr>
		<!-- Deuxieme ligne footer -->
		<div class="row text-center">
			<span>
				<button class="btn btn-success btn-xs return">Retour en haut</button><br>
				<i><strong>AS-CO-MA ©</strong> - Copyright 2016</i>
			</span>
		</div>
	</footer>

	<!-- Scripts globaux du layout -->
	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.1.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery.slicknav.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/app.js'); ?>"></script>
	<?= $this->section('main_script'); ?>
</body>
</html>
