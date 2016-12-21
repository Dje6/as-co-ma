<?php
namespace Controller\admin ;

use \Controller\admin\ContactController;
use \Model\ContactModel;
/**
 *
 */
class ReponseController extends ContactController
{
  public function accepte($id,$orga,$slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){
        

      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function plusInfo($id,$orga,$slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){

      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function refuse($id,$orga,$slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){

      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function Repondre($id,$orga,$slug)
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('Admin',ucfirst($orga),$slug)){

      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
  public function RepondreUser($id)
  {
    if(isset($_SESSION['user']))
    {

    }else{
      $this->redirectToRoute('racine_form');
    }
  }
}

 ?>
