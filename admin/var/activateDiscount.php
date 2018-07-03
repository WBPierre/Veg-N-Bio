<?php

require_once "../config/config.php";

if($_SERVER['REQUEST_METHOD'] != 'GET'){
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
if(isset($_GET['yes']) && !empty($_GET['yes'])){
    if(is_numeric($_GET['yes'])){
        $db = new DatabaseController();
        if(!$db->update('UPDATE vnb_discount SET active = 0 WHERE id = :id', [ 'id' => $_GET['yes'] ])){
            die('ERROR');
        }
    }else{
        die('ERROR');
    }
}

if(isset($_GET['no']) && !empty($_GET['no'])){
    if(is_numeric($_GET['no'])){
        $db = new DatabaseController();
        if(!$db->update('UPDATE vnb_discount SET active = 1 WHERE id = :id', [ 'id' => $_GET['no'] ])){
            die('ERROR');
        }
    }else{
        die('ERROR');
    }
}
LinkController::redirect(false);