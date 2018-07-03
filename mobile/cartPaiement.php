<?php

$db = new PDO('mysql:host=localhost;dbname=VegNBio', 'tristan', 'project');


$json = file_get_contents('php://input');

$obj = json_decode($json,true);

// INSERT INTO VNB_ORDER

$req = $db->prepare('INSERT INTO vnb_order(id_restaurant, id_user, state, total, type, token) VALUES(:id_restaurant, :id_user, :state, :total, :type, :token)');
$req->execute([
    'id_restaurant' => 1,
    'id_user' => $obj['user']['id'],
    'state' => 0,
    'total' => $obj['total'],
    'type' => 2,
    'token' => $obj['token']
]);

if(isset($_GET['token'])){
    $statement = $db->query('SELECT id FROM vnb_order ORDER BY id DESC LIMIT 1 WHERE token ='.$_GET['token']);
    $lastId = $statement->fetch();

    $req = $db->prepare('INSERT INTO vnb_order_product(id_order, id_product, quantity) VALUES(:id_order, :id_product, :quantity)');
    for($i = 0; $i < count($obj['products']); $i++){
        $req->execute([
            'id_order' => $lastId['id'],
            'id_product' => $obj['products'][$i]['id'],
            'quantity' => 1
        ]);
    }
} else {
    $statement = $db->query('SELECT id FROM vnb_order ORDER BY id DESC LIMIT 1');
    $lastId = $statement->fetch();

    $req = $db->prepare('INSERT INTO vnb_order_product(id_order, id_product, quantity) VALUES(:id_order, :id_product, :quantity)');
    for($i = 0; $i < count($obj['products']); $i++){
        $req->execute([
            'id_order' => $lastId['id'],
            'id_product' => $obj['products'][$i]['id'],
            'quantity' => 1
        ]);
    }
}



echo json_encode($obj['token']);