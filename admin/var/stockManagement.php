<?php

require_once "../config/config.php";

if($_SERVER['REQUEST_METHOD'] != 'GET'){
    header('Location: '.$_SERVER['HTTP_REFERER']);
}

$error = false;

if(isset($_GET['confirm']) && !empty($_GET['confirm'])){
    $id = htmlspecialchars($_GET['confirm']);
    $id = intval($id);
    $db = new DatabaseController();
    if(!$db->update('UPDATE vnb_announce SET state = 2 WHERE id=:id',[ 'id' => $id ])){
        $error = true;
    }
    $data = $db->fetchAll('SELECT vnb_offers.* FROM vnb_offers, vnb_announce_products WHERE vnb_announce_products.id_announce=:id AND vnb_offers.id = vnb_announce_products.id_products',[ 'id' => $id ]);
    foreach($data as $key=>$value) {
        $total = 0;
        $getStock = $db->fetchAll('SELECT * FROM vnb_restaurant_stock WHERE id_component = ' . intval($value['id_product_component']) . ' AND id_restaurant = ' . intval($_SESSION['id_restaurant']));
        if (count($getStock) == 0) {
            if (!$db->insert('INSERT INTO vnb_restaurant_stock(id_restaurant, id_component, stock_value) VALUES (:id_restaurant, :id_component, :stock_value)', ['id_restaurant' => intval($_SESSION['id_restaurant']), 'id_component' => intval($value['id_product_component']), 'stock_value' => intval($value['quantity'])])) {
                $error = true;
            }

        } else {

            $total = intval($getStock['0']['stock_value']);
            $total = $total + intval($value['quantity']);
            if (!$db->update('UPDATE vnb_restaurant_stock SET stock_value = ' . $total . ' WHERE id_component = ' . $value['id_product_component'])) {
                $error = true;
            }
        }
    }
    if(!$error){
        $getEmail = $db->fetchAll('SELECT email FROM vnb_users WHERE id = :id',[ 'id' => intval($value['id_producer']) ]);
        EmailController::sendThanksProducer($getEmail['0']['email']);
    }
}
if(isset($_GET['order']) && !empty($_GET['order'])){
    $id = htmlspecialchars($_GET['order']);
    $id = intval($id);
    $db = new DatabaseController();
    if(!$db->update('UPDATE vnb_announce SET state = 1, id_restaurant_ordering = '.intval($_SESSION['id_restaurant']).' WHERE id=:id',[ 'id' => $id ])){
        $error = true;
    }
    $data = $db->fetchAll('SELECT vnb_users.email FROM vnb_users, vnb_announce WHERE vnb_announce.id_producer=:id',[ 'id' => $id ]);
    if(!$error){
        EmailController::sendOrderConfirmation($data['0']['email']);
    }

}
LinkController::redirect($error);