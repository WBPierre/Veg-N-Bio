<?php
require_once "../config/config.php";

if($_SERVER['REQUEST_METHOD'] != 'GET'){
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
$error = false;
if(isset($_GET['active']) && !empty($_GET['active'])){
    $id = $_GET['active'];
    if(is_numeric($id)){
        $db = new DatabaseController();
        if(!$db->update('UPDATE vnb_users SET active = 1 WHERE id = :id', [ 'id' => $id ])){
            $error = true;
        }
    }
}
if(isset($_GET['disable']) && !empty($_GET['disable'])){
    $id = $_GET['disable'];
    if(is_numeric($id)){
        $db = new DatabaseController();
        if(!$db->update('UPDATE vnb_users SET active = 0 WHERE id = :id', [ 'id' => $id ])){
            $error = true;
        }
    }
}

LinkController::redirect($error);