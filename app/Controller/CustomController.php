<?php
namespace Controller ;

use \W\Controller\Controller;
use \Model\UsersCustomModel;
use \Model\MairieModel;
use \Model\AssocModel;

class CustomController extends Controller
{
  //retourne les information des mairie ou association
  public function infoBdd($orga,$slug,$status)
  {
    if($orga == 'Mairie'){
      $MairieModel = new MairieModel;
      return $MairieModel->findSlug($slug,$status);
    }elseif ($orga == 'Assoc') {
      $AssocModel = new AssocModel;
      return $AssocModel->findSlug($slug,$status);
    }
  }
  //liste les menbre des assoc ou association des mairie
  public function listing($orga,$slug)
  {
    if($orga == 'Mairie'){
      $MairieModel = new MairieModel;
      return $MairieModel->findListe($slug);
    }elseif ($orga == 'Assoc') {
      $AssocModel = new AssocModel;
      return $AssocModel->findMenbre($slug);
    }
  }
  //recherche en base de donnee lorganisme specifier
  public function searchOrga($orga,$slug,$POST)
  {
    $r_POST = $this->nettoyage($POST);
    if(empty($r_POST['capcha'])){
      if(!empty($r_POST['cp'])){

        if($orga == 'Mairie'){
          $MairieModel = new MairieModel;
          return $MairieModel->searchMairie($r_POST['cp']);
        }elseif ($orga == 'Assoc') {
          $AssocModel = new AssocModel;
          return $AssocModel->searchAssoc($r_POST['cp']);
        }
      }else{
        return 'merci de saisir une recherche';
      }
    }else{
      return 'vous etes un bot';
    }
  }

  public function allowToTwo($roles,$organisation,$slug_orga)
  {
    if (!is_array($roles)){
      $roles = [$roles];
    }
    $UserCustomModel = new UsersCustomModel();
    foreach($roles as $role){
      if ($UserCustomModel->isGranted($role,$organisation,$slug_orga)){
        return true;
      }
    }

    $this->showForbidden();
  }

  //surcharge !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  //surcharge !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  //surcharge !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  //surcharge !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  //surcharge !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  //surcharge !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  //surcharge !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

  public function show($file, array $data = array())
  {
    //incluant le chemin vers nos vues
    $engine = new \League\Plates\Engine(self::PATH_VIEWS);

    //charge nos extensions (nos fonctions personnalisées)
    $engine->loadExtension(new \W\View\Plates\PlatesExtensions());
    $engine->loadExtension(new \Service\Extension );

    $app = getApp();

    // Rend certaines données disponibles à tous les vues
    // accessible avec $w_user & $w_current_route dans les fichiers de vue
    $engine->addData(
      [
        'w_user' 		  => $this->getUser(),
        'w_current_route' => $app->getCurrentRoute(),
        'w_site_name'	  => $app->getConfig('site_name'),
      ]
    );

    // Retire l'éventuelle extension .php
    $file = str_replace('.php', '', $file);

    // Affiche le template
    echo $engine->render($file, $data);
    die();
  }


  //trim stip tag la totaliter des donnee recu
  // que se soit une string , un array , ou un array multidimensionel
  //ex : $_POST ou $_GET
  function nettoyage($array)
  {
    if(is_array($array)){ //detecte si c un array
      $monarray = array();
      foreach ($array as $key => $value) {
          if(is_array($value)){//detecte si il sagi d'un array multidimensionel
            foreach ($value as $key_y => $value_y) {
              $monarray[$key][$key_y] = trim(strip_tags($value_y));
            }
          }else{ // si c'est un array simple on retourne les valeur
            $monarray[$key] = trim(strip_tags($value));
          }
      }
      return($monarray);
    }else{// si c'est juste une string on striptag et retourne
      $string = trim(strip_tags($array));
      return $string;
    }
  }
  //fonction in array mais qui fonctionne dans un array multi dimensionel
  public function in_multi_array($string,$array){
    foreach ($array as $key => $value) {
      if(in_array($string,$value)){
        return true;
      }
    }
    return false;
  }
  public function in_multi_array_return_array($string,$array){
    foreach ($array as $key => $value) {
      if(in_array($string,$value)){
        return $value;
      }
    }
    return false;
  }
}
