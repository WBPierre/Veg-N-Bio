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

            if(isset($array['deliveryVar']) && !empty($array['deliveryVar'])){
                $_SESSION['order']['delivery'] = true;
                if(isset($array['adress']) && !empty($array['adress'])){
                    $_SESSION['order']['address'] = intval($array['adress']);
                }else{
                    $error = true;
                }
            }
            $_SESSION['order']['restaurant'] = $array['restaurant'];
            if(!$error){
                header('Location: /?url=order');
            }else{
                header('Location: /');
            }
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
        }else{
            $error = true;
        }
        LinkController::redirect($error);
        break;
    case 'addAddress':
        if($check){
            $array=$validator->treatData();
            if(strlen($array['zip_code']) != 5){
                $error = true;
                break;
            }
            $db = new DatabaseController();
            if(!$db->insert('INSERT INTO vnb_users_address(id_user, name, street, zip_code, city) VALUES (:id, :name, :street, :zip_code, :city)',$array)){
                $error = true;
            }
            break;
        }else{
            $error = true;
        }
        LinkController::redirect($error);
        break;
    case 'modifyProfile':
        if($check){
            $array = $validator->treatData();
            $db = new DatabaseController();
            if($array['password'] == ""){
                unset($array['password']);
            }else{
                if($array['password'] < 8){
                    $error = true;
                    break;
                }else{
                    $array['password'] = password_hash($array['password'], PASSWORD_DEFAULT);
                    if(!$db->update('UPDATE vnb_users SET phone = :phone, birthdate = :birthdate, password = :password WHERE id = :id_user',$array)){
                        $error = true;
                    }
                    break;
                }
            }

            if(!$db->update('UPDATE vnb_users SET phone = :phone, birthdate = :birthdate WHERE id = :id_user',$array)){
                $error = true;
            }
            break;
        }else{
            $error = true;
        }
        break;
        LinkController::redirect($error);
    default:

        $error = true;
        LinkController::redirect($error);
        break;
}
