<?php $this->layout('layout_back', ['title' => 'Liste','slug' => $slug,'orga' => $orga]) ?>
<!-- //tableau de donnee que l'on peu faire afficher au travers du layout -->

<?php $this->start('main_head') ?>
<!-- //ici les css de la page courante UNIQUEMENT
//si besoin d'un css dans TOUTE les pages , le mettre dans layout.php -->
<?php $this->stop('main_head') ?>

<?php $this->start('main_content') ?>
<h1 class="titreback">Administration</h1><br/><?php

// liste s'occupe d'afficher les boutons dans liste menbre et liste association , sur le back
echo '<div class="container affichage">';
if($orga == 'mairie'){
  if(isset($donnee)){
    if(is_array($donnee)){
      echo '<table>';
      foreach ($donnee as $key => $value) { ?>
        <tr>
          <td><?php echo $value['nom']; ?></td>
          <td><a href="<?php echo $this->url('racine_assoc',['orga' => 'Assoc','slug' => $value['slug']]);?>"><button class="btn btn-info bouge">Consulter</button></a></td>
          <td><a href="<?php echo $this->url('admin_mairie_contact_assoc',['slugE' => $slug,'slugR' => $value['slug']]);?>"><button class="btn btn-info bouge">Contacter</button></a></td>
          <?php if($value['status'] == 'Actif'){ ?>
            <td><a href="<?php echo $this->url('admin_mairie_edit_status',['slug' => $slug,'slugA' => $value['slug']]);?>"><button class="btn btn-warning bouge">Suspendre</button></a></td>
            <?php }else { ?>
              <td><a href="<?php echo $this->url('admin_mairie_edit_status',['slug' => $slug,'slugA' => $value['slug']]);?>"><button class="btn btn-success bouge">Activer</button></a></td>
              <?php } ?>
              <td><a href="<?php echo $this->url('admin_mairie_delete_assoc',['slug' => $slug, 'slugA' => $value['slug']]);?>"><button class="btn btn-danger bouge">Supprimer</button></a></td>

            </tr><?php
          } ?>
        </table> <?php
        }else{
          echo $donnee;
        }
      }
    }elseif ($orga == 'assoc') { ?>

      <form class="" action="<?php echo $this->url('admin_assoc_invit',['slug'=>$slug])?>" method="post">
        <?php if(isset($error['mail']) && !empty($error['mail'])){ echo '<span style="color:red;">'.$error['mail'].'</span><br/>' ;}
        if(isset($confirmation) && !empty($confirmation)){
          echo $confirmation.'<br/><br/>';
        }?>
        <label for="mail">Inviter quelqu'un à nous rejoindre? <br/>Entrez son adresse email :
          <input type="text" name="mail" value=""></label>
          <input type="submit" name="submit" value="Inviter!">
        </form> <?php

        if(isset($donnee)){
          if(is_array($donnee)){ ?>
            <table> <?php
            foreach ($donnee as $key => $value) { ?>

              <tr>

                <td class="bouge"><?php echo $value['pseudo'].' : '.$value['role']; ?></td>

                <td><a href="<?php echo $this->url('admin_assoc_membre',['slug' => $slug ,'id' => $value['id']]) ;?>"><button class="btn btn-info bouge">Consulter</button></a></td>
                <td><a href="<?php echo $this->url('admin_assoc_contact_membre',['slugE' => $slug,'id' => $value['id']]);?>"><button class="btn btn-info bouge">Contacter</button></a></td>
                <?php if($value['role'] == 'Admin'){ ?>
                  <td><a href="<?php echo $this->url('admin_assoc_edit_user_role',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-warning bouge">Passer en mode User</button></a></td>
                  <?php }else{ ?>
                    <td><a href="<?php echo $this->url('admin_assoc_edit_user_role',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-warning bouge">Passer en mode Admin</button></a></td>
                    <?php } ?>
                    <td><a href="<?php echo $this->url('admin_assoc_delete_user',['slug' => $slug, 'id' => $value['id']]);?>"><button class="btn btn-danger bouge">Supprimer</button></a></td>
                  </tr>
                  <?php

                } ?>
              </table> <?php
            }else{
              echo $donnee;
            }
          }
        }elseif ($orga == 'webmaster') {
          if(isset($donnee)){
            if(is_array($donnee)){ ?>
              <table> <?php
              foreach ($donnee as $key => $value) { ?>

                <tr>

                  <td class="bouge"><?php echo $value['nom'].' : '.$value['status']; ?></td>

                  <td><a href="<?php echo $this->url('racine_mairie',['orga' => 'Mairie','slug' => $value['slug']]);?>"><button class="btn btn-info bouge">Consulter</button></a></td>
                  <!-- <td><a href="<?php echo $this->url('admin_mairie_contact_assoc',['slugE' => $slug,'slugR' => $value['slug']]);?>"><button class="btn btn-info bouge">Contacter</button></a></td> -->
                  <?php if($value['status'] == 'Actif'){ ?>
                    <td><a href="<?php echo $this->url('admin_webmaster_edit_status',['id' => $value['id']]);?>"><button class="btn btn-warning bouge">Suspendre</button></a></td>
                    <?php }else { ?>
                      <td><a href="<?php echo $this->url('admin_webmaster_edit_status',['id' => $value['id']]);?>"><button class="btn btn-success bouge">Activer</button></a></td>
                      <?php } ?>
                      <td><a href="<?php echo $this->url('admin_webmaster_delete_mairie',['id' => $value['id']]);?>"><button class="btn btn-danger bouge">Supprimer</button></a></td>

                    </tr>
                    <?php

                  } ?>
                  </table> <?php
                }else{
                  echo $donnee;
                }
              }
            } ?>
          </div> <?php
            ?>
            <a href="#" class="btn btn-info return">Retour en haut</a>
            <?php $this->stop('main_content') ?>



            <?php $this->start('main_script') ?>
            <!-- //ici les script js de la Page courante UNIQUEMENT
            //si besoin d'un js dans TOUTE les pages , le mettre dans layout.php -->
            <?php $this->stop('main_script') ?>
