<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\PicturesModel;
use \Model\UserModel;
use \Model\MairieModel;
use \Model\AssocModel;
use \Model\NewsModel;


class PicturesController extends CustomController
{
  public function picturesPost($orga,$slug,$type,$id_article=NULL)
  {
    if(isset($_SESSION['user']))
    {
      $picturesModel = new PicturesModel();
      if($orga == 'users' && $slug == 'users'){
        $hauteurMaximum = 250;
        $largeurMaximum = 250;
        $tableModel = new UserModel;
        $id = $_SESSION['user']['id'];

      }else{
        if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          if($type == 'news'){
            $hauteurMaximum = 300;
            $largeurMaximum = 550;
          }else {
            $hauteurMaximum = 540;
            $largeurMaximum = 1170;
          }

          if($orga == 'assoc'){
            if($type == 'news'){
              $tableModel = new NewsModel;
            }else {
              $tableModel = new AssocModel;
            }
          }elseif ($orga == 'mairie') {
            if($type == 'news'){
              $tableModel = new NewsModel;
            }else {
              $tableModel = new MairieModel;
            }
          }
          if($type == 'news'){
            $id = $id_article;
          }else {
            $id = $tableModel->FindElementByElement('id','slug',$slug);
          }
        }
      }
      if($type == 'news'){
        $id_picture_actuel = $tableModel->FindElementByElement('picture','id',$id);
      }else {
        $id_picture_actuel = $tableModel->FindElementByElement($type,'id',$id);
      }
      $picture_actuel = $picturesModel->Find($id_picture_actuel);

      $chemin = $this->URLimg($orga.'\\'.$type);
      $storage = new \Upload\Storage\FileSystem($chemin);
      $file = new \Upload\File('image', $storage);

      $new_filename = uniqid();
      $file->setName($new_filename);

      $file->addValidations(array(
        new \Upload\Validation\Mimetype(array('image/png', 'image/jpg', 'image/jpeg')),
        //RAPPEL !!  1 Byte = 1 octet = 8 bits
        new \Upload\Validation\Size('2M')
      ));

      try{
        $upload = $file->upload();
        if($upload){

          $element = $file->getNameWithExtension();
          $this->convertImage($chemin,$element,$orga,$type,$largeurMaximum,$hauteurMaximum);

          $element = '\\'.$new_filename.'.jpg';

          $arrayDimensions = getimagesize($chemin.$element);
          $data = array(
          'name'        => $new_filename,
          'extension'   => 'jpg',
          'mime'        => mime_content_type($chemin.$element),
          'size'        => filesize($chemin.$element),
          'width'       => $arrayDimensions[0],
          'height'      => $arrayDimensions[1],
          'emplacement' => $chemin.$element ,
          'relatif'     => 'img/'.$orga.'/'.$type.'/'.$new_filename.'.jpg',
          'date_ajout'  => date('Y-m-d H:i:s'),
          );


          if($picturesModel->insert($data)){
            $id_picture = $picturesModel->FindElementByElement('id','name',$new_filename);

            if(!empty($picture_actuel)){
              $nom_ancienne_pic = $picture_actuel['name'].'.'.$picture_actuel['extension'];

              if($picturesModel->delete($picture_actuel['id'])){
                unlink('./assets/img/'.$orga.'/'.$type.'/'.$nom_ancienne_pic);
              }
            }
            if($type == 'news'){
              $result = $tableModel->update(['picture' => $id_picture],$id);
            }else {
              $result = $tableModel->update([$type => $id_picture],$id);
            }

            if($result){
              if($orga == 'users' && $id == $_SESSION['user']['id']){
                $_SESSION['user']['avatar'] = 'img/'.$orga.'/'.$type.'/'.$new_filename.'.jpg';
              }
              if(isset($_POST['route'])){
                $route = trim(strip_tags($_POST['route']));
              }
              if(isset($route) && !empty($route)){
                header('Location: '.$route);
              }else {
                return true;
              }
            }
          }
        }
      } catch (\Exception $e) {
          // Fail!
          $this->showErrors($file->getErrors());
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  public function URLimg($path)
  {
    $app = getApp();
    $courant = str_replace('/','\\',$app->getBasePath() );
    $base = str_replace('/','\\',$_SERVER['DOCUMENT_ROOT'] );
    return $base.$courant. '\assets\\img\\'.$path;
  }

  public function convertImage($chemin,$element,$orga,$type,$largeurMaximum,$hauteurMaximum)
  {
    //on trouve l'image a travailler
    $originalImage = $chemin.'\\'.$element;
    // on detecte lextension
    // jpg,jpeg,png,gif,bmp
    $exploded = explode('.',$element);
    $ext = $exploded[count($exploded) - 1];
    //lextension
    $nom = $exploded[count($exploded) - 2];
    //le nom sans extension

    //on analise les dimension de limage et calcule le ration pour savoir
    //si c'est un portrait ou un paysage
    $dim= getimagesize($originalImage);
    $forme = $dim[0]/$dim[1];
    //largeur diviser par hauteur

    if ($forme < 1){
    //pour une image en portrait
      $larg = $dim[0]/$hauteurMaximum;
      $haut = $dim[1]/$hauteurMaximum;
      $largeur = (($dim[0]/$larg)*$forme);
      $hauteur = ($dim[1]/$haut);
    }else{
      //pour une paysage
      $larg = $dim[0]/$largeurMaximum;
      $haut = $dim[1]/$largeurMaximum;
      $largeur = ($dim[0]/$larg);
      $hauteur = (($dim[1]/$haut)/$forme);
    }

    if(preg_match('/jpg|jpeg/i',$ext)){
      $source=imagecreatefromjpeg($originalImage);

    }elseif(preg_match('/png/i',$ext)){
      $source=imagecreatefrompng($originalImage);

    }elseif(preg_match('/gif/i',$ext)){
      $source=imagecreatefromgif($originalImage);

    }elseif(preg_match('/bmp/i',$ext)){
      $source=imagecreatefromwbmp($originalImage);

    }else{
      return false;
    }

    $destination = imagecreatetruecolor($largeur, $hauteur);
    $largeur_source = imagesx($source);
    $hauteur_source = imagesy($source);
    $largeur_destination = imagesx($destination);
    $hauteur_destination = imagesy($destination);
    imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

    $croper = imagecropauto($destination , IMG_CROP_THRESHOLD, null, 16777215);

    if(imagejpeg($croper, './assets/img/'.$orga.'/'.$type.'/'.$nom.'.jpg',100)){
      imagedestroy($source);
      if($ext != 'jpg' && $ext != 'jpeg'){
        unlink($originalImage);
      }

      return true;

    }else {
      return false;
    }

  }

}
