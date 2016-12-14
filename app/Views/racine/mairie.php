<?php $this->layout('layout', ['title' => 'Mairie']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<?php
		if($slug == 'All'){ ?>
			<form class="" action="<?php echo $this->url('racine_mairie_search',['orga'=>'Mairie','slug' => $slug]) ; ?>" method="post">
				<label for="cp">Saisisser le code postal ou le numeros de departement de la mairie rechercher : </label>
				<input type="text" name="cp" value="">
				<input type="hidden" name="capcha" value="">
				<input type="submit" name="submit" value="Rechercher">
			</form>
		<p>Vous souhaiter inscrire votre mairie et pouvoir remplir vos information?
		<a href='<?php echo $this->url('racine_contact',['orga' => 'All', 'slug' => 'All']) ;?>'>contacter nous!</a></p>

		<?php
		if(isset($donnees)){
			if(is_array($donnees)){
				foreach ($donnees as $key => $value) { ?>
					<a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => $value['slug']]) ; ?>">
						<article>
							<?php echo $value['code_postal'].' '.$value['nom']; ?>
						</article>
					</a> <?php
				}
			}else {
				echo $donnees;
			}
		} ?>
	<?php
}else{

	if(isset($donnees)){
		if(is_array($donnees)){ ?>
			<p>Vous etes sur la page de la mairie  <?php echo $slug ; ?></p><br/>
			<a href="<?php echo $this->url('racine_contact',['orga' => 'mairie' ,'slug' => $slug]); ?>"><li>Contacter la mairie</li></a>	<?php
			echo '<article>';
			echo $donnees['nom'].'<br/>';
			echo $donnees['adresse'].'<br/>';
			echo $donnees['code_postal'].'<br/>';
			echo $donnees['ville'].'<br/>';
			echo '<a href="tel:'.$donnees['fix'].'">'.$donnees['fix'].'</a><br/>';
				foreach (unserialize($donnees['horaire']) as $key => $value) {
					echo $key.' : '.$value.'<br/>';
				}
			echo '<a href="mailto:'.$donnees['mail'].'">'.$donnees['mail'].'</a><br/>';
			echo '</article><br/><br/>';
		}else{
			echo $donnees;
		}
	}
} ?>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
