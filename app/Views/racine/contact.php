<!-- PAGE DE FORMULAIRE DE CONTACT. S'adapte au slug (URL) pour contacter soit les admins du site (défaut), soit Mairie soit Assoc suivant clic dans informations des pages concernées. -->
<?php $this->layout('layout', ['title' => 'AS-CO-MA - Contact']) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<link rel="stylesheet" href="<?= $this->assetUrl('css_front/style_contact.css'); ?>">
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>

	<!-- FORMULAIRE CONTACT Mairie, ou Assoc, ou Admin suivant $slug  -->
  <div class="row">
    <form class="formFront" action="<?php echo $this->url('racine_contact_send',['orga'=> $orga,'slug'=>$slug]); ?>" method="post">

  		<fieldset>
  			<!-- Titre du formulaire modifié, php dedans plutot qu'au dessus -->
  			<legend>
  				<?php
  				if(!isset($confirmation)){

  					if($slug == 'All'){ ?>
  						<h2 class="text-center" ><b>Contacter les Administrateurs d'AS-CO-MA</b></h2>
  					<?php } else {
  						if($orga == 'mairie'){ ?>
  							<h2 class="text-center" ><b>Contacter la <?= $this->unslug($slug); ?></b></h2> <!-- unslug du slug de la mairie à contacter -->
  					<?php } elseif($orga == 'assoc') { ?>
  							<h2 class="text-center" ><b>Contacter l'Association <?=$this->unslug($slug); ?></b></h2> <!-- unslug du nom de l'assoc a contacter -->
  				  <?php	}
  					} ?>
  			</legend>

  			<!-- MAIL EMETTEUR -->
  			<div class="form-group col-xs-12">
  		    <label for="mail">Votre E-mail : </label><span class="errorForm"><?php if(isset($error['emeteur_mailOrId'])){ echo $error['emeteur_mailOrId']; } ?></span>

  				<!-- Input du mail de l'emetteur -->
  				<?php if(isset($_SESSION['user'])) { ?>
  					<input type="text" class="form-control" name="emeteur_mailOrId" value="<?= $_SESSION['user']['mail']; ?>" readonly>
  			  <?php	} else { ?>
  				 <input type="text" class="form-control" name="emeteur_mailOrId" placeholder="Entrez votre adresse mail pour recevoir une réponse" value="<?php if(isset($saisi['emeteur_mailOrId'])) { echo $saisi['emeteur_mailOrId']; } ?>">
  	      <?php } ?>
  			</div>

  			<!-- OBJECT CONTACT. S'adapte au destinataire du contact -->
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

  		          <option value="inscript_membre">Devenir membre de l'association</option>
  		          <option value="probleme_assoc">Signaler un problème sur la page de l'association</option>
  		          <option value="info_assoc">Obtenir des informations sur l'association</option><?php
  		        }
  		      } ?>
  		    </select>
  			</div>

  			<!-- CONTENU MESSAGE CONTACT -->
  			<div class="form-group col-xs-12">
  		    <label for="contenu">Votre Message : </label><span class="errorForm"><?php if(isset($error['contenu'])){ echo $error['contenu']; } ?></span>
  		    <textarea name="contenu" class="form-control" rows="8" cols="80"><?php if(isset($saisi['contenu'])) { echo $saisi['contenu']; } ?></textarea>
  			</div>

  			<input type="hidden" name="capcha" value="">

  	    <button type="submit" class="btn btn-success btn-md" name="submit">Envoyer</button>
  		</fieldset>
    </form>
  </div>
	<br><br>
	<!-- End form contact -->

	<!-- QUOTE DES ADMINS CONDITION POUR INSCRIRE UNE MAIRIE -->
	<?php if($slug == 'All'){ ?>
    <div class="row">
  		<blockquote class="blockquote-reverse quoteContact">
  		  <p>* Vous recevrez une réponse à votre demande d'inscription de Mairie après étude de votre demande par nos services.</p>
  		  <footer><strong>Les Administrateurs</strong>, <cite title="Les Administrateurs">AS-CO-MA</cite></footer>
  		</blockquote>
    </div>
	<?php	}
  //end if(!isset($confirmation))
      } else { ?>
        <!-- Message de confirmation a l'envoi du formulaire -->
        <div class="row">
	         <h2 class="text-center confirmForm"><b><?= $confirmation; ?> !</b></h2>
        </div>
<?php } ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
