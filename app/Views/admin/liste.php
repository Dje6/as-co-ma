<?php $this->layout('layout_back', ['title' => 'Liste','slug' => $slug,'orga' => $orga]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1 class="titreback">Administration</h1><br/>

<!-- liste s'occupe d'afficher les boutons dans liste menbre et liste association , sur le back -->
<div class="container affichage">
  <div class="row">
    <?php
    if($orga == 'mairie'){
      if(isset($donnee)){
        if(is_array($donnee)){
          echo '<div class="container">';
          foreach ($donnee as $key => $value) { ?>
            <div class="row col-xs-12">
              <span class="col-xs-12 col-sm-2"><?php echo $value['nom']; ?></span>
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
                  <a href="<?php echo $this->url('admin_mairie_edit_status',['slug' => $slug,'slugA' => $value['slug']]);?>">
                    <button class="btn btn-warning ">Suspendre</button>
                  </a>
                </span>
              <?php }else { ?>
                <span class="col-xs-12 col-sm-2"><a href="<?php echo $this->url('admin_mairie_edit_status',['slug' => $slug,'slugA' => $value['slug']]);?>"><button class="btn btn-success ">Activer</button></a></span>
              <?php } ?>
              <span class="col-xs-12 col-sm-2"><a href="<?php echo $this->url('admin_mairie_delete_assoc',['slug' => $slug, 'slugA' => $value['slug']]);?>"><button class="btn btn-danger ">Supprimer</button></a></span>
            </div>
    <?php
          }
          echo '</div>';
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
          echo '<div class="container">';
          foreach ($donnee as $key => $value) { ?>
            <div class="row col-xs-12 listing">

              <span class="col-xs-12 col-sm-2"><?php echo $value['pseudo'].' : '.$value['role']; ?></span>
              <span class="col-xs-12 col-sm-2">
                <a href="<?php echo $this->url('admin_assoc_membre',['slug' => $slug ,'id' => $value['id']]) ;?>"><button class="btn btn-info ">Consulter</button></a>
              </span>
              <span class="col-xs-12 col-sm-2">
                <a href="<?php echo $this->url('admin_assoc_contact_membre',['slugE' => $slug,'id' => $value['id']]);?>"><button class="btn btn-info ">Contacter</button></a>
              </span>
              <?php if($value['role'] == 'Admin'){ ?>
                <span class="col-xs-12 col-sm-2">
                  <a href="<?php echo $this->url('admin_assoc_edit_user_role',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-warning ">Passer en mode User</button></a>
                </span>
              <?php }else{ ?>
                <span class="col-xs-12 col-sm-2">
                  <a href="<?php echo $this->url('admin_assoc_edit_user_role',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-warning ">Passer en mode Admin</button></a>
                </span>
              <?php } ?>
                <span class="col-xs-12 col-sm-2">
                  <a href="<?php echo $this->url('admin_assoc_delete_user',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-danger ">Supprimer</button></a>
                </span>
            </div>
            <?php

          }
          echo '</div>';
        }else{
          echo $donnee;
        }
      }


}elseif ($orga == 'webmaster') {
  if(isset($donnee)){
    if(is_array($donnee)){
      echo '<div class="container">';
      foreach ($donnee as $key => $value) { ?>
        <div class="row col-xs-12 listing">
          <span class="col-xs-12 col-sm-3"><?php echo $value['nom'].' : '.$value['status']; ?></span>
          <span class="col-xs-12 col-sm-3">
            <a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => $value['slug']]);?>"><button class="btn btn-info ">Consulter</button></a>
          </span>
          <!-- <td><a href="<?php echo $this->url('admin_mairie_contact_assoc',['slugE' => $slug,'slugR' => $value['slug']]);?>"><button class="btn btn-info ">Contacter</button></a></td> -->
          <?php if($value['status'] == 'Actif'){ ?>
          <span class="col-xs-12 col-sm-3">
            <a href="<?php echo $this->url('admin_webmaster_edit_status',['id' => $value['id']]);?>"><button class="btn btn-warning ">Suspendre</button></a>
          </span>
          <?php }else { ?>
          <span class="col-xs-12 col-sm-3">
            <a href="<?php echo $this->url('admin_webmaster_edit_status',['id' => $value['id']]);?>"><button class="btn btn-success ">Activer</button></a>
          </span>
          <?php } ?>
          <span class="col-xs-12 col-sm-3">
            <a href="<?php echo $this->url('admin_webmaster_delete_mairie',['id' => $value['id']]);?>"><button class="btn btn-danger ">Supprimer</button></a>
          </span>
        </div>
        <?php

          }
          echo '</div>';
        }else{
          echo $donnee;
        }
      }
    } ?>
  </div>
 </div>

<a href="#" class="btn btn-info return">Retour en haut</a>
<?php $this->stop('main_content') ?>



<?php $this->start('main_script') ?>
	<!-- //ici les script js de la Page courante UNIQUEMENT
  //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_script') ?>
