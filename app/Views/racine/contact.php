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
		echo '<h1>Contacter les Administrateurs du site</h1>';
	}else{
		if($orga == 'mairie'){
			echo '<p>Contacter la '.$this->unslug($slug).'</p>'; //unslug du slug de la mairie à contacter
		}elseif($orga == 'assoc') {
			echo '<p>Contacter l\'association '.$slug.'</p>';
		}
	} ?>
  <form class="" action="<?php echo $this->url('racine_contact_send',['orga'=> $orga,'slug'=>$slug]); ?>" method="post">
    <label for="mail">Mail</label><?php if(isset($error['mail'])){ echo '<span>'.$error['mail'].'</span>' ;} ?><br/>
		<?php if(isset($_SESSION['user'])){
			echo '<input type="text" name="emeteur_mailOrId" value="'.$_SESSION['user']['mail'].'" readonly><br/>';
		}else{
		 echo '<input type="text" name="emeteur_mailOrId" value=""><br/>';
		} ?>
    <label for="objet">Objet</label><?php if(isset($error['objet'])){ echo '<span>'.$error['objet'].'</span>' ;} ?><br/>
    <select class="" name="objet"><?php
      if($slug == 'All'){ ?>

        <option value="inscript_mairie">Inscrire ma Mairie *</option>
        <option value="probleme_site">Signaler un problème sur le site</option>
        <option value="info_site">Obtenir des informations sur le site</option><?php

      }else{
        if($orga =='mairie'){ ?>

          <option value="inscript_assoc">Inscrire mon Association</option>
          <option value="probleme_mairie">Signaler un problème sur la page de la Mairie</option>
					<option value="info_mairie">Obtenir des informations sur la Mairie</option><?php

        }elseif($orga == 'assoc'){ ?>

          <option value="inscript_menbre">Devenir membre de l'association</option>
          <option value="probleme_assoc">Signaler un problème sur la page de l'association</option>
          <option value="info_assoc">Obtenir des informations sur l'association</option><?php
        }
      } ?>
    </select><br/>
    <label for="contenu">Message</label><?php if(isset($error['contenu'])){ echo '<span>'.$error['contenu'].'</span>' ;} ?><br/>
    <textarea name="contenu" rows="8" cols="80"></textarea><br/>

		<input type="hidden" name="capcha" value="">
    <input type="submit" name="submit" value="envoyer">

  </form>
	<?php if($slug == 'All'){
		echo '<br/>* : Vous recevrez une réponse à votre demande d\'inscription de Mairie <br/> après étude de votre demande par nos services.';
	}
}else {
	echo $confirmation;
} ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
