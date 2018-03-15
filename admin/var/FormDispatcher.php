<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-09 10:00:43
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-14 14:33:53
 */
require_once "../config/config.php";

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('Location: '.$_SERVER['HTTP_REFERER']);
}

	$validator = new FormValidatorController($_POST);
	$check = $validator->isValid();

switch($_POST['formName']){

	case 'adminLogin':
		if($check){
			$_SESSION['adminLog'] = true;
			if(preg_match('/\?error/',$_SERVER['HTTP_REFERER'])){
				$url = $_SERVER['HTTP_REFERER'];
				$url = preg_replace('/\?error/', "", $url);
				header('Location: '.$url);
			}else{
				header('Location: '.$_SERVER['HTTP_REFERER']);
			}
		}else{
			if(preg_match('/error/', $_SERVER['HTTP_REFERER'])){
				header('Location: '.$_SERVER['HTTP_REFERER']);
			}else{
				header('Location: '.$_SERVER['HTTP_REFERER'].'?error');
			}
		}
		break;

	case 'employeeManagementModify':
		$error = false;
		if($check){
			$data = $validator->treatData();
			$request = new DatabaseController();
			// MODIFY TO SESSION ID
			if(!$request->update("UPDATE vnb_users SET vnb_users.firstname = '".$data[0]."', vnb_users.name =  '".$data[1]."',vnb_users.email =  '".$data[2]."', vnb_users.birthdate =  '".$data[3]."', vnb_users.phone =  '".$data[4]."' WHERE vnb_users.id = ".$_POST['id'])){
				$error = true;
			}
			if(!$request->update("UPDATE vnb_contract SET vnb_contract.contract_start = '".$data[5]."', vnb_contract.contract_end =  '".$data[6]."',vnb_contract.vacation_day =  '".$data[7]."',vnb_contract.vacation_day_total =  '".$data[8]."' WHERE vnb_contract.id_employee = ".$_POST['id'])){
				$error = true;
			}
			header('Location: '.$_SERVER['HTTP_REFERER'].'?success');
		}
		break;

}

