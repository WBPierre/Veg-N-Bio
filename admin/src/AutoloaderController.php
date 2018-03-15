<?php

	/*
		Class AutoloaderController
		Load automatically al the classes needed 
	 */
class AutoloaderController{


	/*
		Handle multiple autoloaders
	 */
	static function register(){

		spl_autoload_register(['AutoloaderController', 'Autoload']);
	}

	/*
		Handle all the requires needed
	 */
	static function Autoload($class){
		require ROOT.'/admin/src/'.$class.'.php';
	} 


}