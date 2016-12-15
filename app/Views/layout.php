<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
	<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style.css') ?>">

	<?= $this->section('main_head') ?>

</head>
<body>
	<header class="container-fluid">
		<div class="row">
			<div class="container">
				<div class="col-xs-3 logo">
					<img class="img-responsive" src="<?= $this->assetUrl('img/logo-ascoma-new.png') ?>" alt="Logo ASCOMA">
				</div>
				<div class="col-xs-8 description_home pull-right">
					<h2 class="slogan"><i><strong>Votre gestion d'associations</strong></i></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="container-fluid">
				<ul class="col-xs-10 col-xs-offset-2 menu_home nav nav-tabs">
					<li><a href="<?php echo $this->url('default_home'); ?>">Accueil</a></li>
				<?php	if(isset($_SESSION['user'])){ ?>
					<li><a href="<?php echo $this->url('racine_unlog'); ?>">Deconnexion</a></li>
					<li><a href="<?php echo $this->url('admin_monCompte'); ?>">Administration</a></li>
					<?php
				}else{ ?>
					<li><a href="<?php echo $this->url('racine_connexion'); ?>">Connexion</a></li><?php
				} ?>
				<li><a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>">Association</a></li>
				<li><a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>">Mairie</a></li>
				<li><a href="<?php echo $this->url('racine_contact',['orga' => 'All' ,'slug' => 'All']); ?>">Contact</a></li>
				</ul>
			</div>
		</div>
	</header>

	<div class="container content">
		<section>
			<?= $this->section('main_content') ?>

		</section>
	</div>

	<footer class="container-fluid">

	</footer>


	<?= $this->section('main_script') ?>
</body>
</html>
