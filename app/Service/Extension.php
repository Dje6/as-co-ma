<?php

namespace Service;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * @link http://platesphp.com/engine/extensions/ Documentation Plates
 */
class Extension implements ExtensionInterface
{

	/**
	 * Enregistre les nouvelles fonctions dans Plates
     * @param \League\Plates\Engine $engine L'instance du moteur de template
	 */
    public function register(Engine $engine)
    {
        $engine->registerFunction('AsOk', [$this, 'author']);
				$engine->registerFunction('in_multi_array', [$this, 'in_multi_array']);
    }
		public function author($role,$organisation,$id_orga)
	  {

	    $UserCustomModel = new \Model\UsersCustomModel();
	      if ($UserCustomModel->isGranted($role,$organisation,$id_orga)){
	        return true;
	      }
			return false;
	  }
		public function in_multi_array($string,$array){
			foreach ($array as $key => $value) {
				if(in_array($string,$value)){
					return true;
				}
			}
			return false;
		}

}
