<?php

require_once "../config/config.php";
if($_POST['log'] == "login"){
    if(isset($_POST['email'], $_POST['pwd']) && !empty($_POST['email']) && !empty($_POST['pwd'])){

        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['pwd']
        ];
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $db = new DatabaseController();
            $response = $db->fetchAll('SELECT * FROM vnb_users WHERE email = :email', [ 'email' => $data['email'] ]);
            if(count($response) == 1){
                $verify = password_verify($data['password'], $response[0]['password']);
                if($verify === true){
                    if($response[0]['active'] == 0){
                        die("1");
                    }
                    $_SESSION['logUser'] = true;
                    $_SESSION['id'] = $response[0]['id'];
                    $name = strtoupper(substr($response[0]['firstname'],0,1));
                    $name .= '.'.$response[0]['name'];
                    die($name);
                }else{
                    die("0");
                }
            }else{
                die("0");
            }
        }
    }else{
        die("0");
    }
}
if($_POST['log'] == 'signin'){
    if(isset($_POST['email'], $_POST['pwd'], $_POST['confirm']) && !empty($_POST['email']) && !empty($_POST['pwd']) && !empty($_POST['confirm'])){
        if($_POST['pwd'] !== $_POST['confirm']){
            die('0');
        }
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['pwd'],
            'active' => 0,
            'access_level' => 0
        ];
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $key = md5(uniqid());
            $data['activation_key'] = $key;
            $db = new DatabaseController();
            $request = $db->fetchAll('SELECT * FROM vnb_users WHERE email = :email',[ 'email' => $data['email']]);
            if( count($request) > 0){
                EmailController::sendActivation($request[0]['email'],$request[0]['activation_key']);
                die("2");
            }

            $response = $db->insert('INSERT INTO vnb_users(email,password, active, activation_key, access_level) VALUES (:email, :password, :active, :activation_key, :access_level)', $data);
            EmailController::sendActivation($data['email'],$data['activation_key']);
            die(var_dump($data));
        }
    }
    die("0");
}
die("0");
