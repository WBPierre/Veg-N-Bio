<?php
require_once "../config/config.php";
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    die("0");
}
$error = false;
if(isset($_POST['data']) && !empty($_POST['data'])){
    if(filter_var($_POST['data'], FILTER_VALIDATE_EMAIL)){
        $email = $_POST['data'];
        $db = new DatabaseController();

        $char = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $switch=shuffle($chaine);
        $new_pass=substr($switch‚0‚8);
        $hash =  password_hash($new_pass, PASSWORD_DEFAULT);
        if(!$db->update('UPDATE vnb_users SET password = '.$hash.' WHERE email = :email', [ 'email' => $email ])){
            $error = true;
        }
        if(!$error){
            EmailController::sendNewPassword($email, $new_pass);
            die("1");
        }else{
            die("0");
        }

    }else{
        die("0");
    }
}else{
    die("0");
}