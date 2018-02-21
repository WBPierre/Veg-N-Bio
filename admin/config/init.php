<?php
session_start();


/*
	Define Root directory
 */
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
/*
 Start to autoload all classes
 */
require_once ROOT.'/vendor/autoload.php';
require_once ROOT.'/admin/src/AutoloaderController.php';
AutoloaderController::register();

/*
	Prepare twig environment for templates rendering
 */

$loader = new Twig_Loader_Filesystem(ROOT.'/admin/templates');
$twig = new Twig_Environment($loader,[
	'cache' => false // Disable cache for dev
]);

/*
	Define Language of the current user
 */

if(!isset($_SESSION['lang']) && empty($_SESSION['lang'])){
	$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$_SESSION['lang'] = substr($lang, 0,2);
}