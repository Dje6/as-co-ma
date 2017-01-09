<?php
if(!isset($slug)){ $slug = 'user' ;}
if(!isset($orga)){ $orga = 'user' ;}
$this->layout('layout_back', ['title' => 'AS-CO-MA - Messagerie','slug' => $slug,'orga' => $orga]);
 ?>
<!-- //tableau de données que l'on peut faire afficher au travers du layout -->


<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content');

if(isset($orga) && ($orga == 'mairie' || $orga == 'assoc' || $orga == 'webmaster')){
  $urlSend = $this->url('admin_message_send_'.$orga,['slug' => $slug,'orga' => $orga,'page' => 1]);
  $urlReceive = $this->url('admin_message_'.$orga,['slug' => $slug,'orga' => $orga,'page' => 1]);
}else{
  $urlSend = $this->url('admin_message_send',['page' => 1]);
  $urlReceive = $this->url('admin_message',['page' => 1]);
}?>


<!-- l'affichage commence ici ,avec les deux boutons pour les messages recus ou envoyés -->
<h1 class="titreback">Messagerie</h1>
<div class="container-fluid col-md-12 col-offset-0 col-lg-10 col-lg-offset-1">
  <div class="container-fluid col-lg-12 ">
    <div class="row center"><?php
      if(isset($Recu)){
        $class_btn_Recu = 'btn-secondary';
        $class_btn_Envoyer = 'btn-primary';
        $class_div_Envoyer = 'DisplayNone';
      }else{
        $class_btn_Recu = 'btn-primary';
        $class_btn_Envoyer = 'btn-secondary';
        $class_div_Recu = 'DisplayNone';
      }?>

      <a class="bouton_rec" href="<?php echo $urlReceive; ?>">
        <button  class="btn <?= $class_btn_Envoyer ;?>">Messages Reçus</button>
      </a>
      <a class="bouton_env" href="<?php echo $urlSend ; ?>">
        <button  class="btn <?= $class_btn_Recu ;?>">Messages Envoyés</button>
      </a>
    </div>
  </div>

  <div id="DivRecu" class="container-fluid col-lg-12 row affichageMairie <?= $class_div_Recu; ?>">
    <div class="pagin Recu"><?php
      if(isset($paginationRecu)){
        echo $paginationRecu;
      } ?>
    </div>
    <div id="Recu" class=""><?php
      if(isset($Recu)){
      echo $Recu;
      } ?>
    </div>
    <div class="pagin Recu"><?php
      if(isset($paginationRecu)){
  			echo $paginationRecu;
      } ?>
    </div>
  </div>

  <div id="DivEnvoyer" class="container-fluid col-lg-12 row affichageMairie <?= $class_div_Envoyer; ?>">
    <div class="pagin Envoyer"><?php
      if(isset($paginationEnvoyer)){
        echo $paginationEnvoyer;
      } ?>
      </div>
      <div id="Envoyer" class=""><?php
        if(isset($Envoyer)){
            echo $Envoyer;
        } ?>
      </div>
      <div class="pagin Envoyer"><?php
      if(isset($paginationEnvoyer)){
        echo $paginationEnvoyer;
      } ?>
    </div>
  </div>
</div><!-- fin de la div global -->

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
<script type="text/javascript" src="<?= $this->assetUrl('js/messageAjax.js'); ?>"></script>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
