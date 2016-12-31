<?php $this->layout('layout', ['title' => 'AS-CO-MA - Association']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_assoc.css'); ?>">
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php if($slug == 'All'){ ?>

	<!-- Form recherche d'assoc -->
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

	<!-- Quand recherche soumise, affiche un lien vers Mairie concernée -->
<br>
<div class="row text-center">
<?php if(isset($donnees)) {
		if(is_array($donnees)) {
			foreach ($donnees as $key => $value) { ?>
				<a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]) ; ?>">
					<button class="btn btn-success btn-sm assocLien"><?php echo '"'.$value['nom'].'" - enregistrée en '.$value['mnom'].', '.$value['mCP']; ?></button>
				</a>
<?php }
		} else {
			echo '<span class="errorForm">' . $donnees . '</span>';
		}
	} ?>
</div>

<?php } else {

////////////////////////////////////////////////////////////////////////////////

	//affichage des contenus de l'association cliquée
	if(isset($donnees)) {
		if(is_array($donnees)) { ?>
		<div class="row">

			<h2 class="text-center"><strong>"<?php echo $this->unslug($slug); // unslug du slug assoc ?>"</strong></h2>
			<br>

			<!-- Tableau infos assoc -->
			<table class="table table-striped table-bordered">
				<tr>
					<th>Nom</th>
					<th>Adresse</th>
					<th>Code Postal</th>
					<th>Ville</th>
					<th>Téléphone</th>
					<th>Contact</th>
				</tr>
				<tr>

	<?php	echo '<td>' . $donnees['nom'] . '</td>';
				echo '<td>' . $donnees['adresse'] . '</td>';
				echo '<td>' . $donnees['code_postal'] . '</td>';
				echo '<td>' . $donnees['ville'] . '</td>';
				echo '<td><a href="tel:'.$donnees['fix'].'">'.$donnees['fix'].'</a></td>'; ?>
					<td>
						<a href="<?php echo $this->url('racine_contact',['orga' => 'assoc' ,'slug' => $slug]); ?>"><button class="btn btn-success btn-xs">Contacter l'association</button></a>
					</td>
				</tr>
			</table>
<?php	} else {
			echo $donnees;
		}
	} ?>
		</div>
		<!-- Fin tableau infos assoc -->

<!-- ///////////////////////////////////////////////////////////////// -->

	<!-- Display des articles/news des assoc -->
	<!-- Style thumbnail -->
	<hr>
	<form class="" action="<?php $this->url('racine_assoc',['orga'=>$orga,'slug'=>$slug]) ; ?>" method="post">
		<?php if(isset($confirmation)){ echo $confirmation.'<br/>' ;} ?>
		<?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span>'.$error['mail'].'</span><br/>' ; } ?>
		<label for="mail">Recevoir par mail les futur articles? Inscrivez-vous a la newsletter!
			 <input type="text" name="mail" value="">
			 <input type="submit" name="submit_news" value="S'inscrire">
		</label>
	</form>
<?php if(isset($news)){
		if(is_array($news)){
			foreach ($news as $key => $value) {
				// Format de date
				$dateCreaNews = date("d M Y à H:i", strtotime($value['created_at']));
				$dateModifNews = date("d M Y à H:i", strtotime($value['updated_at']));?>

			<div class="row">
				<div class="col-xs-10 col-xs-offset-1">
			    <div class="thumbnail">

			      <img src="http://placehold.it/350x150" alt="IMG">
			      <div class="caption">
							<!-- Titre de la news -->
							<h3><b><?php echo $value['title']; ?></b></h3>

							<!-- Contenu de la news -->
							<h4><?php echo $value['content']; ?></h4>

							<!-- Dates (Creation et modif (si y'en a une sinon 'Pas encore de modif')) -->
							<ul>
								<li>Rédigé le : <?php echo $dateCreaNews; ?></li>
								<li>Dernière modification : <?php if(!empty($value['updated_at'])) { echo $dateModifNews; } else { echo 'Pas encore de modification.'; }?></li>
							</ul>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- end row -->

				<?php
			}
		}else {
			//Sinon "Pas encore de news"
			echo '<div class="row">';
			echo '<h3 class="text-center"><b>' . $news . '</b></h3>';
			echo '</div>';
		}
	}?>
<?php } ?>
<!-- fin du display des contenus de l'association -->


<!-- /////////////////////////////////////////////////////// -->


<!-- Lien vers contact d'inscription d'assoc -->
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
<?php $this->stop('main_script') ?>
