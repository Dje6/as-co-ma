<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\NewsModel;
use \Model\AssocModel;
use \Model\MairieModel;
use \Service\Pagination;

/**
 *
 */
class NewsController extends CustomController
{
  public function home($slug,$orga,$page)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        if($orga == 'assoc'){
          $AssocModel = new AssocModel;
          $id_orga = $AssocModel-> FindElementByElement('id','slug',$slug);
        }elseif ($orga == 'mairie') {
          $MairieModel = new MairieModel;
          $id_orga = $MairieModel-> FindElementByElement('id','slug',$slug);
        }

        $limit = 3;
        //limit d'affichage par page
        $Pagination = new Pagination('articles');
        //on precise la table a exploiter
        $calcule = $Pagination->calcule_page('id_orga = \''.$id_orga.'\' AND
         orga = \''.$orga.'\' ',$limit,$page);

        //en premier on rempli le 'WHERE' , puis la nombre daffichage par page, et la page actuel
        //ce qui calcule le nombre de page total et le offset
        $affichage_pagination = $Pagination->pagination($calcule['page'],$calcule['nb_page'],
        'admin_'.$orga.'_news',['slug' => $slug,'orga' => $orga]);
        //on envoi les donnee calcule , la page actuel , puis le total de page , et la route sur quoi les lien pointe
        $NewsModel = new NewsModel;

        $donnees = $NewsModel->FindAllNews($id_orga,$orga,$limit,$calcule['offset']);
        $this->show('admin/news',['slug' => $slug,'donnees' => $donnees, 'pagination' => $affichage_pagination,
        'limit' => $limit,'orga' => $orga,'page' => $page]);
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

}
 ?>
