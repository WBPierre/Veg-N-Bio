<?php
require_once "../config/config.php";
if($_SERVER['REQUEST_METHOD'] != 'GET'){
    die("0");
}
$error = false;
$data = json_decode($_GET['json'], true);
$order_type = 1;
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    $id = intval($_SESSION['id']);
}
if(isset($_SESSION['order']) && !empty($_SESSION['order'])){
    $restaurantID = intval($_SESSION['order']['restaurant']);
    if(isset($_SESSION['order']['delivery']) && !empty($_SESSION['order']['delivery'])){
        $delivery = 1;
        $address = intval($_SESSION['order']['address']);
    }else{
        $delivery = 0;
    }
}
$total = 0;
$db = new DatabaseController();
$i = 0;
foreach($data as $key=>$value){
    if(is_array($value)){
        $menu[$i]['id'] = $value['id'];
        $response = $db->fetchAll('SELECT * FROM vnb_restaurant_menu WHERE id_restaurant = '.$restaurantID.' AND id =:id AND active = 1',[ 'id' => $menu[$i]['id'] ]);
        $total += $response['0']['price'];
        foreach($value as $keyM=>$valueM){
            $nValue = htmlspecialchars($valueM);
            if($keyM != 'id'){
                $menu[$i][] = $nValue;
            }
        }
        $i++;
    }else{
        if($key == 'discount'){
            $disc = $db->fetchAll('SELECT * FROM vnb_discount WHERE vnb_discount.code = :code AND active = 1', [ 'code' => $value ]);
            if(count($disc) == 1){
                $count = $db->fetchAll('SELECT * FROM vnb_discount_used WHERE id_discount = :id_disc AND id_user = :id', [ 'id_disc' => $disc['0']['id'], 'id' => $id ]);
                if(count($count) != 0){
                    $discount = false;
                }else{
                    if(!($db->insert('INSERT INTO vnb_discount_used(id_discount, id_user) VALUES (:id_disc, :id)', [ 'id_disc' => $disc['0']['id'], 'id' => $id ]))){
                        $discount = $false;
                    }else{
                        $total -= intval($disc['0']['value']);
                    }
                }
            }
        }else{
            if(!is_array($value)){
                $getPrice = $db->fetchAll('SELECT * FROM vnb_restaurant_product WHERE active = 1 AND id_restaurant = '.$restaurantID.' AND id = :id', [ 'id' => $value ]);
                $total += $getPrice['0']['price'];
                $products[] = intval($value);
            }
        }
    }
}
// INSERT
$orderData = [
    'id_restaurant' => $restaurantID,
    'id_user' => $id,
    'state' => '0',
    'total' => $total,
    'type' => 1,
    'delivery' => $delivery,
    'adress' => $address
];
if(!$db->insert('INSERT INTO vnb_order(id_restaurant, id_user, state, total, type, delivery, adress) VALUES ( :id_restaurant, :id_user, :state, :total, :type, :delivery, :adress)',$orderData)){
    $error = true;
}

if(!$error){
    $idOrder = $db->fetch('SELECT id FROM vnb_order WHERE id = LAST_INSERT_ID()');
}
$idOrder = intval($idOrder['id']);
foreach($menu as $key=>$value){
    $dataMenu = [
        'id_order' => $idOrder,
        'id_menu' => intval($value['id']),
        'quantity' => 1
    ];
    if(!$db->insert('INSERT INTO vnb_order_menu(id_order, id_menu, quantity) VALUES (:id_order, :id_menu, :quantity)',$dataMenu)){
        $error = true;
        break;
    }
    if(!$error){
        $id_menu = $db->fetch('SELECT id FROM vnb_order_menu WHERE id = LAST_INSERT_ID()');
    }
    $idMenu = intval($id_menu['id']);
    foreach($value as $keyM=>$valueM){
        if($keyM != 'id'){
            if(!$db->insert('INSERT INTO vnb_order_menu_product(id_order_menu, id_product) VALUES (:id_order_menu, :id_product)',[ 'id_order_menu' => $idMenu, 'id_product' => intval($valueM) ])){
                $error = true;
                die();
            }
        }
    }
}

foreach($products as $key=>$value){
    $array = [
        'id_order' => $idOrder,
        'id_product' => intval($value),
        'quantity' => 1
    ];
    if(!$db->insert('INSERT INTO vnb_order_product(id_order, id_product, quantity) VALUES (:id_order, :id_product, :quantity)',$array)){
        $error = true;
        die();
    }
}
if(!$error){
    OrderController::updateStock();
    require "generateInvoice.php";
}
LinkController::redirect($error);
