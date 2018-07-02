<?php
require_once "../config/config.php";
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    die("0");
}else{
    if(isset($_POST['code']) && !empty($_POST['code'])){
        $code = htmlspecialchars($_POST['code']);
        $db = new DatabaseController();
        $request = $db->fetchAll('SELECT * FROM vnb_discount WHERE code = :code',[ 'code' => $code ]);
        if(count($request) == 1){
            $retry = $db->fetchAll('SELECT * FROM vnb_discount_used WHERE id_discount = :code AND id_user = :id',[ 'code' => $code, 'id' => $_SESSION['id'] ]);
            if(count($retry) > 0){
                die("0");
            }else{
                die($request[0]['value']);
            }
        }else{
            die("0");
        }
    }
}

