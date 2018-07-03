<?php
require_once "../config/config.php";
if($_SERVER['REQUEST_METHOD'] != 'GET') {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
$error = false;
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $id = intval($id);
    if(is_numeric($id)){
        $db = new DatabaseController();
        if(!$db->update('DELETE FROM vnb_users_address WHERE id = :id',[ 'id' => $id ])){
            $error = true;
        }
    }
}
LinkController::redirect($error);