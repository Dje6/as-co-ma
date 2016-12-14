<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">

	<?= $this->section('main_head') ?>

</head>
<body>
	<div class="container">
		<header>
			<ul>
				<a href="<?php echo $this->url('racine_unlog'); ?>"><li>Deconnexion</li></a>
				<a href="<?php echo $this->url('default_home'); ?>"><li>Accueil</li></a>
				<a href="<?php echo $this->url('admin_message',['page' => 1]); ?>"><li>Message</li></a>
				<a href="<?php echo $this->url('admin_monCompte'); ?>"><li>Mon compte</li></a>

				<?php
				if((isset($_SESSION['user']['roles']) && !empty($_SESSION['user']['roles'])))
				{
					if($this->in_multi_array('Assoc',$_SESSION['user']['roles'])){
						echo '<li>Assoc<ul>';
						foreach ($_SESSION['user']['roles'] as $key => $value) {
							if(isset($value['orga']) && $value['orga'] == 'Assoc'){
								if($value['role'] == 'Admin'){ ?>
									<a href="<?php echo $this->url('admin_assoc',['orga' => $value['orga'],'slug' => $value['slug']]); ?>"><li>Gerer
									<?php echo $value['nom']; ?></li></a>
									<a href="<?php echo $this->url('racine_assoc',['orga' => $value['orga'],'slug' => $value['slug']]); ?>"><li>Consulter
									<?php echo $value['nom']; ?></li></a><?php
								}elseif($value['role'] == 'User'){?>
									<a href="<?php echo $this->url('racine_assoc',['orga' => $value['orga'],'slug' => $value['slug']]); ?>"><li>Consulter
									<?php echo $value['nom']; ?></li></a><?php
								}
							}
						}
						echo '</ul></li>';
					}

					if($this->in_multi_array('Mairie',$_SESSION['user']['roles'])){
						echo '<li>Mairie<ul>';
						foreach ($_SESSION['user']['roles'] as $key => $value) {
							if(isset($value['orga']) && $value['orga'] == 'Mairie'){
								if($value['role'] == 'Admin'){ ?>
									<a href="<?php echo $this->url('admin_mairie',['orga' => $value['orga'],'slug' => $value['slug']]); ?>"><li>Gerer
									<?php echo $value['nom']; ?></li></a>
									<a href="<?php echo $this->url('racine_mairie',['orga' => $value['orga'],'slug' => $value['slug']]); ?>"><li>Consulter
									<?php echo $value['nom']; ?></li></a><?php
								}
							}
						}
						echo '</ul></li>';
					}

					if($this->in_multi_array('Site',$_SESSION['user']['roles'])){
						echo '<li>SuperAdmin<ul>';
						foreach ($_SESSION['user']['roles'] as $key => $value) {
							if(isset($value['orga']) && $value['orga'] == 'Site'){
								if($value['role'] == 'SuperAdmin'){?>
									<a href="<?php echo $this->url('admin_superAdmin',['slug' => $value['slug']]); ?>"><li>SuperAdmin</li></a><?php
								}
							}
						}
						echo '</ul></li>';
					}

				}else { ?>
					<a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>"><li>Trouvez une association</li></a>
					<a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>"><li>Fonder une association</li></a><?php
				} ?>
			</ul>
			<?php
			if(isset($orga) && $orga != 'user'){
				echo '<h1>'.$slug.'</h1>';
				if($orga == 'mairie'){ ?>
					<ul>
						<a href="<?php echo $this->url('admin_message_mairie',['slug' => $slug,'page' => 1]); ?>"><li>Messagerie</li></a>
						<a href="<?php echo $this->url('admin_mairie',['orga' => $orga,'slug' => $slug]); ?>"><li>Compte</li></a>
						<a href="<?php echo $this->url('admin_mairie_assoc',['slug' => $slug,'page' => 1]); ?>"><li>Voir Associations</li></a>
					</ul> <?php
				}elseif($orga == 'assoc'){ ?>
					<ul>
						<a href="<?php echo $this->url('admin_message_assoc',['slug' => $slug,'page' => 1]); ?>"><li>Messagerie</li></a>
						<a href="<?php echo $this->url('admin_assoc',['orga' => $orga,'slug' => $slug]); ?>"><li>Compte</li></a>
						<a href="<?php echo $this->url('admin_assoc_menbres',['slug' => $slug,'page' => 1]); ?>"><li>Voir Membres</li></a>
					</ul><?php
				}
			}
			 ?>
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
