<?php $this->layout('layout_back', ['title' => 'AS-CO-MA - Contact','slug' => $slug,'orga' => $orga]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>



<?php $this->start('main_content') ?>
<?php
if(!isset($confirmation)){

	if($slug == 'All'){ ?>
		<p>Contacter les administrateurs du site</p>
	<?php
	}else{
		if($orga == 'mairie'){ ?>
			<p>Contacter la <?= $slug; ?></p>
		<?php
	}elseif($orga == 'assoc') { ?>
			<p>Contacter l'association <?= $slug; ?></p>
	<?php
		}
	} ?>
  <form class="" action="<?php echo $this->url('racine_contact_send',['orga'=> $orga,'slug'=>$slug]); ?>" method="POST">
    <label for="emeteur_pseudo">Pseudo</label><?php if(isset($error['emeteur_pseudo'])){ echo '<span>'.$error['emeteur_pseudo'].'</span>' ;} ?><br/>
		<?php if($_SESSION['user']){ ?>
			<input type="text" name="emeteur_pseudo" value="<?= $_SESSION['user']['pseudo']; ?>" readonly><br/>
		<?php
		}else{ ?>
		 <input type="text" name="emeteur_pseudo" value=""><br/>
		<?php
	 	} ?>
    <label for="mail">Email</label><?php if(isset($error['mail'])){ echo '<span>'.$error['mail'].'</span>' ;} ?><br/>
		<?php if($_SESSION['user']){ ?>
		 <input type="text" name="mail" value="<?= $_SESSION['user']['mail']; ?>" readonly><br/>
		<?php
		}else{ ?>
		 <input type="text" name="mail" value=""><br/>
		<?php
		} ?>
    <label for="objet">Objet</label><?php if(isset($error['objet'])){ echo '<span>'.$error['objet'].'</span>' ;} ?><br/>
    <select class="" name="objet"><?php
      if($slug == 'All'){ ?>

        <option value="inscript_mairie">Inscrire ma Mairie*</option>
        <option value="probleme_site">Signaler un probleme sur le site</option>
        <option value="info_site">Obtenir des informations sur le site</option><?php

      }else{
        if($orga =='mairie'){ ?>

          <option value="inscript_assoc">Inscrire mon Association</option>
          <option value="probleme_mairie">Signaler un probleme sur la page de la Mairie</option>
					<option value="info_mairie">Obtenir des informations sur la mairie</option><?php

        }elseif($orga == 'assoc'){ ?>

          <option value="inscript_menbre">Devenir Membre</option>
          <option value="probleme_assoc">Signaler un probleme sur la page de l'association</option>
          <option value="info_assoc">Obtenir des informations sur l'association</option><?php
        }
      } ?>
    </select><br/>
    <label for="contenu">Message</label><?php if(isset($error['contenu'])){ echo '<span>'.$error['contenu'].'</span>' ;} ?><br/>
    <textarea name="contenu" rows="8" cols="80"></textarea><br/>

		<input type="hidden" name="capcha" value="">
    <input type="submit" name="submit" value="envoyer">

  </form>
	<?php if($slug == 'All'){ ?>
		<br/><p>* : Pour toute inscription de mairie, <br/>nous vous recontacterons pour confirmation de votre identité.</p>
	<?php
	}
}else {
	echo $confirmation;
} ?>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
