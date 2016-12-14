<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">

	<?= $this->section('main_head') ?>

</head>
<body>
	<div class="container">
		<header>
			<ul>
				<a href="<?php echo $this->url('default_home'); ?>"><li>Accueil</li></a>
			<?php	if(isset($_SESSION['user'])){ ?>
				<a href="<?php echo $this->url('racine_unlog'); ?>"><li>Deconnexion</li></a>
				<a href="<?php echo $this->url('admin_monCompte'); ?>"><li>Administration</li></a>
				<?php
			}else{ ?>
				<a href="<?php echo $this->url('racine_connexion'); ?>"><li>Connexion</li></a><?php
			} ?>
			<a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>"><li>Association</li></a>
			<a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>"><li>Mairie</li></a>
			<a href="<?php echo $this->url('racine_contact',['orga' => 'All' ,'slug' => 'All']); ?>"><li>Contact</li></a>
			</ul>
		</header>

		<section>
			<?= $this->section('main_content') ?>

		</section>

		<footer>

		</footer>
	</div>
	<?= $this->section('main_script') ?>
</body>
</html>
