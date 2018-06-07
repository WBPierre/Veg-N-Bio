<?php

require_once "../config/config.php";

if($_SERVER['REQUEST_METHOD'] != 'GET'){
    header('Location: '.$_SERVER['HTTP_REFERER']);
}

$error = false;

if(isset($_GET['confirm']) && !empty($_GET['confirm'])){
    $id = htmlspecialchars($_GET['confirm']);
    $db = new DatabaseController();
    if(!$db->update('UPDATE vnb_offers SET state = 2 WHERE id=:id',[ 'id' => $id ])){
        $error = true;
    }
    $data = $db->fetchAll('SELECT * FROM vnb_offers WHERE id=:id',[ 'id' => $id ]);
    $getStock = $db->fetchALl('SELECT * FROM vnb_restaurant_stock WHERE id_component = '.$data['0']['id_product_component']);
    if(count($getStock) == 0){
        if(!$db->insert('INSERT INTO vnb_restaurant_stock(id_restaurant, id_component, stock_value) VALUES (:id_restaurant, :id_component, :stock_value)', [ 'id_restaurant' => intval($_SESSION['id_restaurant']), 'id_component' => intval($data['0']['id_product_component']), 'stock_value' => intval($data['0']['quantity'])])){
            $error = true;
        }
    }else{
        $total = intval($getStock['0']['stock_value']);
        $total = $total + intval($data['0']['quantity']);
        if(!$db->update('UPDATE vnb_restaurant_stock SET stock_value = '.$total.' WHERE id_component = '.$data['0']['id_product_component'])){
            $error = true;
        }
    }
    if(!$error){
        $getEmail = $db->fetchAll('SELECT email FROM vnb_users WHERE id = :id',[ 'id' => intval($data['0']['id_producer']) ]);
        EmailController::sendThanksProducer($getEmail['0']['email']);
    }
}
if(isset($_GET['order']) && !empty($_GET['order'])){
    $id = htmlspecialchars($_GET['order']);
    $db = new DatabaseController();
    if(!$db->update('UPDATE vnb_offers SET state = 1, vnb_restaurant_ordering = '.intval($_SESSION['id_restaurant']).' WHERE id=:id',[ 'id' => $id ])){
        $error = true;
    }
    $data = $db->fetchAll('SELECT * FROM vnb_offers WHERE id=:id',[ 'id' => $id ]);
    if(!$error){
        $getEmail = $db->fetchAll('SELECT email FROM vnb_users WHERE id = :id',[ 'id' => intval($data['0']['id_producer']) ]);
        EmailController::sendOrderConfirmation($getEmail['0']['email']);
    }

}
LinkController::redirect($error);