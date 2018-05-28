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
    case 'preOrder':
        if($check){
            $array = $validator->treatData();
            if(isset($array['deliveryVar']) && !empty($array['deliveryVar']) && $array['deliveryVar'] == "1"){
                $_SESSION['order']['delivery'] = true;
            }
            $_SESSION['order']['restaurant'] = $array['restaurant'];
           header('Location: /?url=order');
        }
        break;
    case 'switchLang':
        if($check){
            $array = $validator->treatData();
            if($array['lang'] == "fr"){
                $_SESSION['lang'] = "fr";
            }else{
                $_SESSION['lang'] = "en";
            }
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
        break;
}