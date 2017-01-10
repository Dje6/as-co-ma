<?php $this->layout('layout_back', ['title' => 'AS-CO-MA - Listing','slug' => $slug,'orga' => $orga]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<link rel="stylesheet" href="<?= $this->assetUrl('css_back/modal.css') ?>">
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1 class="titreback">Administration</h1><br/>

<!-- liste s'occupe d'afficher les boutons dans liste menbre et liste association , sur le back -->
<div class="container-fluid col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1 affichage">
    <?php
    if($orga == 'mairie'){
      if(isset($donnee)){
        if(is_array($donnee)){
          foreach ($donnee as $key => $value) { ?>
            <div class="row col-xs-12">

              <span id="span_update<?php echo $value['id']; ?>" class="col-xs-12 col-sm-4"><?php echo $value['nom']; ?></span>
              <span class="col-xs-12 col-sm-2">
                <a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]);?>"><button class="btn btn-info ">Consulter</button></a>
              </span>
              <span class="col-xs-12 col-sm-2">
                <a href="<?php echo $this->url('admin_mairie_contact_assoc',['slugE' => $slug,'slugR' => $value['slug']]);?>">
                  <button class="btn btn-info ">Contacter</button>
                </a>
              </span>
              <?php if($value['status'] == 'Actif'){ ?>
                <span class="col-xs-12 col-sm-2">
                  <a class="update_suspendre <?php echo $value['id']; ?>" href="<?php echo $this->url('admin_mairie_edit_status',['slug' => $slug,'slugA' => $value['slug']]);?>">
                    <button class="btn btn-warning update_suspendre_btn<?php echo $value['id']; ?> ">Suspendre</button>
                  </a>
                </span>
              <?php }else { ?>
                <span class="col-xs-12 col-sm-2">
                  <a class="update_activer <?php echo $value['id']; ?>" href="<?php echo $this->url('admin_mairie_edit_status',['slug' => $slug,'slugA' => $value['slug']]);?>">
                    <button class="btn btn-success update_activer_btn<?php echo $value['id']; ?> ">Activer</button>
                  </a>
                </span>
              <?php } ?>
              <span class="col-xs-12 col-sm-2">
                <a class="delete_assoc" href="<?php echo $this->url('admin_mairie_delete_assoc',['slug' => $slug, 'slugA' => $value['slug']]);?>">
                  <button class="btn btn-danger">Supprimer</button>
                </a>
              </span>
            </div>
    <?php
          }
        }else{
          echo $donnee;
        }
      }
    }elseif ($orga == 'assoc') { ?>

      <form action="<?php echo $this->url('admin_assoc_invit',['slug'=>$slug])?>" method="POST">
        <?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span style="color:red;">'.$error['mail'].'</span><br/>' ;}
          if(isset($confirmation) && !empty($confirmation)){
            echo $confirmation.'<br/><br/>';
          }?>
        <label for="mail"><p class="padleft">Inviter quelqu'un à nous rejoindre? </p><p class="padleft">Entrez son adresse email :
        <input type="text" name="mail" value=""></p></label>
        <input type="submit" name="submit" value="Inviter!">
      </form>
      <?php

      if(isset($donnee)){
        if(is_array($donnee)){
          foreach ($donnee as $key => $value) { ?>
            <div class="row col-xs-12 ">

              <span id="span_roles<?php echo $value['id']; ?>" class="col-xs-12 col-sm-3 <?php echo $value['pseudo']; ?>"><?php echo $value['pseudo'].' : '.$value['role']; ?></span>
              <span class="col-xs-12 col-sm-2">
                <a href="<?php echo $this->url('admin_assoc_membre',['slug' => $slug ,'id' => $value['id']]) ;?>" data-width="500" data-rel="popup1" class="poplight"><button class="btn btn-info ">Consulter</button></a>
              </span>
              <?php if ($_SESSION['user']['id'] != $value['id']){ ?>


              <span class="col-xs-12 col-sm-2">
                <a href="<?php echo $this->url('admin_assoc_contact_membre',['slugE' => $slug,'id' => $value['id']]);?>"><button class="btn btn-info ">Contacter</button></a>
              </span>
              <?php if($value['role'] == 'Admin'){ ?>
                <span class="col-xs-12 col-sm-3">
                  <a class="update_user <?php echo $value['id']; ?>" href="<?php echo $this->url('admin_assoc_edit_user_role',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-warning update_user_btn<?php echo $value['id']; ?> ">Attribuer role User</button></a>
                </span>
              <?php }else{ ?>
                <span class="col-xs-12 col-sm-3">
                  <a class="update_admin <?php echo $value['id']; ?>" href="<?php echo $this->url('admin_assoc_edit_user_role',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-warning update_admin_btn<?php echo $value['id']; ?> ">Attribuer role Admin</button></a>
                </span>
              <?php } ?>
                <span class="col-xs-12 col-sm-2">
                  <a class="delete_user" href="<?php echo $this->url('admin_assoc_delete_user',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-danger ">Supprimer</button></a>
                </span>
              <?php } ?>
            </div>
            <?php

          }
        }else{
          echo $donnee;
        }
      }


}elseif ($orga == 'webmaster') {
  if(isset($donnee)){
    if(is_array($donnee)){
      foreach ($donnee as $key => $value) { ?>
        <div class="row col-xs-12">
          <span class="col-xs-12 col-sm-4"><?php echo $value['nom'].' : '.$value['status']; ?></span>
          <span class="col-xs-12 col-sm-2">
            <a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => $value['slug']]);?>"><button class="btn btn-info ">Consulter</button></a>
          </span>
           <span  class="col-xs-12 col-sm-2"><a href="<?php echo $this->url('admin_mairie_contact_assoc',['slugE' => $slug,'slugR' => $value['slug']]);?>"><button class="btn btn-info ">Contacter</button></a></span>
          <?php if($value['status'] == 'Actif'){ ?>
          <span class="col-xs-12 col-sm-2">
            <a href="<?php echo $this->url('admin_webmaster_edit_status',['id' => $value['id']]);?>"><button class="btn btn-warning ">Suspendre</button></a>
          </span>
          <?php }else { ?>
          <span class="col-xs-12 col-sm-2">
            <a href="<?php echo $this->url('admin_webmaster_edit_status',['id' => $value['id']]);?>"><button class="btn btn-success ">Activer</button></a>
          </span>
          <?php } ?>
          <span class="col-xs-12 col-sm-2">
            <a class="delete_mairie" href="<?php echo $this->url('admin_webmaster_delete_mairie',['id' => $value['id']]);?>"><button class="btn btn-danger ">Supprimer</button></a>
          </span>
        </div>
        <?php
           }
        }else{
          echo $donnee;
        }
      }
    } ?>
 </div>

