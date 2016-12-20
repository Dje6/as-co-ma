<?php
if(!isset($slug)){ $slug = 'user' ;}
if(!isset($orga)){ $orga = 'user' ;}
$this->layout('layout_back', ['title' => 'Message','slug' => $slug,'orga' => $orga]);
 ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
	<h1 class="titreback">Messagerie</h1><br/>
<?php
if(isset($donnees)){
	if(!empty($donnees)){
		if(is_array($donnees)){ // si donnee est un array on explore , sinon on affiche le message quil contient

			// if(!empty($limit)){ //affiche le nombre delement par page
			// 	echo 'Message par page : '.$limit.'<br/><br/>' ;
			// }
			if(isset($pagination)){ //si il y a assez d'element , la pagination s'active toute seul
				echo $pagination;
			}
      echo '<div class="container affichageMairie">';
			foreach ($donnees as $key => $value) {

        echo '<br/>';
				echo 'Envoyé par : '.$value['emeteur_pseudo'].'<br/><br/>';
				echo 'Email : '.$value['emeteur_mail'].'<br/>';
        echo 'Envoyé le : '.$value['date_envoi'].'<br/><br/>';
				echo 'Objet : '.$value['objet'].'<br/>';
				echo 'Message : '.$value['contenu'].'<br/><br/>';



        preg_match_all('/inscript/', $value['objet'], $matches); // on detect si il s'agit dune demande d'inscription
        if(!empty($matches[0])){ //si oui on affiche les bouton de decision ?>
          <a href="<?php echo $this->url('admin_accepte',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
            <button>Accepter</button></a>
          <a href="<?php echo $this->url('admin_plus_info',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
            <button>Manque d'information</button></a>
          <a href="<?php echo $this->url('admin_refuse',['id' => $value['id'],'orga' => $orga,'slug' => $slug]); ?> ">
            <button>Refuser</button></a><?php
        }else{ //sinon j'affiche le bouton pour repondre, qui redirige vers un champ de saisi texte
          if($orga == 'user'){?>
            <a href="<?php echo $this->url('admin_repondre_User',['id'=> $value['id']]) ; ?>">
            <button class="btn btn-primary">Repondre</button></a><?php
          }else { ?>
            <a href="<?php echo $this->url('admin_repondre',['id'=> $value['id'],'orga' => $orga,'slug' => $slug]) ; ?>">
            <button class="btn btn-primary">Repondre</button></a><?php
          }
        }
				echo '<br/><br/>';
			}
        echo '</div">';
			if(isset($pagination)){ //si il y a assez d'element , la pagination s'active toute seul
				echo $pagination;
			}
		}
	}else{
    echo '<h3 class="titreback">Aucun messages</h3>';
  }
}
?>
<!-- <a href="#" class="btn btn-info return">Retour Menu</a> -->
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
