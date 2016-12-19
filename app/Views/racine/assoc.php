<?php $this->layout('layout', ['title' => 'AS-CO-MA - Association']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php if($slug == 'All'){ ?>

	<div class="row">
		<!-- Form recherche d'assoc -->
		<form class="formFront form-inline" action="<?php echo $this->url('racine_assoc_search',['orga' => $orga ,'slug' => $slug]) ; ?>" method="post">

			<div class="form-group">
				<label for="cp">Saisissez le code postal ou le nom de l'Association recherchée : </label>

				<input type="text" class="form-control" name="cp" value="">
				<input type="hidden" class="form-control" name="capcha" value="">
			</div>

			<button class="btn btn-success btn-md" type="submit" name="submit">Rechercher</button>
		</form>
	</div>


<?php if(isset($donnees)) {
		if(is_array($donnees)) {
			//Lien a cliquer pour contacter le résultat de l'association recherchée
			//redirection vers page contact avec en destinataire l'association cliquée
			foreach ($donnees as $key => $value) { ?>
				<a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]) ; ?>">
					<article>
						<?php echo $value['nom'].', enregistrée en '.$value['mnom'].', '.$value['mCP']; ?>
					</article>
				</a> <?php
			}
		} else {
			echo $donnees;
		}
	} ?>

<?php } else {
	//affichage des infos de l'association cliquée
	if(isset($donnees)) {
		if(is_array($donnees)) { ?>

			<h2>Vous êtes sur la page de l'association <?php echo $this->unslug($slug); // unslug du slug assoc ?></h2>

			<li><a href="<?php echo $this->url('racine_contact',['orga' => 'assoc' ,'slug' => $slug]); ?>">Contacter l'association</a></li>

<?php echo '<article>';
			echo $donnees['nom'].'<br/>';
			echo $donnees['adresse'].'<br/>';
			echo $donnees['code_postal'].'<br/>';
			echo $donnees['ville'].'<br/>';
			echo '<a href="tel:'.$donnees['fix'].'">'.$donnees['fix'].'</a><br/>';
			echo '</article><br/><br/>';
		} else {
			echo $donnees;
		}
	}
} ?>

<!-- Lien vers contact d'inscription d'assoc -->
<br>
<div class="row">
	<p>
		Vous souhaitez inscrire votre Association ? <a href='<?php echo $this->url('racine_mairie',['orga' => 'All', 'slug' => 'All']) ;?>'>Cliquez ici</a> pour contacter la Mairie de la commune recherchée.
	</p>
</div>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT -->
  <!-- //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
