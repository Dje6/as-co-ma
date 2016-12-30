<?php
namespace Controller\admin;

use \Controller\CustomController;
use Service\CustomFile;
use Model\PicturesModel;

class PicturesController extends CustomController
{
  public function homeEditionAvatarPost()
  {
    if(isset($_SESSION['user']))
    {

      function URLimg($path)
       {
           $app = getApp();
           $courant = str_replace('/','\\',$app->getBasePath() );
           $base = str_replace('/','\\',$_SERVER['DOCUMENT_ROOT'] );
           return $base.$courant. '\assets\\img\\'.$path;
       }
      $customFile = new CustomFile(URLimg('avatar'));
      $storage = new \Upload\Storage\FileSystem(URLimg('avatar'));
      $file = new \Upload\File('image', $storage);

      $new_filename = uniqid();
      $file->setName($new_filename);

      $file->addValidations(array(
      // Ensure file is of type "image/png"
      new \Upload\Validation\Mimetype(array('image/png', 'image/jpg', 'image/jpeg')),

      //You can also add multi mimetype validation
      //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

      // Ensure file is no larger than 5M (use "B", "K", M", or "G")
      new \Upload\Validation\Size('2M')
      ));
      $arrayDimensions = getimagesize($file);
      $data = array(
      'name'        => $new_filename,
      'extension'   => $file->getExtension(),
      'mime'        => $file->getMimetype(),
      'size'        => $file->getSize(),
      'width'       => $arrayDimensions[0],
      'height'      => $arrayDimensions[1],
      'emplacement' => $customFile->getDirectory() . $file->getNameWithExtension() ,
      'date_ajout'  => date('Y-m-d H:i:s'),
      );
      try {
      $upload = $file->upload();
      if($upload){
        $picturesModel = new PicturesModel();
        $insert = $picturesModel->insert($data);
        if($insert){
          $this->redirectToRoute('admin_monCompte');
        }
      } else {
        $this->redirectToRoute('admin_monCompte');
      }

      } catch (\Exception $e) {
          // Fail!
          $errors = $file->getErrors();
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
}
