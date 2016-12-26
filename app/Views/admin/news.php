<?php
$this->layout('layout_back', ['title' => 'News','slug' => $slug,'orga' => $orga]);
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
          <button  class="btn btn-default ">Creer une news</button>
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

      <div class="container affichageMairie"><?php
  			foreach ($donnees as $key => $value) { ?>

          <abc>Titre : <?php echo $value['title']; ?></abc><br>
          <abc>Contenu : <?php echo $value['content']; ?></abc><br>
          <abc>Creer le : <?php echo $value['created_at']; ?></abc><br>
          <abc>Modifier le : <?php echo $value['updated_at']; ?></abc><br>

          <a href="<?php echo $this->url('admin_'.$orga.'_update_news',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
            <button class="btn btn-success">Modifier</button>
          </a>
          <?php
          if($value['status'] == 'Activer'){ ?>
            <a href="<?php echo $this->url('admin_'.$orga.'_status_news',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
              <button class="btn btn-warning">Desactiver</button>
            </a><?php
          }else {  ?>
            <a href="<?php echo $this->url('admin_'.$orga.'_status_news',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
              <button class="btn btn-warning">Activer</button>
            </a><?php
          }?>
          <a href="<?php echo $this->url('admin_'.$orga.'_delete_news',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
          <button class="btn btn-danger">Supprimer</button>
        </a><?php
        }?>
      </div><?php
			if(isset($pagination)){ //si il y a assez d'element , la pagination s'active toute seul
				echo $pagination;
			}
    }else{
      echo '<h3 class="titreback">'.$donnees.'</h3>';
    }
	}
}
?>
 <a href="#" class="btn btn-info return">Retour Menu</a>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
