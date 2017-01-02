<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link rel="stylesheet" href="<?= $this->assetUrl('css_back/style.css') ?>">



	<?= $this->section('main_head') ?>

</head>
<body>

	<div class="navbar-wrapper">
  	<div class="container-fluid">
			<nav class="navbar navbar-inverse navbar-static-top">
				<h1 class="texte_3D col-sm-2">As-Co-Ma</h1>
				<div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
      	</div>

			<div id="navbar" class="col-xs-offset-3 navbar-collapse collapse">
				<ul class="nav navbar-nav">

					<li><a href="<?php echo $this->url('default_home'); ?>">Accueil</a></li>
					<li><a href="<?php echo $this->url('admin_message',['page' => 1]); ?>">Message</a></li>
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
											<?php echo $value['nom']; ?></a></li><?php
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
						<li><a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => 'All']); ?>">Trouvez une association</a></li>
						<li><a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => 'All']); ?>">Fonder une Mairie</a></li><?php
					} ?>
				</ul>
			</div>
		 </nav>
				<?php
				if(isset($orga) && $orga != 'user'){

					if(isset($slug) && !empty($slug) && !isset($creation)){ echo '<h1 class="titreback">'.$this->unslug($slug).'</h1>' ; }

					if($orga == 'mairie'){ ?>



						<div id="navbar" class="navbar-collapse collapse container-fluid">
							<ul class="nav navbar-nav navbar_organisation col-sm-12 barredyna">
							<li><a href="<?php echo $this->url('admin_mairie_contact_Webmaster',['slugE' => $slug]); ?>">
								<button type="button" class="btn btn-info btn-lg">Contacter le Webmaster</button></a>
							</li>
							<li><a href="<?php echo $this->url('admin_message_mairie',['slug' => $slug,'orga' => 'mairie','page' => 1]); ?>">
								<button type="button" class="btn btn-info btn-lg">Messagerie</button></a>
							</li>
							<li><a href="<?php echo $this->url('admin_mairie',['orga' => $orga,'slug' => $slug]); ?>">
								<button type="button" class="btn btn-info btn-lg">Compte</button></a>
							</li>
							<?php if(!isset($creation)){ ?>
							<li><a href="<?php echo $this->url('admin_mairie_assoc',['slug' => $slug,'page' => 1]); ?>">
								<button type="button" class="btn btn-info btn-lg">Voir Association</button></a>
							</li>
							<li><a href="<?php echo $this->url('admin_mairie_news',['slug' => $slug,'orga'=>'mairie' ,'page' => 1]); ?>">
								<button type="button" class="btn btn-info btn-lg">News</button></a>
							</li>
							<?php } ?>
						</ul>
					</div> <?php

					}elseif($orga == 'assoc'){ ?>
						<div id="navbar" class="navbar-collapse collapse container-fluid">
							<ul class="nav navbar-nav navbar_organisation col-sm-12 barredyna">
								<li><a href="<?php echo $this->url('admin_assoc_contact_tout_membres',['slugE' => $slug]); ?>">
									<button type="button" class="btn btn-info btn-lg">Message aux Membres</button></a>
								</li>
							<?php $array_retourner = $this->in_multi_array_return_array($slug,$_SESSION['user']['roles']);
							if(is_array($array_retourner)){ ?>
								<li><a href="<?php echo $this->url('admin_assoc_contact_mairie',['slugE' => $slug,'slugR' => $array_retourner['slug_mairie']]); ?>">
									<button type="button" class="btn btn-info btn-lg">Contacter la mairie</button></a>
								</li>
							<?php } ?>
							<li><a href="<?php echo $this->url('admin_message_assoc',['slug' => $slug,'orga' => 'assoc','page' => 1]); ?>">
								<button type="button" class="btn btn-info btn-lg">Messagerie</button></a>
							</li>
							<li><a href="<?php echo $this->url('admin_assoc',['orga' => $orga,'slug' => $slug]); ?>">
								<button type="button" class="btn btn-info btn-lg">Compte</button></a>
							</li>
							<?php if(!isset($creation)){ ?>
								<li><a href="<?php echo $this->url('admin_assoc_membres',['slug' => $slug,'page' => 1]); ?>">
									<button type="button" class="btn btn-info btn-lg">Voir Membres</button></a>
								</li>
								<li><a href="<?php echo $this->url('admin_assoc_news',['slug' => $slug,'orga'=>'assoc' ,'page' => 1]); ?>">
									<button type="button" class="btn btn-info btn-lg">News</button></a>
								</li><?php
							} ?>
						</ul>
					</div><?php
				}elseif($orga == 'webmaster'){ ?>
						<div id="navbar" class="navbar-collapse collapse container-fluid">
							<ul class="nav navbar-nav navbar_organisation col-sm-12 barredyna">

							<li><a href="<?php echo $this->url('admin_message_webmaster',['slug' => 'webmaster','orga' => 'webmaster','page' => 1]); ?>">
								<button type="button" class="btn btn-info btn-lg">Messagerie</button></a>
							</li>
							<li><a href="<?php echo $this->url('admin_webmaster_mairie',['page' => 1]); ?>">
								<button type="button" class="btn btn-info btn-lg">Voir Mairies</button></a>
							</li>
						</ul>
					</div><?php
					}
				}
				 ?>
	 </div>
 </div>

		<section class="main_content">
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>


	<script type="text/javascript" src="<?= $this->assetUrl('js/jquery-3.1.1.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/app.js'); ?>"></script>


	<?= $this->section('main_script') ?>
</body>
</html>
