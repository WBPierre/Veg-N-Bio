<?php

require_once "config/config.php";
$error = false;
$success = false;
if($_GET['url'] == NULL && preg_match('/error/',$_SERVER['REQUEST_URI'])){
	$url = '?error';
}else{
	$url = $_GET['url'];
}
if(preg_match('/error/',$url)){
	$error = true;
	$url = preg_replace('/\?error/', "", $url);
}

if(preg_match('/success/', $url)){
	$success = true;
	$url = preg_replace('/\?success/', "", $url);
}
if(isset($_SESSION['adminLog']) && !empty($_SESSION['adminLog']) && $_SESSION['adminLog'] == true){
	$string = LanguageController::translate('dashboard');
	switch($url){
		case 'employeesManagement':
			$data = new EmployeeManagerController();
			$array = $data->getAllEmployees();
			echo $twig->render('employeesManagement/employeesManagement.twig', [ 'lang' => $_SESSION['lang'], 'trans' => $string, 'employees' => $array, 'success' => $success ] );
        break;
        case 'salesInterface':
            $string = LanguageController::translate('dashboard');
            echo $twig->render('salesInterface/salesInterface.twig', [ 'lang' => $_SESSION['lang'], 'trans' => $string, 'sales' => $array, 'success' => $success ] );
        break;
		case 'addEmployee':
			echo $twig->render('employeesManagement/addEmployee.twig', [ 'lang' => $_SESSION['lang'], 'trans' => $string] );
			break;
        case 'menu':
            $string = LanguageController::translate('dashboard');
            echo $twig->render('menu/menu.twig', [ 'lang' => $_SESSION['lang'], 'trans' => $string, 'sales' => $array, 'success' => $success ] );
            break;
		default:
			echo $twig->render('dashboard/dashboard.twig', [ 'trans' => $string ] );
	}
}else{
	$string = LanguageController::translate('login');
	echo $twig->render('login/login.twig', [ 'trans' => $string, 'error'=>$error ] );
}

