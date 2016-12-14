<?php
namespace Controller\admin;

use \Controller\CustomController;


class SuperAdminController extends CustomController
{
  public function home()
  {
    if(isset($_SESSION['user']))
    {
      if($this->allowToTwo('SuperAdmin','Site',0)){
        $this->show('admin/SuperAdmin');
      }
    }else{
      $this->redirectToRoute('racine_form');
    }
  }
}
