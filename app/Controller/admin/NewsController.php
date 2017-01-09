<?php
namespace Controller\admin;

use \Controller\CustomController;
use \Model\NewsModel;
use \Model\AssocModel;
use \Model\AbonnesModel;
use \Model\MairieModel;
use \Service\Pagination;
use \Service\validationTools;
use \PHPMailer;
use \Controller\admin\PicturesController;

/**
 *
 */
class NewsController extends CustomController
{
  public function home($slug,$orga,$page=1)
  {

    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        $orga = $this->nettoyage($orga);
        $slug = $this->nettoyage($slug);
        $page = $this->nettoyage($page);

        if($orga == 'assoc'){
          $AssocModel = new AssocModel;
          $id_orga = $AssocModel-> FindElementByElement('id','slug',$slug);
        }elseif ($orga == 'mairie') {
          $MairieModel = new MairieModel;
          $id_orga = $MairieModel-> FindElementByElement('id','slug',$slug);
        }

        $limit = 5;
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

  //creer une news
  public function edit($slug,$orga)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        $orga = $this->nettoyage($orga);
        $slug = $this->nettoyage($slug);
        if($_POST){
          $r_POST = $this->nettoyage($_POST);

          $error['title'] = ValidationTools::textValid($r_POST['title'], 'titre',3,255);
          $error['content'] = ValidationTools::textValid($r_POST['content'], 'contenu',3,2000);
          $error['status'] = '';
          if($r_POST['status'] != 'Activer' && $r_POST['status'] != 'Desactiver'){
            $error['status'] = 'Choix impossible';
          }

          if(!ValidationTools::IsValid($error)){
            $this->show('admin/EditNews',['donnee' => $r_POST,'error' => $error,
            'orga' => $orga,'slug' => $slug]);
          }else{

            if($orga == 'assoc'){
              $AssocModel = new AssocModel;
              $id_orga = $AssocModel-> FindElementByElement('id','slug',$slug);
            }elseif ($orga == 'mairie') {
              $MairieModel = new MairieModel;
              $id_orga = $MairieModel-> FindElementByElement('id','slug',$slug);
            }
            $NewsModel = new NewsModel;

            unset($r_POST['submit']);
            unset($r_POST['capcha']);

            $r_POST['id_orga'] = $id_orga;
            $r_POST['orga'] = $orga;
            $dateDeCreation = date('Y-m-d H:i:s');
            $r_POST['created_at'] = $dateDeCreation;


            if($NewsModel->insert($r_POST,false)){
              if(!empty($_FILES['image']['name'])){
                $id_news = $NewsModel->FindElementByElement('id','created_at',$dateDeCreation);

                $PicturesController = new PicturesController;
                if($PicturesController->picturesPost($orga,$slug,'news',$id_news)){
                  $this->redirectToRoute('admin_'.$orga.'_news',['slug'=> $slug,'orga' =>$orga,'page' => 1]);
                }else {
                  $this->show('admin/EditNews',['orga' => $orga ,'slug' => $slug,
                  'confirmation'=> '<h3 class="titrecontact glyphicon-envelope red"> Une erreur est
                  survenue lors du telechargement de l\'image .</h3>']);
                }
              }else {
                $this->redirectToRoute('admin_'.$orga.'_news',['slug'=> $slug,'orga' =>$orga,'page' => 1]);
              }
            }else{
              $this->show('admin/EditNews',['orga' => $orga ,'slug' => $slug,
              'confirmation'=> '<h3 class="titrecontact glyphicon-envelope red"> Une erreur est survenue.</h3>']);
            }
          }
        }else {
          $this->show('admin/EditNews',['slug' => $slug,'orga' => $orga]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  //modifier une news
  public function update($slug,$orga,$id)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        $orga = $this->nettoyage($orga);
        $slug = $this->nettoyage($slug);
        $id = $this->nettoyage($id);
        if($_POST){
          $r_POST = $this->nettoyage($_POST);

          $error['title'] = ValidationTools::textValid($r_POST['title'], 'titre',3,255);
          $error['content'] = ValidationTools::textValid($r_POST['content'], 'contenu',3,2000);
          $error['status'] = '';
          if($r_POST['status'] != 'Activer' && $r_POST['status'] != 'Desactiver'){
            $error['status'] = 'Choix impossible';
          }
          if(!empty($r_POST['picture'])){
            //$error['picture'] = ;
          }

          if(!ValidationTools::IsValid($error)){
            $this->show('admin/EditNews',['donnee' => $r_POST,'error' => $error,
            'orga' => $orga,'slug' => $slug,'id'=>$id]);
          }else{
            if($orga == 'assoc'){
              $AssocModel = new AssocModel;
              $id_orga = $AssocModel-> FindElementByElement('id','slug',$slug);
            }elseif ($orga == 'mairie') {
              $MairieModel = new MairieModel;
              $id_orga = $MairieModel-> FindElementByElement('id','slug',$slug);
            }
            $NewsModel = new NewsModel;
            if(empty($r_POST['picture'])){
              unset($r_POST['picture']);//en attendan que Jessy est terminer ses preparatif
            }
            unset($r_POST['submit']);
            unset($r_POST['capcha']);

            $r_POST['updated_at'] = date('Y-m-d H:i:s');

            if($NewsModel->update($r_POST,$id)){

              if(!empty($_FILES['image']['name'])){
                $PicturesController = new PicturesController;
                if($PicturesController->picturesPost($orga,$slug,'news',$id)){
                  $this->redirectToRoute('admin_'.$orga.'_news',['slug'=> $slug,'orga' =>$orga,'page' => 1]);
                }else {
                  $this->show('admin/EditNews',['orga' => $orga ,'slug' => $slug,'id'=>$id,
                  'confirmation'=> '<h3 class="titrecontact glyphicon-envelope red"> Une erreur est
                  survenue lors du telechargement de l\'image .</h3>']);
                }
              }else {
                $this->redirectToRoute('admin_'.$orga.'_news',['slug'=> $slug,'orga' =>$orga,'page' => 1]);
              }
            }else{
              $this->show('admin/EditNews',['orga' => $orga ,'slug' => $slug,'id'=>$id,
              'confirmation'=> '<h3 class="titrecontact glyphicon-envelope red"> Une erreur est survenue.</h3>']);
            }
          }
        }else {
          $NewsModel = new NewsModel;
          $donnee = $NewsModel->FindNewsById($id);
          $this->show('admin/EditNews',['slug' => $slug,'orga' => $orga,'donnee'=>$donnee,'id'=>$id]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
//on supprime
  public function delete($slug,$orga,$id_news,$page=1)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        $orga = $this->nettoyage($orga);
        $slug = $this->nettoyage($slug);
        $id_news = $this->nettoyage($id_news);
        $page = $this->nettoyage($page);

        $DestroyController = new DestroyController;
        $resultat = $DestroyController->DeleteNews($id_news);

        if(!$resultat){
          $this->showErrors('Un problème est survenu lors de la suppression de l\'article.');
        }else {
           $this->redirectToRoute('admin_'.$orga.'_news',['slug'=> $slug,'orga' =>$orga,'page' => $page]);
        }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  public function status($slug,$orga,$id,$page=1)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          $orga = $this->nettoyage($orga);
          $slug = $this->nettoyage($slug);
          $id = $this->nettoyage($id);
          $page = $this->nettoyage($page);

          $NewsModel = new NewsModel;
          $oldStatus = $NewsModel->FindElementByElement('status','id',$id);
          if($oldStatus == 'Activer'){
            $newStatus = 'Desactiver';
          }elseif ($oldStatus == 'Desactiver') {
            $newStatus = 'Activer';
          }
          if($NewsModel->update(['status'=> $newStatus],$id)){
            $this->redirectToRoute('admin_'.$orga.'_news',['slug'=> $slug,'orga' =>$orga,'page' => $page]);
          }else {
            $this->showErrors('Un problème est survenu lors de la mise à jour du status.');
          }
        }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }

  public function newsletter($slug,$orga,$id,$page=1)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
          $orga = $this->nettoyage($orga);
          $slug = $this->nettoyage($slug);
          $id = $this->nettoyage($id);
          $page = $this->nettoyage($page);

          $NewsModel = new NewsModel;
          $laNews = $NewsModel->Find($id);

          if(empty($laNews['newsletter'])){

            $mail = new PHPMailer();
            $mail->CharSet = "utf8";
            //$mail->SMTPDebug = 3;                              // Enable verbose debug output
            $mail->isMail();
            $mail->setFrom('Webmaster@as-co-ma.fr', 'Mailer');

            $AbonnesModel = new AbonnesModel;

            if($orga == 'assoc'){
              $AssocModel = new AssocModel;
              $nom_Orga = $AssocModel-> FindElementByElement('nom','slug',$slug);
              $id_Orga = $AssocModel-> FindElementByElement('id','slug',$slug);
            }elseif ($orga == 'mairie') {
              $MairieModel = new MairieModel;
              $nom_Orga = $MairieModel-> FindElementByElement('nom','slug',$slug);
              $id_Orga = $MairieModel-> FindElementByElement('id','slug',$slug);
            }
            $listeAbonnes = $AbonnesModel->abonnes($id_Orga,$orga);

            foreach($listeAbonnes as $key => $value)
            {
              $mail->addAddress($value['mail']);
            }
            $mail->addReplyTo('no-reply@as-co-ma', 'Information');
            $mail->isHTML(true);    // Set email format to HTML
            $mail->Subject = 'NewsLetter '.$nom_Orga;
            $mail->Body    = $laNews['title'].'<br/><br/>'.$laNews['content'].'<br/><br/>
            Pour vous désinscrire de la newsletter <a href="'.$this->generateUrl('default_desinscription',[
            'orga' => $orga,'slug' => $slug],true).'">Cliquez ici</a>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if($mail->send()) {
              $NewsModel->update(['newsletter'=> date('Y-m-d H:i:s')],$id);
              $this->redirectToRoute('admin_'.$orga.'_news',['slug'=> $slug,'orga' =>$orga,'page' => $page]);
            }else {
              $this->showErrors('La newsletter n\'a pas pu être envoyée.');
            }
          }else{
            $this->redirectToRoute('admin_'.$orga.'_news',['slug'=> $slug,'orga' =>$orga,'page' => $page]);
          }
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
}
 ?>
