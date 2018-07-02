<?php

/**
 * @Author: Pierre
 * @Date:   2018-04-16 17:50:14
 * @Last Modified by:   Pierre
 * @Last Modified time: 2018-04-17 15:57:41
 */

require_once "../../config/config.php";
$error = false;
$menu = false;
$data = json_decode($_POST['data'],TRUE);
if($data == NULL || empty($data)){
	$error = true;
}
$i = 0;
$total = 0;
foreach($data as $array){
	foreach($array as $key=>$value){
		$treat = htmlspecialchars($value);
		if($treat != $value || empty($treat)){
			$error = true;
		}
		if($key == '0'){
			$arr[$i]['menu'] = true;
			$menu = true;
		}
		if(!array_key_exists('0', $array)){
			$array[$i]['menu'] = false;
		}
		$arr[$i][$key] = $value;
		if($key === 'total'){
			$total = $total + intval($value);
		}

	}
	$i++;
}
if($error){
	echo false;
	die();
}
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
	$id_user = $_SESSION['id'];
}else{
	$id_user = NULL;
}
$send = [
	'id_restaurant' => $_SESSION['id_restaurant'],
	'id_user' => $id_user,
	'state' => 0,
	'total' => $total,
	'type' => 0
];
$db = new DatabaseController();
if(!$db->insert('INSERT INTO vnb_order(id_restaurant, id_user, state, total, type) VALUES ( :id_restaurant, :id_user, :state, :total, :type)',$send)){
	$error = true;
}

if(!$error){
	$id = $db->fetch('SELECT id FROM vnb_order WHERE id = LAST_INSERT_ID()');
}
$id = $id['id'];
foreach($arr as $key=>$value){
	if($value['menu']){
		$menuArray = [
			'id_order' => $id,
			'id_menu' => $value['id'],
			'quantity' => $value['quantity']
		];
		if(!$db->insert('INSERT INTO vnb_order_menu(id_order, id_menu, quantity) VALUES (:id_order, :id_menu, :quantity)',$menuArray)){
			$error = true;
			break;
		}
		if(!$error){
			$id_menu = $db->fetch('SELECT id FROM vnb_order_menu WHERE id = LAST_INSERT_ID()');
		}
		for($i = 0;$i<4;$i++){
			if(isset($value[$i]) && !empty($value[$i])){
				if(!$db->insert('INSERT INTO vnb_order_menu_product(id_order_menu, id_product) VALUES (:id_order_menu, :id_product)',[ 'id_order_menu' => $id_menu['id'], 'id_product' => $value[$i] ])){
					$error = true;
					die();
				}
			}
		}
	}else{
		$insert = [
			'id_order' => $id,
			'id_product' => $value['id'],
			'quantity' => $value['quantity']
		];
		if(!$db->insert('INSERT INTO vnb_order_product(id_order, id_product, quantity) VALUES (:id_order, :id_product, :quantity)',$insert)){
			$error = true;
			die();
		}
	}
}
if(!$error){
    OrderController::updateStock();
    include_once "../../var/generateInvoice.php";
    getPDF($id);
}
if($error){
	echo false;
}else{
	echo true;
}
