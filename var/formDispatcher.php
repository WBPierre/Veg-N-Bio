<?php

require_once "../config/config.php";

if($_SERVER['REQUEST_METHOD'] != 'POST'){
header('Location: '.$_SERVER['HTTP_REFERER']);
}

$validator = new FormValidatorController($_POST);
$check = $validator->isValid();
$error = false;
switch($_POST['formName']){
    case 'userActivate':
        if($check){
            $array = $validator->treatData();
            $array['gender'] = $array['exampleRadios'];
            unset($array['exampleRadios']);
            $array['id']=$_SESSION['id'];
            $array['active'] = 1;
            $db = new DatabaseController();
            if(!$request = $db->update('UPDATE vnb_users SET  name=:name, firstname = :firstname, gender = :gender, phone=:phone, active=:active WHERE id=:id', $array)){
                $error = true;
            }
            if(!$error){
                header('Location: /');
            }
        }else{
            $error = true;
        }
        break;
}