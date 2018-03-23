<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-09 10:00:43
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-03-23 12:54:37
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
			$data = new DatabaseController();
			$number = $data->rowCount('SELECT * FROM vnb_users WHERE email = "'.$_POST['email'].'" AND active = 1 AND employee = 1');
			if($number == 1){
				$employee = $data->fetch('SELECT * FROM vnb_users WHERE email = "'.$_POST['email'].'" AND active = 1 AND employee = 1');
				if(password_verify($_POST['password'], $employee['password'])){
					$_SESSION['adminLog'] = true;
					if(preg_match('/error/', $_SERVER['HTTP_REFERER'])){
						$url = $_SERVER['HTTP_REFERER'];
						$url = preg_replace('/\?error/', "", $url);
						header('Location: '.$url);
					}else{
						header('Location: '.$_SERVER['HTTP_REFERER']);
					}
				}
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
			if($error){
				header('Location: '.$_SERVER['HTTP_REFERER'].'?error');
			}else{
				header('Location: '.$_SERVER['HTTP_REFERER'].'?success');
			}
			
		}
		break;

	case 'addEmployee':
		$error = false;
		if($check){
			$data = $validator->treatData();
			$request = new DatabaseController();
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			if(!$request->insert('INSERT INTO vnb_users(name, firstname, gender, email, password, birthdate, phone, active, employee) VALUES ("'.$_POST['name'].'","'.$_POST['firstname'].'", "'.$_POST['gender'].'","'.$_POST['email'].'","'.$password.'","'.$_POST['birthdate'].'","'.$_POST['phone'].'",1,1)')){
					$error = true;
				}
			if(!$error){
				$id = $request->fetch('SELECT id FROM vnb_users WHERE id = LAST_INSERT_ID()');
			}
			if(!$request->insert('INSERT INTO vnb_contract(id_employee, job, contract_type contract_start, contract_end, hour_number, vacation_day, vacation_day_total, active) VALUES ("'.$id['id'].'","Waiter","'.$_POST['contractRadio'].'","'.$_POST['contractStart'].'","'.$_POST['contractEnd'].'",'.$_POST['hourNumber'].'",0,'.$_POST['vacationDayTotal'].',1)')){
				$error = true;
			}
			if($error){
				header('Location: '.$_SERVER['HTTP_REFERER'].'?error');
			}else{
				header('Location: /admin/?url=employeesManagement?success');
			}
		}
		break;

}

