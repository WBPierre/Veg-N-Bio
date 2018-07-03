<?php

/**
 * @Author: Pierre
 * @Date:   2018-03-09 10:00:43
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-12 11:58:01
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
					$_SESSION['access_level'] = intval($employee[0]['access_level']);
					$_SESSION['id'] = intval($employee[0]['id']);
					$rest = $data->fetchAll('SELECT id_restaurant FROM vnb_contract WHERE id_employee = '.$employee[0]['id']);
					$_SESSION['id_restaurant'] = intval($rest[0]['id_restaurant']);
				}else{
					$error = true;
				}
			}else{
				$error = true;
			}			
		}else{
			$error = true;
		}
		break;
    case 'addDiscount':
        if($check){
            $array = $validator->treatData();
            $db = new DatabaseController();
            $array['value'] = intval($array['value']);
            $array['duration'] = intval($array['duration']);
            if(isset($array['active']) && !empty($array['active']) && $array['active'] == "on"){
                $array['active'] = 1;
            }else{
                $array['active'] = 0;
            }
            if(!$db->insert('INSERT INTO vnb_discount(code, duration, value, active) VALUES (:code, :duration, :value, :active)',$array)){
                $error = true;
            }
        }else{
            $error = true;
        }
        break;
    case 'delDiscount':
        if($check){
            $array = $validator->treatData();
            $db = new DatabaseController();
            if(!$db->update('UPDATE vnb_discount SET active = 0 WHERE id = :id',$array)){
                $error = true;
            }
        }else{
            $error = true;
        }
        break;
	case 'modifyMenus':
		if($check){
			$data = $validator->treatData();
			if(!isset($data['active'])){
				$data['active'] = 0;
			}else{
				$data['active'] = 1;
			}
			$data['lang'] = $_SESSION['lang'];
			$request = new DatabaseController();
			if(!$request->update('UPDATE vnb_restaurant_menu, vnb_restaurant_menu_lang SET 
				vnb_restaurant_menu.type = :type,
				vnb_restaurant_menu.price = :price,
				vnb_restaurant_menu.active = :active,
				vnb_restaurant_menu_lang.name = :name 
				WHERE vnb_restaurant_menu.id = :id AND  vnb_restaurant_menu_lang.id_menu = :id AND vnb_restaurant_menu_lang.lang = :lang', $data)){
				$error = true;
			}
		}
		break;
	case 'productManagementModify':
		if($check){
			$data = $validator->treatData();
			if(!isset($data['menu_composit'])){
				$data['menu_composit'] = 0;
			}else{
				$data['menu_composit'] = 1;
			}
			if(!isset($data['active'])){
				$data['active'] = 0;
			}else{
				$data['active'] = 1;
			}
			$request = new DatabaseController();
			foreach($data as $key=>$value){
				if(substr($key,0,14) == 'id_composition'){
					$arrayCheck['id'] = intval(substr($key,14));
					$arrayCheck['name'] = $data['compo'.$arrayCheck['id']];
					$arrayCheck['quantity'] = intval($data['quantity'.$arrayCheck['id']]);
					unset($data[$key]);
					unset($data['compo'.$arrayCheck['id']]);
					unset($data['quantity'.$arrayCheck['id']]);
					if(!$request->update("UPDATE vnb_restaurant_product_composition SET
						name = :name,
						quantity = :quantity
						WHERE id = :id
						",$arrayCheck)){
						$error = true;
					}
				}
			}
			$textRequest = "UPDATE vnb_restaurant_product SET
				name = :name,
				description = :description,
				allergens = :allergens,
				price = :price,
				menu_composit = :menu_composit,
				active = :active";
			if($data['file'] != ""){
				$textRequest .= ", img = :file WHERE id = :id";
			}else{
				$textRequest .= " WHERE id = :id";
				unset($data['file']);
			}
			// die(var_dump($data));
			if(!$request->update($textRequest,$data)){
				$error = true;
			}
		}else{
			$error = true;
		}
		break;
	case 'delProduct':
		$data = $validator->treatData();
		$request = new DatabaseController();
		if(!$request->update("UPDATE vnb_restaurant_product SET 
				active = 0
				WHERE id = :id", $data)){
			$error = true;
		}
		break;
	case 'addProduct':
		if($check){
			
			$data = $validator->treatData();
			if(!isset($data['menu_composit'])){
				$data['menu_composit'] = 0;
			}else{
				$data['menu_composit'] = 1;
			}
			if(!isset($data['active'])){
				$data['active'] = 0;
			}else{
				$data['active'] = 1;
			}
			$request = new DatabaseController();
			$i = 0;
			foreach($data as $key=>$value){
				if(substr($key,0,10) == 'ingredient'){
					$id = intval(substr($key,10));
					if($value != ""){
						$arrayCheck[$i]['id_component'] = $data['ingredient'.$id];
						$arrayCheck[$i]['quantity'] = intval($data['quantity'.$id]);
						$i++;
					}
					unset($data['ingredient'.$id]);
					unset($data['quantity'.$id]);
				}
				if($key == "menuSelected"){
					foreach($value as $id_menu){
						if($id_menu != ""){
							$arrayMenu[]['id_menu'] = intval($id_menu);
						}
					}
					unset($data[$key]);
				}
			}
			if($data['price'] <= 0){
			    $error = true;
			    break;
            }
			// $data['id_restaurant'] = $_SESSION['id_restaurant'];
			$data['id_restaurant'] = 1;
			if(!$request->insert("INSERT INTO vnb_restaurant_product(id_restaurant, name, description, allergens, type, price, menu_composit, active, img) VALUES (:id_restaurant, :name, :description, :allergens, :type, :price, :menu_composit, :active, :file)",$data)){
				$error = true;
			}
			if(!$error){
				$id = $request->fetch('SELECT id FROM vnb_restaurant_product WHERE id = LAST_INSERT_ID()');
			}
			foreach($arrayCheck as $key=>$value){
				$compo['id_product'] = intval($id['id']);
				$compo['id_component'] = intval($value['id_component']);
				$compo['quantity'] = intval($value['quantity']);
				if(!$request->insert("INSERT INTO  vnb_restaurant_product_composition(id_product, id_component, quantity) VALUES (:id_product, :id_component, :quantity)",$compo)){
						$error = true;
					}
			}
			foreach($arrayMenu as $key => $value){
				$menu['id_menu'] = $value['id_menu'];
				$menu['id_product'] = intval($id['id']);
				if(!$request->insert('INSERT INTO vnb_restaurant_menu_product(id_menu, id_product) VALUES (:id_menu, :id_product)',$menu)){
					$error = true;
				}
			}
		}else{
			$error = true;
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
		}else{
			$error = true;
		}
		break;
    case 'userManagementModify':
        if($check){
            $data = $validator->treatData();
            $request = new DatabaseController();
            if($data['password'] === $data['passwordConfirm']){
                unset($data['passwordConfirm']);
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                if(!$request->update("UPDATE vnb_users SET 
                name = :name,
                firstname = :firstname,
                birthdate = :birthdate,
                phone = :phone,
                password = :password,
                email = :email WHERE id = :id",$data)){
                    $error = true;
                }
            }else{
                $error = true;
            }
        }else{
            $error = true;
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
    case 'delUser':
        $data = $validator->treatData();
        $request = new DatabaseController();
        if(!$request->update("UPDATE vnb_users SET 
				active = -1, 
				access_level = -1 
				WHERE id = :id", $data)){
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
			$identification = rand(11111111, 99999999);
			$data2 = [
				'id_employee' => intval($id['id']),
				'job' => 'Waiter',
				'identification' => $identification,
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
		}else{
			$error = true;
		}
		if(!$error){
            shell_exec("/var/www/dev/admin/admin/var/C/xmlParser/execute ".intval($id['id'])." ".intval($_SESSION['id_restaurant'])." 2>&1");
            shell_exec("/var/www/dev/admin/admin/var/C/QRcode/execute ".$data['name']."_".$data['firstname']." ".$identification." 2>&1");
        }
		break;
    case 'switchLang':
        if($check){
            $array = $validator->treatData();
            if($array['lang'] == "fr"){
                $_SESSION['lang'] = "fr";
            }else{
                $_SESSION['lang'] = "en";
            }
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
        break;
}
LinkController::redirect($error);
