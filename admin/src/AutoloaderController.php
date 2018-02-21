<?php

	/*
		Class AutoloaderController
		Charge automatiquement les classes nécessaires 
	 */
class AutoloaderController{


	/*
		Evite des problèmes sur la multiplication d'autoload.
	 */
	static function register(){

		spl_autoload_register(['AutoloaderController', 'Autoload']);
	}

	/*
		Gère les requires sur tous les controllers voulus
	 */
	static function Autoload($class){
		require ROOT.'/admin/src/'.$class.'.php';
	} 


}