<!-- pop up pour la fiche membre -->
 <div id="popup1" class="popup_block col-xs-12 col-xs-offset-0 col-sm-8 col-sm-offset-2 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2" style="text-align:center;">

  <h3 class="userpseudo modal_user_pseudo"></h3><br/>
  <span class="modal_avatar col-xs-4 col-xs-offset-4">
  </span>

   <table class="table table-user-information">
     <tbody>
       <tr>
         <td class="modal_nom"></td>
       </tr>
       <tr>
         <td class="modal_prenom"></td>
       </tr>
       <tr>
         <td class="modal_mail"></td>
       </tr>
       <tr>
         <td class="modal_adresse"></td>
       </tr>
       <tr>
         <td class="modal_code_postal"></td>
       </tr>
       <tr>
         <td class="modal_ville"></td>
       </tr>
       <tr>
         <td class="modal_fix"></td>
       </tr>
       <tr>
         <td class="modal_portable"></td>
       </tr>

     </tbody>
   </table>
</div>

<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<script type="text/javascript" src="<?= $this->assetUrl('js/update_status.js'); ?>"></script>
  <script type="text/javascript" src="<?= $this->assetUrl('js/delete.js'); ?>"></script>
    <script type="text/javascript" src="<?= $this->assetUrl('js/modal.js'); ?>"></script>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
