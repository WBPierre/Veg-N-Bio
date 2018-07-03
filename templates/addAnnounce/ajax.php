<?php

require_once "../../config/config.php";


if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['filePath'])){


    $db = new DatabaseController();

    $db->insert("INSERT INTO vnb_announce (id_producer, title, description, coverPicture) 
    VALUES(:id_producer, :title, :description, :coverPicture)",
        [
            'id_producer' => $_SESSION['id'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'coverPicture' => $_POST['filePath']
        ]);

    $last_id = $db->fetch("SELECT LAST_INSERT_ID() FROM vnb_announce");


    $products = $db->fetchAll("SELECT * FROM vnb_offers WHERE id_producer = :id AND state = :state",
        ['id' => $_SESSION['id'], 'state' => 0, ]);

    foreach($products as $product){
        $db->insert("INSERT INTO vnb_announce_products (id_announce, id_products) 
        VALUES(:id_announce, :id_products)", [ 'id_announce' => $last_id[0], 'id_products' => $product['id']]);
    }

    foreach($products as $product) {
        $db->update("UPDATE vnb_offers SET state = :state WHERE id = :id", ['state' => 2, 'id' => $product['id']]);
    }

    return '/marketPlace';
}
