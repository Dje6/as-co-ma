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

	/**
	 * Page CGU
	 */
	public function cgu()
	{
		$this->show('default/cgu');
	}

	/**
	 * Page AVENIR
	 */
	public function futur()
	{
		$this->show('default/futur');
	}

}
