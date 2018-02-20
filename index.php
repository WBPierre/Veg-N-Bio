<?php

require 'vendor/autoload.php';

// Routing

// Render
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader,[
	'cache' => false
]);
$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$lang = substr($lang, 0,2);

switch($lang){
	case 'fr':
		$trans = file_get_contents('translations/'.$lang.'/'.$lang.'_translations.json');
		break;
	default:
		$trans = file_get_contents('translations/en/en_translations.json');
}
$trans = json_decode($trans);
echo $twig->render('home.twig', [ 'test' => $trans ] );