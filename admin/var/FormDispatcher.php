<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-09 10:00:43
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-05 12:27:54
 */
require_once "../config/config.php";

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('Location: '.$_SERVER['HTTP_REFERER']);
}

	$validator = new FormValidatorController($_POST);
	$check = $validator->isValid();
	$error = false;
switch($_POST['formName']){

	case 'adminLogin':
		if($check){
			$data = new DatabaseController();
			$array = $validator->treatData();
			unset($array['password']);
			$employee = $data->fetchAll('SELECT * FROM vnb_users WHERE email = :email AND active = 1 AND access_level >= 1', $array);
			$number = count($employee);
			if($number == 1){
				if(password_verify($_POST['password'], $employee[0]['password'])){
					$_SESSION['adminLog'] = true;
					$_SESSION['access_level'] = $employee[0]['access_level'];
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

	case 'checking':
		$data = $validator->treatData();
		$request = new DatabaseController();
		$selectContract = $request->fetch("SELECT id FROM vnb_contract WHERE id_employee = :id", $data);
		unset($selectContract[0]);
		if(!$request->update("INSERT INTO vnb_contract_check(id_contract) VALUES (:id)",$selectContract)){
			$error = true;
		}
		break;

	case 'employeeManagementModify':
		if($check){
			$data = $validator->treatData();
			$request = new DatabaseController();
			// MODIFY TO SESSION ID
			if(!$request->update("UPDATE vnb_users, vnb_contract SET 
				vnb_users.firstname = :firstname, 
				vnb_users.name = :name, 
				vnb_users.email = :email, 
				vnb_users.birthdate = :birthdate,  
				vnb_users.phone = :phone, 
				vnb_contract.contract_start = :contractStart, 
				vnb_contract.contract_end =  :contractEnd,
				vnb_contract.vacation_day =  :vacationDay, 
				vnb_contract.vacation_day_total =  :vacationDayTotal  
				WHERE vnb_users.id = :id AND vnb_users.id = vnb_contract.id_employee"
				, $data)){
				$error = true;
			}			
		}
		break;
	case 'delEmployee':
		$data = $validator->treatData();
		$request = new DatabaseController();
		if(!$request->update("UPDATE vnb_users, vnb_contract SET 
				vnb_users.access_level = 0,
				vnb_contract.active = 0
				WHERE vnb_users.id = :id AND vnb_contract.id_employee = :id", $data)){
			$error = true;
		}
		break;
	case 'addEmployee':
		if($check){
			$data = $validator->treatData();
			
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$data1 = [
				'name' => $data['name'],
				'firstname' => $data['firstname'],
				'gender' => intval($data['genderRadio']),
				'email' => $data['email'],
				'password' => $password,
				'birthdate' => $data['birthdate'],
				'phone' => $data['phone'],
				'active' => 1,
				'access_level' => 1
			];
			
			// die(var_dump($data1));
			$request = new DatabaseController();
			
			if(!$request->insert('INSERT INTO vnb_users(name, firstname, gender, email, password, birthdate, phone, active, access_level) VALUES (:name,:firstname, :gender, :email,:password,:birthdate,:phone, :active, :access_level)',$data1)){
					$error = true;
				}
			if(!$error){
				$id = $request->fetch('SELECT id FROM vnb_users WHERE id = LAST_INSERT_ID()');
			}
			$data2 = [
				'id_employee' => intval($id['id']),
				'job' => 'Waiter',
				'identification' => 77778888,
				'contract_type' => $data['contractRadio'],
				'contract_start' => $data['contractStart'],
				'contract_end' => $data['contractEnd'],
				'id_restaurant' => 1,
				'hour_number' => intval($data['hourNumber']),
				'vacation_day' => 0,
				'vacation_day_total' => intval($data['vacationDayTotal']),
				'active' => 1
			];
			if(!$request->insert('INSERT INTO vnb_contract(id_employee, job, identification, contract_type, contract_start, contract_end, id_restaurant, hour_number, vacation_day, vacation_day_total, active) VALUES (:id_employee, :job, :identification, :contract_type, :contract_start, :contract_end, :id_restaurant, :hour_number, :vacation_day, :vacation_day_total, :active)', $data2)){
				$error = true;
			}
		}
		break;

}
if($error){
	header('Location: '.$_SERVER['HTTP_REFERER'].'?error');
}else{
	header('Location: '.$_SERVER['HTTP_REFERER'].'?success');
}

