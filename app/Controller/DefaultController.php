<?php
namespace Controller ;

use Controller\Controller;

class DefaultController extends CustomController
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show('default/home');
	}

}
