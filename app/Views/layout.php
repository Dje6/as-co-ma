<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
	<link rel="stylesheet" href="<?= $this->assetUrl('css_front/slicknav.min.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style.css') ?>">

	<?= $this->section('main_head') ?>

</head>
<body>
	<header class="container-fluid">
		<div class="row">
			<!-- <div class="container"> -->
				<!-- Partie haute logo phrase -->
				<div class="col-xs-3 col-xs-offset-1 logo">
					<img class="" src="<?= $this->assetUrl('img/logo-ascoma-new.png') ?>" alt="Logo ASCOMA">
				</div>
				<div class="col-xs-offset-5 description_home">
					<h2 class="slogan"><i><strong>Votre gestion d'associations</strong></i></h2>
				</div>
			<!-- </div> -->
		</div>

		<!-- Menu haut -->
		<div class="row">
			<div class="container-fluid">
				<ul id="menu" class=" menu_home nav nav-tabs">
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
				</ul>
			</div>
		</div>
	</header>

		<section class="container content">
			<?= $this->section('main_content') ?>

		</section>

	<footer class="container-fluid">

	</footer>

	<!-- Scripts globaux du layout -->
	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.1.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery.slicknav.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/app.js'); ?>"></script>
	<?= $this->section('main_script') ?>
</body>
</html>
