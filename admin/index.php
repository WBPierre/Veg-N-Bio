<?php

require_once "config/config.php";
if(isset($_SESSION['adminLog']) && !empty($_SESSION['adminLog']) && $_SESSION['adminLog'] == true){
	switch($_GET['url']){
		case 'employeesManagement':
			$string = LanguageController::translate('dashboard');
			echo $twig->render('employeesManagement/employeesManagement.twig', [ 'trans' => $string ] );
			break;
		default:
			$string = LanguageController::translate('dashboard');
			echo $twig->render('dashboard/dashboard.twig', [ 'trans' => $string ] );
	}
	// $string = LanguageController::translate('dashboard');
	// echo $twig->render('dashboard/dashboard.twig', [ 'trans' => $string ] );
}else{
	$string = LanguageController::translate('login');
	echo $twig->render('login/login.twig', [ 'trans' => $string, 'login'=>'admin' ] );
}

