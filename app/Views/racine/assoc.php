<?php $this->layout('layout', ['title' => 'Association']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php
if($slug == 'All'){ ?>
	<form class="" action="<?php echo $this->url('racine_assoc_search',['orga' => $orga ,'slug' => $slug]) ; ?>" method="post">
		<label for="cp">Saisisser le code postal de la commune de l'association rechercher  ou sont nom : </label>
		<input type="text" name="cp" value="">
		<input type="hidden" name="capcha" value="">
		<input type="submit" name="submit" value="Rechercher">
	</form><br/>
<p>Vous souhaiter inscrire votre association ?<a href='<?php echo $this->url('racine_mairie',['orga' => 'All', 'slug' => 'All']) ;?>'></p>
	contacter la mairie de la commune concerner!</a><br/><br/><?php

	if(isset($donnees)){
		if(is_array($donnees)){
			foreach ($donnees as $key => $value) { ?>
				<a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]) ; ?>">
					<article>
						<?php echo $value['nom'].' enregistrer en '.$value['mnom'].' '.$value['mCP']; ?>
					</article>
				</a> <?php
			}
		}else{
			echo $donnees;
		}
	} ?>
<?php
}else{
	if(isset($donnees)){
		if(is_array($donnees)){ ?>
			<p>Vous etes sur la page de l'association <?php echo $slug ; ?></p><br/>
			<a href="<?php echo $this->url('racine_contact',['orga' => 'assoc' ,'slug' => $slug]); ?>"><li>Contacter l'association</li></a>	<?php
			echo '<article>';
			echo $donnees['nom'].'<br/>';
			echo $donnees['adresse'].'<br/>';
			echo $donnees['code_postal'].'<br/>';
			echo $donnees['ville'].'<br/>';
			echo '<a href="tel:'.$donnees['fix'].'">'.$donnees['fix'].'</a><br/>';
			echo '</article><br/><br/>';
		}else {
			echo $donnees;
		}
	}
} ?>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT -->
  <!-- //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
