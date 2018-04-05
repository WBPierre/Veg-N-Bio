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
if(isset($_SESSION['adminLog']) && !empty($_SESSION['adminLog']) && $_SESSION['adminLog'] == true && $_SESSION['access_level'] >= 1){
	$check['id'] = $_SESSION['id'];
	$string = LanguageController::translate('dashboard');
	$request = new DatabaseController();
	$today = date("Y-m-d");
	if(($getData = $request->fetchAll("SELECT vnb_contract_check.date_inserted FROM vnb_contract, vnb_contract_check WHERE vnb_contract.id_employee = :id AND vnb_contract_check.id_contract = vnb_contract.id AND vnb_contract_check.date_inserted LIKE '".$today."%'", $check)) == NULL){
		$error = true;
		$badge = false;
		$time = "";
	}else{
		$badge = true;
		$max = max(array_keys($getData));
		$time = substr($getData[$max]['date_inserted'],11,16);
	}
	switch($url){
		case 'employeesManagement':
			$data = new EmployeeManagerController();
			$array = $data->getAllEmployees();
			echo $twig->render('employeesManagement/employeesManagement.twig', [ 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string, 'employees' => $array, 'success' => $success ] );
			break;		
		case 'addEmployee':
			if($_SESSION['access_level'] >= 2){
				echo $twig->render('employeesManagement/addEmployee.twig', [ 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string] );
				break;
			}
		case 'manageMenus':
			if($_SESSION['access_level'] >= 2){
				echo $twig->render('employeesManagement/employeesManagement.twig', [ 'badge' => $badge, 'time' => $time, 'access_level' => $_SESSION['access_level'], 'lang' => $_SESSION['lang'], 'trans' => $string] );
				break;
			}
		default:
			echo $twig->render('dashboard/dashboard.twig', [ 'badge' => $badge, 'time' => $time,'id' => $_SESSION['id'], 'access_level' => $_SESSION['access_level'], 'trans' => $string ] );
	}
}else{
	$string = LanguageController::translate('login');
	echo $twig->render('login/login.twig', [ 'trans' => $string, 'error'=>$error ] );
}

