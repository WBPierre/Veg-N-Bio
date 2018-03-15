<?php

require_once "config/config.php";
$error = false;
$success = false;
if(isset($_GET['error'])){
	$error = true;
}
if(isset($_GET['url']) && preg_match('/error/',$_GET['url'])){
	$error = true;
}
if(isset($_GET['success'])){
	$success = true;
}
if(isset($_GET['url']) && preg_match('/success/',$_GET['url'])){
	$success = true;
}
if(isset($_SESSION['adminLog']) && !empty($_SESSION['adminLog']) && $_SESSION['adminLog'] == true){
	switch($_GET['url']){
		case 'employeesManagement':
			$data = new EmployeeManagerController();
			$array = $data->getAllEmployees();
			$string = LanguageController::translate('dashboard');
			echo $twig->render('employeesManagement/employeesManagement.twig', [ 'lang' => $_SESSION['lang'], 'trans' => $string, 'employees' => $array, 'success' => $success ] );
			break;
		default:
			$string = LanguageController::translate('dashboard');
			echo $twig->render('dashboard/dashboard.twig', [ 'trans' => $string ] );
	}
}else{
	$string = LanguageController::translate('login');
	echo $twig->render('login/login.twig', [ 'trans' => $string, 'error'=>$error ] );
}

