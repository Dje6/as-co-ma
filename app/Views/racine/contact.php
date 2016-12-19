<?php $this->layout('layout', ['title' => 'AS-CO-MA - Contact']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php
if(!isset($confirmation)){

	if($slug == 'All'){
		echo '<h2 class="text-center" >Contacter les Administrateurs du site</h2>';
	}else{
		if($orga == 'mairie'){
			echo '<h2 class="text-center" >Contacter la '.$this->unslug($slug).'</h2>'; //unslug du slug de la mairie à contacter
		}elseif($orga == 'assoc') {
			echo '<h2 class="text-center" >Contacter l\'association '.$slug.'</h2>';
		}
	} ?>

	<!-- FORMULAIRE CONTACT Mairie, ou Assoc, ou Admin suivant $slug etc -->
  <form class="" action="<?php echo $this->url('racine_contact_send',['orga'=> $orga,'slug'=>$slug]); ?>" method="post">

		<!-- MAIL EMETTEUR -->
		<div class="form-group col-xs-12">
	    <label for="mail">Votre E-mail : </label><span class="errorForm"><?php if(isset($error['mail'])){ echo $error['mail']; } ?></span>
			<!-- Input du mail de l'emetteur -->
			<?php if(isset($_SESSION['user'])){
				echo '<input type="text" class="form-control" name="mail" value="'.$_SESSION['user']['mail'].'" readonly>';
			} else {
			 echo '<input type="text" class="form-control" name="mail" placeholder="Entrez votre adresse mail pour recevoir une réponse">';
			} ?>
		</div>

		<!-- OBJECT CONTACT -->
		<div class="form-group col-xs-12">
	    <label for="objet">Objet de votre message : </label><span class="errorForm"><?php if(isset($error['objet'])){ echo $error['objet']; } ?></span>
	    <select class="form-control" name="objet"><?php
	      if($slug == 'All'){ ?>

	        <option value="inscript_mairie">Inscrire ma Mairie *</option>
	        <option value="probleme_site">Signaler un problème sur le site</option>
	        <option value="info_site">Obtenir des informations sur le site</option>

	<?php } else {
	        if($orga =='mairie'){ ?>

	          <option value="inscript_assoc">Inscrire mon Association</option>
	          <option value="probleme_mairie">Signaler un problème sur la page de la Mairie</option>
						<option value="info_mairie">Obtenir des informations sur la Mairie</option><?php

	      } elseif($orga == 'assoc'){ ?>

	          <option value="inscript_menbre">Devenir membre de l'association</option>
	          <option value="probleme_assoc">Signaler un problème sur la page de l'association</option>
	          <option value="info_assoc">Obtenir des informations sur l'association</option><?php
	        }
	      } ?>
	    </select>
		</div>

		<!-- CONTENU MESSAGE CONTACT -->
		<div class="form-group col-xs-12">
	    <label for="contenu">Votre Message : </label><span class="errorForm"><?php if(isset($error['contenu'])){ echo $error['contenu']; } ?></span>
			<!-- Textearea désactivé si user pas connecté -->
	    <textarea name="contenu" class="form-control" rows="8" cols="80"></textarea>
		</div>

		<input type="hidden" name="capcha" value="">

    <button type="submit" class="btn btn-success btn-md" name="submit">Envoyer mon message</button>
  </form>
	<br><br>
	<!-- End form contact -->

	<!-- Message condition pour inscription mairie -->
	<?php if($slug == 'All'){ ?>
		<blockquote class="blockquote-reverse">
		  <p>* Vous recevrez une réponse à votre demande d'inscription de Mairie après étude de votre demande par nos services.</p>
		  <footer>Les Administrateurs, <cite title="Source Title">AS-CO-MA</cite></footer>
		</blockquote>
	<?php	}
	//end if(!isset($confirmation))
} else {
	echo $confirmation;
} ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
