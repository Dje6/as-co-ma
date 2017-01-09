<?php
$this->layout('layout_back', ['title' => 'AS-CO-MA - News','slug' => $slug,'orga' => $orga]);
 ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content'); ?>

<h1 class="titreback">News</h1><br/>

  <div class="container-fluid">
    <div class="row messageall">
      <div class="bouton_env">
        <a href="<?php echo $this->url('admin_'.$orga.'_edit_news',['slug'=>$slug,'orga'=>$orga]); ?>">
          <button  class="btn btn-default ">Créer une news</button>
        </a>
      </div>
    </div>
  </div>
  <?php
  // ensuite on affiche les données retournées par sql

if(isset($donnees)){
	if(!empty($donnees)){
		if(is_array($donnees)){ // si donnee est un array on explore , sinon on affiche le message qu'il contient

			if(isset($pagination)){
				echo $pagination;
      }
      ?>

      <div class="container-fluid col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1 affichageMairie"><?php
  			foreach ($donnees as $key => $value) { ?>
          <div class="thumbnail">
          <h2> <?php echo $value['title']; ?></h2><br/>
          <?php if(!empty($value['picture'])){ ?>
            <img alt="User Pic" src="<?= $this->assetUrl($value['picture']) ?>"
            class="img-responsive "><?php
          }else { ?>
            <p class="textnews">Image : pas d'image</p><br/><?php
          } ?>
          <br/><p class="textnews"><br> <?= nl2br($value['content']); ?></p><br/>
          <p class="textnews">Crée le : <?php echo $value['created_at']; ?></p><?php
          if(!empty($value['updated_at'])){ ?>

            <p class="textnews">Modifié le : <?php echo $value['updated_at']; ?></p><br/><?php
          }
          if(!empty($value['newsletter'])){ ?>
            <p class="textnews">NewsLetter Envoyée : <?php echo $value['newsletter']; ?></p><br/><?php

          } ?>

          <a href="<?php echo $this->url('admin_'.$orga.'_update_news',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
            <button class="btn btn-success ">Modifier</button>
          </a>
          <?php
          if($value['status'] == 'Activer'){ ?>
            <a href="<?php echo $this->url('admin_'.$orga.'_status_news',['id' => $value['id'],
            'orga' => $orga,'slug' => $slug ,'page' => $page]); ?> ">
              <button class="btn btn-warning ">Désactiver</button>
            </a><?php
          }else {  ?>
            <a href="<?php echo $this->url('admin_'.$orga.'_status_news',['id' => $value['id'],
            'orga' => $orga,'slug' => $slug,'page' => $page]); ?> ">
              <button class="btn btn-warning ">Activer</button>
            </a><?php
          }?>
          <a href="<?php echo $this->url('admin_'.$orga.'_delete_news',['id' => $value['id'],
          'orga' => $orga,'slug' => $slug,'page' => $page]); ?> ">
          <button class="btn btn-danger ">Supprimer</button>
        </a><?php
          if(empty($value['newsletter'])){ ?>
            <a href="<?php echo $this->url('admin_'.$orga.'_newsletter',['id' => $value['id'],
            'orga' => $orga,'slug' => $slug,'page' => $page]); ?> " class="marginR">
            <button class="btn btn-success marginR ">Déclencher la NewsLetter</button>
          </a><br><?php
        } ?>
          </div>
      <?php }

			if(isset($pagination)){ //si il y a assez d'element , la pagination s'active toute seul
				echo $pagination;
			}
    }else{ ?>
      <h3 class="titreback"><?= $donnees; ?></h3>
<?php
    }
	}
}
?>
  </div>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
