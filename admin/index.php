<?php

require_once "config/config.php";
if(isset($_SESSION['adminLog']) && !empty($_SESSION['adminLog']) && $_SESSION['adminLog'] == true){
	$string = LanguageController::translate('dashboard');
	echo $twig->render('dashboard/dashboard.twig', [ 'trans' => $string ] );
}else{
	$string = LanguageController::translate('login');
	echo $twig->render('login/login.twig', [ 'trans' => $string ] );
}

