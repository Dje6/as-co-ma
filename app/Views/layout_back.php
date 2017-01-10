<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $this->e($title) ?></title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link rel="stylesheet" href="<?= $this->assetUrl('css_back/style.css') ?>">
	<link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">

	<?= $this->section('main_head') ?>

</head>
<body>
	<div class="wrapper">

	<div class="navbar-wrapper">
  	<div class="container-fluid">

			<nav class="navbar navbar-inverse navbar-static-top test">
				<h1 class="texte_3D col-xs-12 col-md-2">As-Co-Ma</h1>
				<div class="navbar-header col-xs-12 col-md-10">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
      	</div>

			<div id="navbar" class="col-xs-offset-0 col-md-offset-3 navbar-collapse collapse">
				<ul class="nav navbar-nav">

					<li><a href="<?php echo $this->url('default_home'); ?>">Accueil</a></li>
					<li><a href="<?php echo $this->url('admin_message',['page' => 1]); ?>">Messagerie</a></li>
					<li><a href="<?php echo $this->url('admin_monCompte'); ?>">Mon compte</a></li>
					<li><a href="<?php echo $this->url('racine_unlog'); ?>">Déconnexion</a></li>
					<?php

					if((isset($_SESSION['user']['roles']) && !empty($_SESSION['user']['roles'])))
					{
						if($this->in_multi_array('Assoc',$_SESSION['user']['roles'])){
							echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Association <span class="caret"></span></a><ul class="dropdown-menu">';
							foreach ($_SESSION['user']['roles'] as $key => $value) {
								if(isset($value['orga']) && $value['orga'] == 'Assoc'){
									if($value['role'] == 'Admin'){
										if($value['nom'] != ''){ ?>
											<li><a href="<?php echo $this->url('admin_assoc',['orga' => $value['orga'],'slug' => $value['slug']]); ?>">Gérer
											<?php echo $value['nom']; ?></a></li>
											<li><a href="<?php echo $this->url('racine_assoc',['orga' => $value['orga'],'slug' => $value['slug']]); ?>">Consulter
											<?php echo $value['nom']; ?></a></li><hr style="margin: 0;"><?php
										}else { ?>
											<li><a href="<?php echo $this->url('admin_assoc',['orga' => $value['orga'],'slug' => $value['slug']]); ?>">Créer
											une Association</a></li><?php
										}
									}elseif($value['role'] == 'User'){?>
										<li><a href="<?php echo $this->url('racine_assoc',['orga' => $value['orga'],'slug' => $value['slug']]); ?>">Consulter
										<?php echo $value['nom']; ?></a></li><?php
									}
								}
							}
							echo '</ul></li>';
						}

						if($this->in_multi_array('Mairie',$_SESSION['user']['roles'])){
							echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mairie <span class="caret"></span></a><ul class="dropdown-menu">';
							foreach ($_SESSION['user']['roles'] as $key => $value) {
								if(isset($value['orga']) && $value['orga'] == 'Mairie'){
									if($value['role'] == 'Admin'){
										if($value['nom'] != ''){ ?>
											<li><a href="<?php echo $this->url('admin_mairie',['orga' => $value['orga'],'slug' => $value['slug']]); ?>">Gérer
											<?php echo $value['nom']; ?></a></li>
											<li><a href="<?php echo $this->url('racine_mairie',['orga' => $value['orga'],'slug' => $value['slug']]); ?>">Consulter
											<?php echo $value['nom']; ?></a></li><?php
										}else { ?>
											<li><a href="<?php echo $this->url('admin_mairie',['orga' => $value['orga'],'slug' => $value['slug']]); ?>">Créer
											une Mairie</a></li><?php
										}
									}
								}
							}
							echo '</ul></li>';
						}

						if($this->in_multi_array('Webmaster',$_SESSION['user']['roles'])){
							echo '<li class="dropdown "><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SuperAdmin <span class="caret"></span></a><ul class="dropdown-menu">';
							foreach ($_SESSION['user']['roles'] as $key => $value) {
								if(isset($value['orga']) && $value['orga'] == 'Webmaster'){
									if($value['role'] == 'SuperAdmin'){?>
										<li><a href="<?php echo $this->url('admin_message_webmaster',['slug' => 'webmaster','orga' => 'webmaster','page' => 1]); ?>">SuperAdmin</a></li><?php
									}
								}
							}
							echo '</ul></li>';
						}

					}else { ?>
						<li><a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>">Trouver une association</a></li>
						<li><a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>">Fonder une Mairie</a></li><?php
					} ?>
				</ul>
			</div>
		 </nav>
	 </div>
	</div>
				<?php
				if(!empty($orga) && $orga != 'user'){


					if(isset($slug) && !empty($slug) && !isset($creation)){
						 $nom_orga = '<h1 id="menu_back" class="Nom_Orga col-xs-12 col-md-12">'.$this->unslug($slug).'</h1>' ;
					 } ?>

			<div class="navbar-wrapper container-fluid col-md-2">

					<nav class="navbar navbar-inverse navbar-static-top col-xs-12 test">
						<?php if(isset($nom_orga)){ echo $nom_orga;} ?>
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar2" aria-expanded="false" aria-controls="navbar2">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
					<div id="navbar2" class=" col-xs-offset-0 container-fluid navbar-collapse collapse" ><?php

					if($orga == 'mairie'){ ?>

							<ul class="nav navbar-nav ">
							<li><a href="<?php echo $this->url('admin_mairie_contact_Webmaster',['slugE' => $slug]); ?>">
								Contacter le Webmaster</a>
							</li>
							<li><a href="<?php echo $this->url('admin_message_mairie',['slug' => $slug,'orga' => 'mairie','page' => 1]); ?>">
								Messagerie</a>
							</li>
							<li><a href="<?php echo $this->url('admin_mairie',['orga' => $orga,'slug' => $slug]); ?>">
								Compte</a>
							</li>
							<?php if(!isset($creation)){ ?>
								<li><a href="<?php echo $this->url('admin_mairie_assoc',['slug' => $slug,'page' => 1]); ?>">
									Voir Association</a>
								</li>
								<li><a href="<?php echo $this->url('admin_mairie_news',['slug' => $slug,'orga'=>'mairie' ,'page' => 1]); ?>">
									News</a>
								</li>
							<?php } ?>
						</ul><?php

					}elseif($orga == 'assoc'){ ?>
							<ul class="nav navbar-nav ">
								<li><a href="<?php echo $this->url('admin_assoc_contact_tout_membres',['slugE' => $slug]); ?>">
									Message aux Membres</a>
								</li>
							<?php $array_retourner = $this->in_multi_array_return_array($slug,$_SESSION['user']['roles']);
							if(is_array($array_retourner)){ ?>
								<li><a href="<?php echo $this->url('admin_assoc_contact_mairie',['slugE' => $slug,'slugR' => $array_retourner['slug_mairie']]); ?>">
									Contacter la mairie</a>
								</li>
							<?php } ?>
							<li><a href="<?php echo $this->url('admin_message_assoc',['slug' => $slug,'orga' => 'assoc','page' => 1]); ?>">
								Messagerie</a>
							</li>
							<li><a href="<?php echo $this->url('admin_assoc',['orga' => $orga,'slug' => $slug]); ?>">
								Compte</a>
							</li>
							<?php if(!isset($creation)){ ?>
								<li><a href="<?php echo $this->url('admin_assoc_membres',['slug' => $slug,'page' => 1]); ?>">
									Voir Membres</a>
								</li>
								<li><a href="<?php echo $this->url('admin_assoc_news',['slug' => $slug,'orga'=>'assoc' ,'page' => 1]); ?>">
									News</a>
								</li><?php
							} ?>
						</ul><?php
				}elseif($orga == 'webmaster'){ ?>

							<ul class="nav navbar-nav ">

							<li><a href="<?php echo $this->url('admin_message_webmaster',['slug' => 'webmaster','orga' => 'webmaster','page' => 1]); ?>">
								Messagerie</a>
							</li>
							<li><a href="<?php echo $this->url('admin_webmaster_mairie',['page' => 1]); ?>">
								Voir Mairies</a>
							</li>
						</ul><?php
					} ?>
				</div>
			</nav>
		</div><?php
		}else { ?>
			<div class="container-fluid col-md-2">
			</div> <?php
		}
				 ?>

	<section class="main_content col-md-8">
		<?= $this->section('main_content') ?>
	</section>

</div>
	<!-- fin wrapper global -->


	<a href="#" class="btn btn-info return col-xs-offset-4 col-xs-4 col-md-offset-5 col-md-2">Retour en haut</a>
	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.1.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/app.js'); ?>"></script>


	<?= $this->section('main_script') ?>
</body>
</html>
