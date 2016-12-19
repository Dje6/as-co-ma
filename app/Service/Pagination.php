<?php
namespace Service;
use \Model\CustomModel;
use \W\Model\ConnectionModel;
use \Controller\CustomController;

class Pagination extends CustomModel
{
  // la table dans la quel on va travailler
  public function __construct($table)
  {
    $this->setTable($table);
    $this->dbh = ConnectionModel::getDbh() ;

  }

  public function calcule_page($where='',$num,$page)
  {
    //on calcule le nombre de page en divisan le total par mon nombre d'article
    //et on arrondi avec ceil pour avoir un nombre entier
    $where_full ='';
    if($where != ''){
      $where_full = 'WHERE '.$where;
    }
    $tab = $this->getTable() ;
    $sql = "SELECT COUNT(id) FROM $this->table $where_full ";
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $count = $sth->fetchColumn();

    $nb_page = ceil($count/$num);
    $result['nb_page'] = $nb_page;
    //on declare page et offset
    if(!empty($page) && is_numeric($page) && ctype_digit($page) && ($page <= $nb_page) && ($page > 0)){
      $result['page'] = $page;
      $result['offset'] = (($page-1)*$num);
    }else {
      $result['page'] = 1;
      $result['offset'] = 0;
    }
    return $result;
  }
  //on generer et retourne l'affichage de la pagination si elle a lieu d'etre
  public function pagination($page,$nb_page,$route,$arg='')
  {
    $html = '';

    if($nb_page > 1){ $html .='<br/>';};
    $html .='<div class="pagin">';
    $argumentFull='';

    if(!empty($arg)){
      foreach ($arg as $key => $value) {
        $argumentFull[$key] = $value ;
      }
    }

    if($page == $nb_page && $page != 1){
      $argumentFull['page'] = ($page-1);
      $html .='<a href="'.CustomController::generateUrl($route,$argumentFull).'"> << </a>';
      $html .= $this->liste($nb_page,$route,$page,$argumentFull);
    }elseif ($page < $nb_page && $page > 1) {
      $argumentFull['page'] = ($page-1);
      $html .= '<a href="'.CustomController::generateUrl($route,$argumentFull).'"> << </a>';
      $html .= $this->liste($nb_page,$route,$page,$argumentFull);
      $argumentFull['page'] = ($page+1);
      $html .= '<a href="'.CustomController::generateUrl($route,$argumentFull).'">  >> </a>';
    }elseif($page == 1 && $nb_page > 1){
      $argumentFull['page'] = ($page+1);
      $html .= $this->liste($nb_page,$route,$page,$argumentFull);
      $html .= '<a href="'.CustomController::generateUrl($route,$argumentFull).'">  >> </a>';
    }
    $html .='</div>';
    if($nb_page > 1){
      $html .='<br/>';
    }
    return $html;
  }
  public function liste($nb_page,$route,$page,$argumentFull)
  {
    $html ='';
    for($i=1; $i <= $nb_page; $i++) {
      if($i == $page){
        $argumentFull['page'] = $i;
        $style = '<span class="actuel"><a href="'.CustomController::generateUrl($route,$argumentFull).'">'.$i.'</a></span>';
      }else {
        $argumentFull['page'] = $i;
        $style = '<span class="voisin"><a href="'.CustomController::generateUrl($route,$argumentFull).'">'.$i.'</a></span>';
      }

      if($i ==1 && $i != $page){
        $html .= $style;
      }elseif($i ==1 && $i == $page){
        $html .= $style.'<span class="voisin">...</span>';
      }elseif($i == $nb_page  && $i != $page){
        $html .= $style;
      }elseif($i == $nb_page  && $i == $page){
        $html .= '<span class="voisin">...</span>'.$style;
      }elseif($i == $page) {
        $html .= '<span class="voisin">...</span>'.$style.'<span class="voisin">...</span>';
      }
    }
    return $html;
  }
}
